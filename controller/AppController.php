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
			$this->_getDataImg();
		} else {
	        $this->redirection();
        }
	}

	private function _getDataImg(){
		if (!empty($_POST)){
			$this->loadModel('Photo');
			$this->Photo->createDirectoryIfNotExist();
			list($type, $data) = explode(';', $_POST['getSrc']);
			list(, $type) = explode('/',$type);
			list(, $data) = explode(',', $data);
//			if(in_array(strtolower($type), $valid_ext))
//			{
				$data = base64_decode($data);
				$image_name = md5(uniqid()).'.'.$type;
				file_put_contents( REPO_PHOTO.$image_name, $data);
				$_SESSION['img_name'] = REPO_PHOTO.$image_name;
				echo "Upload suceed";
//			}
//			else
//				$message = "wrong extension";
			$_POST['getSrc'] = "";
		}
	}
}