<?php
class AppController extends Controller
{
	public $content_for_layout;

	public function __construct(){
		header("Location: ".BASE_URL.DS."view".DS."layout".DS."app_layout.php");
	}

	public function appCamagru(){
//		$this->content_for_layout = 'blabla';
		$this->render('camagru');
	}
}