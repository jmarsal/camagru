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
        $select = "SELECT `post_id`, `userLike` FROM `like` WHERE `post_id` = ?";
        try {
            $query = $this->db->prepare($select);
            $d = array($postId);
            $query->execute($d);
            $row = $query->fetch();
            if (!empty($row['userLike'])){
                $like = $row['userLike'];
                $like = ($like == 0) ? 1 : 0;
                $update = 1;
            }
            else {
                $like = 1;
                $update = 0;
            }
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        if ($update == 0){
            $insertUpdate = "INSERT INTO `like` (`userLike`, `post_id`, `user_id`)
                VALUES (:userLike, :post_id, :user_id)";
            $d = array(
                "userLike" => $like,
                "post_id" => $postId,
                "user_id" => $idUser
            );
        } else {
            $insertUpdate = "UPDATE `like` SET userLike=?
                            WHERE post_id=? && user_id=?";
            $d = array($like, $postId, $idUser);
        }
        try {
            $query = $this->db->prepare($insertUpdate);
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        return array(
            "like" => $like
        );
    }
}