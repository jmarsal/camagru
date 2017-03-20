<?php
class Post extends Model {

    public function getPhotosInDb(){
        $sql = "SELECT posts.file, posts.created, users.login
                FROM posts, users
                WHERE type=? && posts.user_id = users.id";
        try {
            $query = $this->db->prepare($sql);
            $d = array('big');
            $query->execute($d);
            $pathPhoto = $query->fetchAll();
            function date_compare($a, $b)
            {
                $t1 = strtotime($a['created']);
                $t2 = strtotime($b['created']);
                return $t2 - $t1;
            }
            usort($pathPhoto, 'date_compare');
            return $pathPhoto;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}