<?php
class Post extends Model {

    public function getPhotosInDb(){
        $sql = "SELECT posts.id, posts.file, posts.created, users.login
                FROM posts, users
                WHERE type=? && posts.user_id = users.id
                ORDER BY posts.created DESC ";
        try {
            $query = $this->db->prepare($sql);
            $d = array('big');
            $query->execute($d);
            $pathPhoto = $query->fetchAll(PDO::FETCH_ASSOC);
            return $pathPhoto;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function getLikeCommentInDb(){
        $sql = "SELECT nbLike, nbComments, post_id
                FROM interactions";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            $row = $query->fetchAll();
            return $row;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function getLikeUserForPhoto($idUser){
        $sql = "SELECT `like`.userLike, `like`.post_id, `like`.user_id, posts.id
        FROM `like`, posts
        WHERE `like`.user_id =?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($idUser);
            $query->execute($d);
            $row = $query->fetchAll();
            return $row;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function setLikeForPhotoInDb($postId, $idUser){
        $insert = 0;
        $select = "SELECT `post_id`, `userLike`
                    FROM `like`
                    WHERE `post_id` = ? && `user_id` = ?";
        try {
            $query = $this->db->prepare($select);
            $d = array($postId, $idUser);
            $query->execute($d);
            $row = $query->fetch();
            if (!$row){
                $insert = 1;
                $like = 1;
            } else if ($row['userLike'] == 0){
                $like = 1;
            } else if ($row['userLike'] == 1){
                $like = 0;
            }
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        if ($insert == 1){
            $insertInLike = "INSERT INTO `like` (`userLike`, `post_id`, `user_id`)
                        VALUES (:userLike, :post_id, :user_id)";
            $d1 = array(
                "userLike" => $like,
                "post_id" => $postId,
                "user_id" => $idUser
            );
            try {
                $query = $this->db->prepare($insertInLike);
                $query->execute($d1);
            } catch (PDOexception $e){
                print "Erreur insert: ".$e->getMessage()."";
                die();
            }
        } else {
            $update = "UPDATE `like` SET userLike=?
                         WHERE post_id=? && user_id=?";
            $d = array($like, $postId, $idUser);
            try {
                $query = $this->db->prepare($update);
                $query->execute($d);
            } catch (PDOexception $e){
                print "Erreur : ".$e->getMessage()."";
                die();
            }
        }
        $newNbLike = $this->_modifyLikeInInteraction($like, $postId);
        return $newNbLike;
    }

    private function _modifyLikeInInteraction($like, $postId){
        $sql = "SELECT nbLike
                FROM interactions
                WHERE post_id=?";
        try{
            $query = $this->db->prepare($sql);
            $d = array($postId);
            $query->execute($d);
            $newNbLike = $query->fetch(PDO::FETCH_ASSOC);
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        if ($like == 0){
            if ($newNbLike['nbLike'] > 0){
                $like = -1;
            }
        }
        $newNbLike['nbLike'] += $like;
        $sql = "UPDATE interactions
                SET nbLike=?
                WHERE post_id=?";
        try{
            $query = $this->db->prepare($sql);
            $d = array($newNbLike['nbLike'], $postId);
            $query->execute($d);
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        return $newNbLike['nbLike'];
    }

    public function getCommentsInDb($postId){
        $sql = "SELECT *
                FROM comments
                WHERE post_id = ?
                ORDER BY created ASC";
        try{
            $query = $this->db->prepare($sql);
            $d = array($postId);
            $query->execute($d);
            $comments = $query->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function setCommemtInDb($idUser, $newComment, $idPost){
        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d H:i:s');

        //Recherche si l'idPost avec idUser se trouve deja dans la table comments
        $update = $this->_checkIfIdPostIdUserAlreadyInDb($idUser, $idPost);

        if ($update == 1){
            $this->_updateUserCommentInCommentsInDb($idPost, $date, $newComment);
        } else {
            $this->_insertUserCommentInCommentsInDb($idUser, $idPost, $date, $newComment);
        }
        $this->_incrementNbCommentsInDb($idPost);
        $info = array(
            "id_post" => $idPost,
            "id_user" => $idUser,
            "login" => $_SESSION['login'],
            "date" => $date,
            "comment" => $newComment
        );
        return $info;
    }

    public function getNbCommentsInDb($idPost){
        $sql = "SELECT nbComments
                FROM interactions
                WHERE post_id=?";
        try{
            $query = $this->db->prepare($sql);
            $d = array($idPost);
            $query->execute($d);
            $nbComments = $query->fetch(PDO::FETCH_ASSOC);
            return $nbComments['nbComments'];
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    private function _incrementNbCommentsInDb($idPost){
        // Recuperer le nbComment
        $nbComments = $this->getNbCommentsInDb($idPost);
        $sql = "UPDATE interactions
                SET nbComments=?
                WHERE post_id=?";
        try{
            $query = $this->db->prepare($sql);
            $d = array($nbComments + 1, $idPost);
            $query->execute($d);
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    private function _insertUserCommentInCommentsInDb($idUser, $idPost, $date, $newComment){
        $sql = "INSERT INTO comments (`userComment`, `post_id`, `user_id`, `created`)
                      VALUES (:userComment, :post_id, :user_id, :created)";
        try {
            $query = $this->db->prepare($sql);
            $d = array("userComment" => $newComment,
                "post_id" => $idPost,
                "user_id" => $idUser,
                "created" => $date);
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    private function _updateUserCommentInCommentsInDb($idPost, $date, $newComment){
        $sql = "UPDATE comments
                SET userComment=?, created=?
                WHERE post_id=?";
        try{
            $query = $this->db->prepare($sql);
            $d = array($newComment, $date, $idPost);
            $query->execute($d);
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    private function _checkIfIdPostIdUserAlreadyInDb($idUser, $idPost){
        $sql = "SELECT id
                FROM comments
                WHERE post_id=? && user_id=? && userComment=NULL";
        try{
            $query = $this->db->prepare($sql);
            $d = array($idPost, $idUser);
            $query->execute($d);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if (!$row){
                return 0;
            }
            return 1;
        }catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}