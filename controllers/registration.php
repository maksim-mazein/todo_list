<?php
Class Controller_Registration Extends Controller_Base {

	public $layouts = "layout";

	function index() {
		
		$data['login'] = '';
		$data['firstname'] = '';
		$data['lastname'] = '';
		$data['email'] = '';
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
			if (!($_POST['login'])){
				$data['error_login'] = 'Укажите логин!';
			} else {
				$data['login'] = $_POST['login'];
			}
			if (!($_POST['firstname'])){
				$data['error_firstname'] = 'Укажите имя!';
			} else {
				$data['firstname'] = $_POST['firstname'];
			}
			if (!($_POST['lastname'])){
				$data['error_lastname'] = 'Укажите фамилию!';
			} else {
				$data['lastname'] = $_POST['lastname'];
			}
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
			
			if (($_POST['login'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['email'] && $_POST['password'])){
				$model = new Model_Registration();
				$user_id = $model->newUser($_POST);
				
				if ($user_id){
					$_SESSION['user_id'] = $user_id;
					header('Location: ' . HTTP_SERVER);
				} else {
					$data['error_warning'] = 'Указанный email уже зарегистрирован!';
				}
			}
		}
		
		$data['action'] = HTTP_SERVER . 'index.php?route=registration';
		$data['authorization'] = HTTP_SERVER . 'index.php?route=login';
		
		$this->template->view('registration', $data);
	}
}