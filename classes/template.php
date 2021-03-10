<?php
// класс для подключения шаблонов и передачи данных в отображение
Class Template {

	private $template;
	private $controller;
	private $layouts;
	private $vars = array();
	
	function __construct($layouts, $controllerName){
		$this->layouts = $layouts;
		$arr = explode('_', $controllerName);
		$this->controller = strtolower($arr[1]);
	}
	
	// отображение
	function view($name, $data){
		// Инициализируем Twig
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem(DIR_TEMPLATE);
		$twig = new Twig_Environment($loader, array(
			'cache' => DIR_CACHE,
			'autoescape' => false,
			'debug' => true
		));
		
		$pathLayout = DS . 'layouts' . DS . $this->layouts . '.twig';
		$data['contentPage'] = DS . $name . '.twig';
		$data['base_href'] = HTTP_SERVER;

		echo $twig->render($pathLayout, $data);		
	}
}