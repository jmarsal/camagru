<?php
class Post extends Model {

    public function getPhotosInDb(){
        $sql = "SELECT file FROM posts WHERE type=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array('big');
            $query->execute($d);
            $pathPhoto = $query->fetchAll();
//            die(var_dump($pathPhoto));
//            return substr($pathPhoto['file'], 1).'.png';
            return $pathPhoto;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}