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
        $sql = "SELECT interactions.like, interactions.nbComments, interactions.post_id
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
}