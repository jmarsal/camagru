<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 3:00 PM
 */
class ForgetIdController extends Controller
{
	public $login;
	public $email;

	public function accueil(){
		$this->loadModel('User');
		$this->render('pages/forgetId');

		if (isset($_ENV['email']) && isset($_ENV['login']) &&
			!empty($_ENV['email']) && !empty($_ENV['login'])){
			?><script>showPopup();</script><?php
		}
	}
}