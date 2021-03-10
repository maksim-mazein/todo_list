<?php
Class Controller_Login Extends Controller_Base {

	public $layouts = "layout";

	function index() {
		
		$data['action'] = HTTP_SERVER . 'index.php?route=login';
		$data['registration'] = HTTP_SERVER . 'index.php?route=registration';
		
		$data['email'] = '';
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			if (!($_POST['email'])){
				$data['error_email'] = 'Укажите email!';
			} else {
				if (!(preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $_POST['email']))){
					$data['error_email'] = 'Нужно указать email в виде mail@domain.com';
				}
				$data['email'] = $_POST['email'];
			}
			if (!($_POST['password'])){
				$data['error_password'] = 'Укажите пароль!';
			}
			
			if (($_POST['email'] && $_POST['password'])){
				$model = new Model_Login();
				$user_id = $model->login($_POST);
				
				if ($user_id){
					$_SESSION['user_id'] = $user_id;
					header('Location: ' . HTTP_SERVER);
				} else {
					$data['error_warning'] = 'Неправильно указан email или пароль!';
				}
			}
		}
		
		$this->template->view('login', $data);
	}
}