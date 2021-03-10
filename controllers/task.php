<?php
Class Controller_Task Extends Controller_Base {

	public $layouts = "layout";
	
	public function index() {
		$this->getForm();
	}

	function add() {
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			if ($_POST['text']){
				$model = new Model_Task();
				$model->addTask($_POST);
				
				$_SESSION['success'] = 'Новая задача добавлена!';
				
				header('Location: ' . HTTP_SERVER);
			} else {
				$_SESSION['error_text'] = 'Укажите задачу!';

				header('Location: ' . HTTP_SERVER . 'index.php?route=task');
			}
		}
	}
	
	function edit() {
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			if ($_POST['text']){
				$model = new Model_Task();
				$model->editTask($_POST);
				
				$_SESSION['success'] = 'Задача отредактирована!';

				header('Location: ' . HTTP_SERVER);
			} else {
				$_SESSION['error_text'] = 'Укажите задачу!';
				
				header('Location: ' . HTTP_SERVER . 'index.php?route=task&task_id=' . $_POST['task_id']);
			}
		}
	}
	
	protected function getForm() {
		$user_id = $_SESSION['user_id'];
		$model = new Model_Task();
		$data['user_info'] = $model->userInfo($user_id);
		
		$data['back_link'] = HTTP_SERVER;
		
		$data['logout'] = HTTP_SERVER . 'index.php?route=index/logout';
		
		if (isset($_SESSION['error_text'])) {
			$data['error_text'] = $_SESSION['error_text'];

			unset($_SESSION['error_text']);
		} else {
			$data['error_text'] = '';
		}
		
		if (isset($_GET['task_id'])){
			$task_id = $_GET['task_id'];

			$task = $model->getTask($task_id);

			$data['text'] = $task['text'];
			$data['title'] = 'Редактирование задачи';
			$data['edit'] = 'Изменить';
			$data['task_id'] = $task_id;
			
			$data['action'] = HTTP_SERVER . 'index.php?route=task/edit';
		} else {
			$data['text'] = '';
			$data['title'] = 'Новая задача';
			$data['edit'] = 'Добавить';
			$data['task_id'] = '';
			
			$data['action'] = HTTP_SERVER . 'index.php?route=task/add';
		}
		
		$this->template->view('task', $data);
	}
	
	function delete() {
		if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
			$model = new Model_Task();
			$model->deleteTask($_GET['task_id']);
			
			$_SESSION['success'] = 'Задача удалена!';

			header('Location: ' . HTTP_SERVER);
		}
	}
}