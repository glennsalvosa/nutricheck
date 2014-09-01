<?php
App::uses('AppController', 'Controller');
/**
 * SelectedFactorLogs Controller
 *
 * @property SelectedFactorLog $SelectedFactorLog
 * @property PaginatorComponent $Paginator
 */
class SelectedFactorLogsController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();	
		
		$user_id = $this->Session->read('Auth.User.id');
		if(!empty($user_id)) {
			$this->Auth->allow('add');
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
		$this->SelectedFactorLog->recursive = 0;
		$this->set('selectedFactorLogs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SelectedFactorLog->exists($id)) {
			throw new NotFoundException(__('Invalid selected factor log'));
		}
		$options = array('conditions' => array('SelectedFactorLog.' . $this->SelectedFactorLog->primaryKey => $id));
		$this->set('selectedFactorLog', $this->SelectedFactorLog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SelectedFactorLog->create();
			if ($this->SelectedFactorLog->save($this->request->data)) {
				$this->Session->setFlash(__('The selected factor log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The selected factor log could not be saved. Please, try again.'));
			}
		}
		$users = $this->SelectedFactorLog->User->find('list');
		$factors = $this->SelectedFactorLog->Factor->find('list');
		$this->set(compact('users', 'factors'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SelectedFactorLog->exists($id)) {
			throw new NotFoundException(__('Invalid selected factor log'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SelectedFactorLog->save($this->request->data)) {
				$this->Session->setFlash(__('The selected factor log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The selected factor log could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SelectedFactorLog.' . $this->SelectedFactorLog->primaryKey => $id));
			$this->request->data = $this->SelectedFactorLog->find('first', $options);
		}
		$users = $this->SelectedFactorLog->User->find('list');
		$factors = $this->SelectedFactorLog->Factor->find('list');
		$this->set(compact('users', 'factors'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SelectedFactorLog->id = $id;
		if (!$this->SelectedFactorLog->exists()) {
			throw new NotFoundException(__('Invalid selected factor log'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SelectedFactorLog->delete()) {
			$this->Session->setFlash(__('The selected factor log has been deleted.'));
		} else {
			$this->Session->setFlash(__('The selected factor log could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
