<?php
App::uses('AppController', 'Controller');
/**
 * Answers Controller
 *
 * @property Answer $Answer
 * @property PaginatorComponent $Paginator
 */
class AnswersController extends AppController {
	
	var $uses = array('Answer', 'FactorsQuestion');
	
	function beforeFilter() {
		parent::beforeFilter();
		
		$user_id = $this->Session->read('Auth.User.id');
		if(empty($user_id)) {
			$this->Auth->allow('report');
		} else {
			$this->Auth->allow('report', 'load_date_report');
		}
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->layout = "public_dashboard";
		$this->Answer->recursive = 0;
		$this->set('answers', $this->Paginator->paginate(array('Answer.status' => 1)));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout = "public_dashboard";
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
		$this->set('answer', $this->Answer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "public_dashboard";
		if ($this->request->is('post')) {
			$this->Answer->create();
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('The answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answer could not be saved. Please, try again.'));
			}
		}
		$users = $this->Answer->User->find('list');
		$questions = $this->Answer->Question->find('list');
		$choices = $this->Answer->Choice->find('list');
		$this->set(compact('users', 'questions', 'choices'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout = "public_dashboard";
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('The answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
			$this->request->data = $this->Answer->find('first', $options);
		}
		$users = $this->Answer->User->find('list');
		$questions = $this->Answer->Question->find('list');
		$choices = $this->Answer->Choice->find('list');
		$this->set(compact('users', 'questions', 'choices'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Answer->id = $id;
		if (!$this->Answer->exists()) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$this->request->onlyAllow('post', 'delete');
		
		$this->request->data['Answer']['id'] = $id;
		$this->request->data['Answer']['status'] = 0;
		
		if ($this->Answer->save($this->request->data)) {
			$this->Session->setFlash(__('The answer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The answer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
/**
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function report($source = null) {
		
		if($source == "system") {
			$this->layout = "public_dashboard";
		} else {
			$this->layout = "iframe-layout";
		}
		
		$user_id = $this->Session->read('Auth.User.id');
		
		$factors = $this->Answer->Question->Factor->find('list', array('conditions' => array('Factor.status' => 0)));
		$latest_answer_date = $this->Answer->find('first', array('group' => array('Answer.created'), 'order' => array('Answer.created' => 'DESC'), 'conditions' => array('Answer.user_id' => $user_id)));
		
		$reports_per_factor = array();
		$previous_factor = 0;
		$current_factor = 0;
		$inc = 0;
		
		$temp_answer = $this->Session->read('temp_answers');
		
		if(empty($user_id) && !empty($temp_answer)) {
			$answers = $temp_answer;
			unset($temp_answer['TempAnswer']);
		} else {
			$this->Answer->unbindModelAll();
			$answers = $this->Answer->find('all', array('order' => array('Answer.factors_id ASC'), 'conditions' => array('Answer.user_id' => $user_id, 'Answer.created <=' => $latest_answer_date['Answer']['created'], 'Answer.created >=' => $latest_answer_date['Answer']['created'])));
		}
		
		foreach($answers as $key => $answer) {
			$question_id = $answer['Answer']['questions_id'];
			
			$this->FactorsQuestion->unbindModelAll();
			$associations = $this->FactorsQuestion->find('all', array('conditions' => array('questions_id' => $question_id)));
			
			foreach($associations as $association) {
				$answer['FactorsQuestion'] = $association['FactorsQuestion'];
				
				$factor_id = $answer['FactorsQuestion']['factors_id'];
				$inc++;
				
				$reports_per_factor[$factor_id][$inc] = $answer;
			}
		}
		
		ksort($reports_per_factor);
		
		$factors = $this->Answer->Question->Factor->find('list', array('conditions' => array('Factor.status' => 1)));
		
		$this->Answer->Question->Factor->Prescription->unbindModelAll();
		$prescriptions = $this->Answer->Question->Factor->Prescription->find('all', array('conditions' => array('Prescription.status' => 1)));
		
		
		/* ----------------------------------------------------------------- SCRIPT TO GROUP PRESCRIPTION BY FACTOR ------------------------------------------------------------- */
		
		$grouped_prescriptions = array();
		
		foreach($prescriptions as $key => $prescription) {
			if(!empty($prescription['Prescription']['factor_id'])) {
				$grouped_prescriptions[$prescription['Prescription']['factor_id']][$key] = $prescription;
			}
		}
		
		/* ----------------------------------------------------------------- SCRIPT TO GROUP PRESCRIPTION BY FACTOR ------------------------------------------------------------- */
		
		// pr($grouped_prescriptions);
		
		$this->set('factors', $factors);
		$this->set('grouped_prescriptions', $grouped_prescriptions);
		$this->set('reports_per_factor', $reports_per_factor);
	}
	
	
	
	###################################################### REPORT PER DATE FUNCTION HERE ##################################################
	
	public function load_date_report($date) {
		$this->layout = "ajax_plus_scripts";
		$user_id = $this->Session->read('Auth.User.id');
		
		$factors = $this->Answer->Question->Factor->find('list', array('conditions' => array('Factor.status' => 0)));
		$latest_answer_date = date('Y-m-d H:i:s', $date);
		
		$reports_per_factor = array();
		$previous_factor = 0;
		$current_factor = 0;
		$inc = 0;
		
		$temp_answer = $this->Session->read('temp_answers');
		
		if(empty($user_id) && !empty($temp_answer)) {
			unset($temp_answer['TempAnswer']);
			$answers = $temp_answer;
		} else {
			$this->Answer->unbindModelAll();
			$answers = $this->Answer->find('all', array('order' => array('Answer.factors_id ASC'), 'conditions' => array('Answer.user_id' => $user_id, 'Answer.created <=' => $latest_answer_date, 'Answer.created >=' => $latest_answer_date)));
		}
		
		foreach($answers as $key => $answer) {
			$question_id = $answer['Answer']['questions_id'];
			
			$this->FactorsQuestion->unbindModelAll();
			$associations = $this->FactorsQuestion->find('all', array('conditions' => array('questions_id' => $question_id)));
			
			foreach($associations as $association) {
				$answer['FactorsQuestion'] = $association['FactorsQuestion'];
				
				$factor_id = $answer['FactorsQuestion']['factors_id'];
				$inc++;
				
				$reports_per_factor[$factor_id][$inc] = $answer;
			}
		}
		
		ksort($reports_per_factor);
		
		$factors = $this->Answer->Question->Factor->find('list', array('conditions' => array('Factor.status' => 1)));
		
		$this->Answer->Question->Factor->Prescription->unbindModelAll();
		$prescriptions = $this->Answer->Question->Factor->Prescription->find('all', array('conditions' => array('Prescription.status' => 1)));
		
		
		/* ----------------------------------------------------------------- SCRIPT TO GROUP PRESCRIPTION BY FACTOR ------------------------------------------------------------- */
		
		$grouped_prescriptions = array();
		
		foreach($prescriptions as $key => $prescription) {
			if(!empty($prescription['Prescription']['factor_id'])) {
				$grouped_prescriptions[$prescription['Prescription']['factor_id']][$key] = $prescription;
			}
		}
		
		/* ----------------------------------------------------------------- SCRIPT TO GROUP PRESCRIPTION BY FACTOR ------------------------------------------------------------- */
		
		// pr($grouped_prescriptions);
		
		$this->set('factors', $factors);
		$this->set('grouped_prescriptions', $grouped_prescriptions);
		$this->set('reports_per_factor', $reports_per_factor);
	}
}