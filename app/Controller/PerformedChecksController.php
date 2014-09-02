<?php
App::uses('AppController', 'Controller');
/**
 * PerformedChecks Controller
 *
 * @property PerformedCheck $PerformedCheck
 * @property PaginatorComponent $Paginator
 */
class PerformedChecksController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow('performed_checks');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PerformedCheck->recursive = 0;
		$this->set('performedChecks', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PerformedCheck->exists($id)) {
			throw new NotFoundException(__('Invalid performed check'));
		}
		$options = array('conditions' => array('PerformedCheck.' . $this->PerformedCheck->primaryKey => $id));
		$this->set('performedCheck', $this->PerformedCheck->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PerformedCheck->create();
			if ($this->PerformedCheck->save($this->request->data)) {
				$this->Session->setFlash(__('The performed check has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The performed check could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PerformedCheck->exists($id)) {
			throw new NotFoundException(__('Invalid performed check'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PerformedCheck->save($this->request->data)) {
				$this->Session->setFlash(__('The performed check has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The performed check could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PerformedCheck.' . $this->PerformedCheck->primaryKey => $id));
			$this->request->data = $this->PerformedCheck->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PerformedCheck->id = $id;
		if (!$this->PerformedCheck->exists()) {
			throw new NotFoundException(__('Invalid performed check'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PerformedCheck->delete()) {
			$this->Session->setFlash(__('The performed check has been deleted.'));
		} else {
			$this->Session->setFlash(__('The performed check could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
		
	public function performed_checks() {
		App::uses('CakeEmail', 'Network/Email');
		
		$this->loadModel('User');	
		$user_to_send_email = $this->PerformedCheck->find('list', array('fields' => array('id', 'user_id'), 'conditions' => array('isComplete' => 0)));
		
		$emails_to_send_alert = array();
		foreach($user_to_send_email as $user_id) {
			// $this->User->unbindModelAll();
			
			$this->User->unbindModel(
				array(
					'hasMany' => array('Answer'),
					'belongsTo' => array('Group'),
					'belongsTo' => array('Group'),
					'hasAndBelongsToMany' => array('Vitamin'),
				)
			);
			
			$user_info = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('User.*', 'UserProfile.first_name', 'UserProfile.last_name')));
			$name = $user_info['UserProfile']['first_name']." ".$user_info['UserProfile']['last_name'];
			
			if(empty($user_info['User']['email'])) {
				$this->User->unbindModelAll();
				$user_info = $this->User->findById($user_info['User']['parent_id']);
			}
			
			$email = $user_info['User']['email'];
			
			// $result = $this->send($email, $name);
			// pr($result);
		}
		
		exit();
	}
	
	
	function send($email, $name) { 
		// endor('phpmailer'.DS.'class.phpmailer'); 
		App::import('Vendor', 'phpmailer', array('file' => 'phpmailer/class.phpmailer.php'));
		$mail = new PHPMailer(); 

		$mail->IsSMTP(); // we are going to use SMTP
		$mail->IsHTML(true);
		$mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = "AKIAIFE5UJ3F2OYW64CQ"; 
		$mail->Password = "AiMbFeTu00PxAlzDl2Cn60zDlPoYdVfZBvwChnbB3C50"; 
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

		$mail->From = "noman@iquantum.com.au"; 
		$mail->FromName = "noman@iquantum.com.au"; 
		$mail->AddAddress($email, $email);
		
		$mail->AddReplyTo("noman@iquantum.com.au", "noman@iquantum.com.au"); 

		$mail->CharSet  = 'UTF-8'; 
		$mail->WordWrap = 50;  // set word wrap to 50 characters

		$mail->IsHTML(true);  // set email format to HTML 

		$mail->Subject = "Incomplete Questionnaire";
		$mail->Body    = "You have an incomplete Nutrient Check please go back to the system to complete the check."; 

		if($mail->Send()) {
			return true;
		} else {
			return $mail->ErrorInfo; 
		}
    }
}
