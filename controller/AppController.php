<?php
if (!isset($_SESSION)){
    session_start();
}
class AppController extends Controller
{
//	public $content_for_layout;

	public function appCamagru(){
	    if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) ||
            !empty($_COOKIE['camagru-log'])){
            $this->loadModel('User');
            $_SESSION['login'] = $_COOKIE['camagru-log'];
            $_SESSION['log'] = 1;
            $this->render('appCamagru', 'app_layout');
        } else {
	        $this->redirection();
        }
	}
}