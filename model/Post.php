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
            $pathPhoto = $query->fetchAll();
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
        $select = "SELECT `post_id`, `userLike`
                    FROM `like`
                    WHERE `post_id` = ?";
        try {
            $query = $this->db->prepare($select);
            $d = array($postId);
            $query->execute($d);
            $row = $query->fetch();
            if ($row['userLike'] == 1){
                $like = 0;
            } else {
                $like = 1;
            }
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }

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
        var_dump($like);
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
}