<?php

use \Phalcon\Mvc\View as View;

class ControllerBase extends \Phalcon\Mvc\Controller
{
	public function onConstruct()
	{
		$this->tag->setAutoescape(false);
		$this->tag->setDocType(Phalcon\Tag::HTML5);
		$this->tag->setTitleSeparator(' - ');

		// Записываем метатеги
		$this->tag->setTitle($this->config->site->title);

		// Список всех досок
		$this->boards = Chan::find('hide != 1');
		$this->view->setVars([
		    'boards' => $this->boards
		]);
		
		$this->assets
			 ->collection('js')
			 ->addJs('js/jquery.min.js', true, false)
			 ->addJs('js/main.js');
		$this->assets
			 ->collection('css')
			 ->addCss('http://fonts.googleapis.com/css?family=Open+Sans:300,400&amp;subset=latin,cyrillic-ext', false)
			 ->addCss('css/reset.css')
			 ->addCss('css/style.css');
	}
	/*
	 * Ахтунг! Возвращает json контент
	 */
	public function _returnJson($array)
	{
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		$this->response->setJsonContent($array);
		return false;
	}
	/*
	 * Таки тут все понятно
	 */
	public function _returnNotFound()
	{
		return $this->dispatcher->forward([
			'controller' => 'pages',
			'action' => 'show404'
		]);
	}
	public function _returnNoThreads()
	{
		$this->view->disableLevel(View::LEVEL_ACTION_VIEW);
		$this->view->partial("partial/nothread");
	}

}