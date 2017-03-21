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
        $sql = "SELECT interactions.nbLike, interactions.nbComments, interactions.post_id
                FROM interactions, posts";
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

    public function setLikeForPhotoInDb($postId, $idUser){
        $select = "SELECT post_id, userLike FROM like WHERE post_id = ?";
        try {
            $query = $this->db->prepare($select);
            $d = array($postId);
            $query->execute($d);
            $row = $query->fetch();
            if ((count($row)) == 1){
                $like = row['userLike'];
                $like = ($like == 0) ? 1 : 0;
            }
            else {
                $like = 1;
            }
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        $insert = "INSERT INTO like (`userLike`, `post_id`, `user_id`)
                VALUES (:userLike, :post_id, :user_id)";
        try {
            $query = $this->db->prepare($insert);
            $d = array(
                "userLike" => $like,
                "post_id" => $postId,
                "user_id" => $idUser
            );
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}