<?php
if (!isset($_SESSION)){
    session_start();
}

/**
 * Created by PhpStorm.
 * User: jbmar
 * Date: 20/03/2017
 * Time: 09:02
 */
class GalerieController extends Controller
{
    public function galerieCamagru(){
        if ((isset($_SESSION['log']) && $_SESSION['log'] == 1) && !empty
            ($_SESSION['login']) || !empty($_COOKIE['camagru-log'])){
            $this->loadModel('User');
            $this->loadModel('Photo');
            $this->loadModel('Post');

            $_SESSION['filter'] = "";
            $_SESSION['objFilter'] = "";
            $idLog = $this->User->getIdUser($_SESSION['login']);
            $this->Photo->deletePrevInDb($idLog);
            $_SESSION['galerie'] = $this->Post->getPhotosInDb();
            $this->render('galerieCamagru', 'app_layout');
            $_SESSION['galerie'] = "";
        }
    }

    public function appCamagru(){
        $this->redirection('app', 'appCamagru');
    }
}