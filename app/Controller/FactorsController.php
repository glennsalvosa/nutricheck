<?php
App::uses('AppController', 'Controller');
/**
 * Factors Controller
 *
 * @property Factor $Factor
 * @property PaginatorComponent $Paginator
 */
class FactorsController extends AppController {

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
		$this->Factor->recursive = 0;
		$this->set('factors', $this->Paginator->paginate());
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
		if (!$this->Factor->exists($id)) {
			throw new NotFoundException(__('Invalid factor'));
		}
		$options = array('conditions' => array('Factor.' . $this->Factor->primaryKey => $id));
		$this->set('factor', $this->Factor->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "public_dashboard";
		if ($this->request->is('post')) {
			$this->Factor->create();
			if ($this->Factor->save($this->request->data)) {
				$this->request->data['Factor']['user_id'] = $this->Session->read('Auth.User.id');
				$this->Session->setFlash(__('The factor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factor could not be saved. Please, try again.'));
			}
		}
		
		$factorTypes = $this->Factor->FactorType->find('list');
		$users = $this->Factor->User->find('list');
		$questions = $this->Factor->Question->find('list');
		$this->set(compact('users', 'questions', 'factorTypes'));
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
		if (!$this->Factor->exists($id)) {
			throw new NotFoundException(__('Invalid factor'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Factor->save($this->request->data)) {
				$this->Session->setFlash(__('The factor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factor could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Factor.' . $this->Factor->primaryKey => $id));
			$this->request->data = $this->Factor->find('first', $options);
		}
		
		$factorTypes = $this->Factor->FactorType->find('list');
		$users = $this->Factor->User->find('list');
		$questions = $this->Factor->Question->find('list');
		$this->set(compact('users', 'questions', 'factorTypes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Factor->id = $id;
		if (!$this->Factor->exists()) {
			throw new NotFoundException(__('Invalid factor'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Factor->delete()) {
			$this->Session->setFlash(__('The factor has been deleted.'));
		} else {
			$this->Session->setFlash(__('The factor could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}