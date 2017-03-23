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
            $this->Photo->deleteDirectoryIfExist(REPO_PHOTO.$idLog.DS.'min');
            $this->Photo->deletePrevInDb($idLog);
            $_SESSION['galerie'] = $this->Post->getPhotosInDb();
            $_SESSION['interactions'] = $this->Post->getLikeCommentInDb();
            $_SESSION['like'] = $this->Post->getLikeUserForPhoto($idLog);
            $this->render('galerieCamagru', 'galerie_layout');
            unset($_SESSION['galerie']);
            unset($_SESSION['interactions']);
        } else {
            $this->redirection();
        }
    }

    public function appCamagru(){
        $this->redirection('app', 'appCamagru');
    }

    public function delAjaxGalerie(){
        if (!empty($_POST['delImgGalerie'])){
            $this->loadModel('Photo');

            $this->Photo->destroyBigImgInGalerie($_POST['delImgGalerie']);
            return $this->json(200);
        } else {
            return $this->json(400);
        }
    }

    public function likeAjaxGalerie(){
        if (!empty($_POST['likeImgGalerie'])){
            $this->loadModel('Post');
            $this->loadModel('User');

            $idUser = $this->User->getIdUser($_SESSION['login']);
            $nbLike = $this->Post->setLikeForPhotoInDb($_POST['likeImgGalerie'], $idUser);
            return $this->json(200, [
                "nbLike" => $nbLike
            ]);
        } else {
            return $this->json(400);
        }
    }

    public function getCommentsAjaxGalerie(){
        if (!empty($_POST['commentsGalerie'])){
            $this->loadModel('Post');
            $this->loadModel('User');

            $_SESSION['comments'] = $this->Post->getCommentsInDb($_POST['commentsGalerie']);
            foreach ($_SESSION['comments'] as $v){
                if (!empty($v['userComment'])){
                    $login[] = $this->User->getLoginById($v['user_id']); // recup login par v['id']
                }
            }
//            var_dump($_SESSION['comments']);
            return $this->json(200, [
                "comments" => $_SESSION['comments'],
                "logins" => $login
            ]);
        }
        return $this->json(400);
    }
}