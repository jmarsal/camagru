<?php

/**
 * Created by PhpStorm.
 * User: jbmar
 * Date: 02/03/2017
 * Time: 14:02
 */

if (!isset($_SESSION)){
	session_start();
}
class Photo extends Model
{
    /**
     * Creer un repertoire sur le serveur.
     * @param $pathDirectory string Le path qui va etre creer si il n'existe pas deja.
     * @param $chmod int Les droits a mettre au dossier (rajouter un 0 devant ex: 0755).
     * @return bool return true si tout c'est bien passer, die + message d'erreur autrement.
     */
	public function createDirectoryIfNotExist($pathDirectory, $chmod){
		if (!is_dir($pathDirectory)) {
			if (!mkdir($pathDirectory, $chmod)){
				die("Directory creation problem !");
            }else {
				return true;
			}
		}
	}

	public function deleteDirectoryIfExist($pathDirectory){
        if (is_dir($pathDirectory)){
            $files = array_diff(scandir($pathDirectory), array('.','..'));
            foreach ($files as $file) {
                (is_dir("$pathDirectory/$file")) ? delTree("$pathDirectory/$file") : unlink("$pathDirectory/$file");
            }
            rmdir($pathDirectory);
        }
    }

    public function deletePrevInDb($id){
        $sql = "DELETE FROM posts WHERE `type`='min' && `user_id`=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($id);
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function is_empty_dir($src)
    {
        $h = opendir($src);
        $c = 0;
        while (($o = readdir($h)) !== FALSE)
        {
            if (($o != '.') and ($o != '..'))
            {
                $c++;
            }
        }
        closedir($h);
        if($c==0)
            return true;
        else
            return false;
    }

    public function findFilterAndPowForImg($filter){
        $arr = array();
        if ($filter === 'blur(5px)'){
            $arr[0] = 'blur(5px)';
        }
        else if ($filter === 'sepia(60%)'){
            $arr[0] = 'sepia(60%)';
        }
        else if ($filter === 'invert(100%)'){
            $arr[0] = IMG_FILTER_NEGATE;
        }
        else if ($filter === 'brightness(0.4)'){
            $arr[0] = IMG_FILTER_BRIGHTNESS;
            $arr[1] = -50;
        }
        else if ($filter === 'grayscale(100%)'){
            $arr[0] = IMG_FILTER_GRAYSCALE;
        }
        else if ($filter === 'hue-rotate(45deg)'){
            $arr[0] = IMG_FILTER_COLORIZE;
            $arr[1] = 0;
            $arr[2] = 100;
            $arr[3] = 5;
        }
        else if ($filter === 'hue-rotate(135deg)'){
            $arr[0] = IMG_FILTER_COLORIZE;
            $arr[1] = 0;
            $arr[2] = 50;
            $arr[3] = 50;
        }
        else if ($filter === 'hue-rotate(220deg)'){
            $arr[0] = IMG_FILTER_COLORIZE;
            $arr[1] = 0;
            $arr[2] = 5;
            $arr[3] = 100;
        }
        else if ($filter === 'hue-rotate(320deg)'){
            $arr[0] = IMG_FILTER_COLORIZE;
            $arr[1] = 50;
            $arr[2] = 5;
            $arr[3] = 100;
        }
        return $arr;
    }

    private function _addFilterOnImg($pathImg, $filter, $pow=null, $pow2=null, $pow3=null, $type){

        if ($type === 'png'){
            $im = imagecreatefrompng($pathImg);
        } else if ($type === 'jpeg'){
            $im = imagecreatefromjpeg($pathImg);
        } else if ($type === 'gif'){
            $im = imagecreatefromgif($pathImg);
        }
        if ($filter !== 'blur(5px)' && $filter !== 'sepia(60%)'){
            if ($pow !== null && !$pow2){
                imagefilter($im, $filter, $pow);
            } else if ($pow2 !== null && !$pow3){
                imagefilter($im, $filter, $pow, $pow2);
            }  else if ($pow3 !== null){
                imagefilter($im, $filter, $pow, $pow2, $pow3);
            }else{
                imagefilter($im, $filter);
            }
        } else if ($filter === 'sepia(60%)'){
            imagefilter($im,IMG_FILTER_GRAYSCALE);
            imagefilter($im,IMG_FILTER_COLORIZE,100,50,0);
        } else {
            for ($i = 0; $i < 25; $i++){
                imagefilter($im, IMG_FILTER_SMOOTH, 250);
                imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
            }
        }
        if ($type === 'png'){
            imagepng($im, $pathImg);
        } else if ($type === 'jpeg'){
            imagejpeg($im, $pathImg);
        } else if ($type === 'gif'){
            imagegif($im, $pathImg);
        }
        imagedestroy($im);
    }

    private function _addFilterObjOnImg($pathImg, $filterObj, $type){
        $pathFilterObj = 'webroot'.DS.'images'.DS.'objets'.DS.$filterObj.'.png';

        if ($type === 'png'){
            $origin = imagecreatefrompng($pathImg);
            $imgObj = imagecreatefrompng($pathFilterObj);
        } else if ($type === 'jpeg'){
            $origin = imagecreatefromjpeg($pathImg);
            $imgObj = imagecreatefrompng($pathFilterObj);
        } else if ($type === 'gif'){
            $origin = imagecreatefromgif($pathImg);
            $imgObj = imagecreatefrompng($pathFilterObj);
        }

        $widthObj = imagesx($imgObj);
        $heigthObj = imagesy($imgObj);

        if ($filterObj === 'dog'){
            imagecopy($origin, $imgObj, 220, 170, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'beardMustaches'){
            imagecopy($origin, $imgObj, 500, 400, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'chapeauPirate'){
            imagecopy($origin, $imgObj, 370, -45, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'epee'){
            imagecopy($origin, $imgObj, 345, 265, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'epeeLaser'){
            imagecopy($origin, $imgObj, 280, 210, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'largeMustache'){
            imagecopy($origin, $imgObj, 545, 380, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'lunette'){
            imagecopy($origin, $imgObj, 500, 100, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'monkey'){
            imagecopy($origin, $imgObj, 345, 315, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'policeHat'){
            imagecopy($origin, $imgObj, 435, 0, 0, 0, $widthObj, $heigthObj);
        } else if ($filterObj === 'prismaticMustache'){
            imagecopy($origin, $imgObj, 550, 400, 0, 0, $widthObj, $heigthObj);
        }
        if ($type === 'png'){
            imagepng($origin, $pathImg);
        } else if ($type === 'jpeg'){
            imagejpeg($origin, $pathImg);
        } else if ($type === 'gif'){
            imagegif($origin, $pathImg);
        }
    }

    /**
     * Enregistre une image png en base64 dans la Db
     * @param $idUser int Id de l'user a enregistre dans la table.
     * @param $imgPngBase64 string image au format png et en base 64 a enregistre dans la Db.
     * @param $pathToSaveImg string le dossier dans lequel l'image va etre sauvegarde.
     * @param $filter string le filtre a ajouter, par default à null.
     * @return $pathmin array pathmin['id'] = id de la miniature, pathmin['path'] = le path de la miniature.
     */
    public function savePhotoTmpToDb($idUser, $imgBase64, $pathToSaveImg, $filter = null, $filterObj = null){
        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d H:i:s');

        list($type, $data) = explode(';', $imgBase64);
        list(, $type) = explode('/',$type);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $image_name = md5(uniqid()).'.'.$type;

        file_put_contents($pathToSaveImg.DS.$image_name, $data);
        $_SESSION['img_name'] = $pathToSaveImg.DS.$image_name;
        if (!empty($filter) && $filter !== 'none'){
            $arrFilter = $this->findFilterAndPowForImg($filter);
            $filter = $arrFilter[0];
            if (isset($arrFilter[1])){
                $pow = $arrFilter[1];
            }else {
                $pow = null;
            }
            if (isset($arrFilter[2])){
                $pow2 = $arrFilter[2];
            }else {
                $pow2 = null;
            }
            if (isset($arrFilter[3])){
                $pow3 = $arrFilter[3];
            }else {
                $pow3 = null;
            }

            $this->_addFilterOnImg($pathToSaveImg.DS.$image_name, $filter, $pow, $pow2, $pow3, $type);
        }
        if (!empty($filterObj) && $filterObj !== 'noneObj') {
            $this->_addFilterObjOnImg($pathToSaveImg.DS.$image_name, $filterObj, $type);
        }

        $this->resizeImg($pathToSaveImg.DS.$image_name, $pathToSaveImg.DS.'min', $image_name.'Min', 150, 150);
//        insertion dans la db

        //return un tab avec path photo + id
        $sql = "INSERT INTO posts (`file`, `created`, `type`, `user_id`)
                      VALUES (:file, :created, :type, :user_id)";
        $sql2 = "INSERT INTO interactions (`post_id`)
                VALUES (:post_id)";
        $sql3 = "INSERT INTO `like` (`post_id`, `user_id`)
                            VALUES (:post_id, :user_id)";
        $sql4 = "INSERT INTO `comments` (`post_id`, `user_id`, `created`)
                            VALUES (:post_id, :user_id, :created)";
	    try {
//	        Pour l'image original
            if ($type === 'png'){
                $pathBig = '/photo-users/'.$idUser.DS.substr($image_name, 0, -4);
            } else if ($type === 'jpeg' || $type === 'gif'){
                $pathBig = '/photo-users/'.$idUser.DS.$image_name;
            }
	        $query = $this->db->prepare($sql);
	        $d = array("file" => $pathBig,
                        "created" => $date,
                        "type" => 'big',
                        "user_id" => $idUser);
	        $query->execute($d);
            $pathmin['idBig'] = $this->db->lastInsertId();
            /////
            $query2 = $this->db->prepare($sql2);
            $d2 = array("post_id" => $pathmin['idBig']);
            $query2->execute($d2);
            /////
            $query3 = $this->db->prepare($sql3);
            $d3 = array(
                "post_id" => $pathmin['idBig'],
                "user_id" => $idUser
            );
            $query3->execute($d3);
            /////
            $query4 = $this->db->prepare($sql4);
            $d4 = array(
                "post_id" => $pathmin['idBig'],
                "user_id" => $idUser,
                "created" => $date
            );
            $query4->execute($d4);
//	        pour la miniature
            if ($type === 'png'){
                $pathmin['path'] = '/photo-users/'.$idUser.DS.'min'.DS.substr
                    ($image_name, 0, -4).'Min'.'.jpg';
            } else if ($type === 'jpeg'){
                $pathmin['path'] = '/photo-users/'.$idUser.DS.'min'.DS.substr
                    ($image_name, 0, -5).'Min.jpg';
            } else if ($type === 'gif'){
                $pathmin['path'] = '/photo-users/'.$idUser.DS.'min'.DS.substr
                    ($image_name, 0, -4).'Min'.'.gif';
            }
            $d = array("file" => $pathmin['path'],
                "created" => $date,
                "type" => 'min',
                "user_id" => $idUser);
            $query->execute($d);
            $pathmin['idMin'] = $this->db->lastInsertId();
            return $pathmin;
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    /**
     * redimensionne une image au foemat jpg, png ou gif avec une sortie en jpg.
     * @param $img string l'image a resize ex: coucher-de-soleil.jpg.
     * @param $path string l'endroit ou sera sauvegarder l'image redimensionee.
     * @param $name string le nom de l'image redimmensionnee.
     * @param null $width int la nouvelle largeur de l'image, si null, 100 par default.
     * @param null $height int la nouvelle hauteur de l'image, si null, 100 par default.
     * @return bool true si tout c'est bien passe, false si probleme.
     */
    public function resizeImg($img, $path, $name, $width = null, $height = null){
        if (!$width){
            $width = 100;
        }
        if (!$height){
            $height = 100;
        }

        $name = str_replace('.png', '', $name);
        $name = str_replace('.jpeg', '', $name);
        $name = str_replace('.gif', '', $name);

//        $name = substr($name, 0, -6);
        $dimension = getimagesize($img);
        if (substr(strtolower($img), -4) == ".jpg" || substr(strtolower($img), -5) == ".jpeg"){
            $image = imagecreatefromjpeg($img);
        }
        else if(substr(strtolower($img), -4) == ".png"){ $image = imagecreatefrompng($img); }
        else if(substr(strtolower($img), -4) == ".gif"){ $image = imagecreatefromgif($img); }
        // L'image ne peut etre redimensionne
        else {
            return false;
        }

        // Création des miniatures
        // On cré une image vide de la largeur et hauteur voulue
        $miniature = imagecreatetruecolor($width, $height);

        // On va gérer la position et le redimensionnement de la grande image
        if ($dimension[0] > ($width/$height) * $dimension[1])
        {
            $dimY = $height;
            $dimX = $height * $dimension[0] / $dimension[1];
            $decalX =- ($dimX-$width) / 2;
            $decalY = 0;
        }
        if ($dimension[0] < ($width/$height) * $dimension[1])
        {
            $dimX = $width;
            $dimY = $width * $dimension[1] / $dimension[0];
            $decalY =- ($dimY-$height) / 2;
            $decalX = 0;
        }
        if ($dimension[0] == ($width/$height) * $dimension[1])
        {
            $dimX = $width;
            $dimY = $height;
            $decalX = 0;
            $decalY = 0;
        }

        // on modifie l'image crée en y plaçant la grande image redimensionné et décalée
        imagecopyresampled($miniature, $image, $decalX, $decalY, 0, 0, $dimX, $dimY, $dimension[0], $dimension[1]);

        // On sauvegarde le tout
        if(substr(strtolower($img), -4) !== ".gif"){
            imagejpeg($miniature, $path.DS.$name.".jpg", 100);
        } else {
            imagegif($miniature, $path.DS.$name.".gif", 100);
        }
        return true;
    }

	public function countPreviewImg($id){
		$sql = "SELECT file FROM posts WHERE `type`=? && `user_id`=?";
		try {
			$query = $this->db->prepare($sql);
			$min = 'min';
			$d = array($min, $id);
			$query->execute($d);
			$row = $query->fetchAll();
			$count = count($row);
			if ($count == 0) {
				return false;
			}
			return true;

		} catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	public function getPreviewImg($id){
		$sql = "SELECT file, created, id
                FROM posts
                WHERE type='min' && `user_id`=?
                ORDER BY created DESC ";
		try {
			$query = $this->db->prepare($sql);
            $d = array($id);
			$query->execute($d);
			$row = $query->fetchAll();
			return $row;

		} catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	public function destroyPhoto($tabIdPhoto){
	    $idMin = $tabIdPhoto['idMin'];
	    $idBig = $tabIdPhoto['idBig'];

        $sql = "SELECT file FROM posts WHERE id=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($idMin);
            $query->execute($d);
            $pathMin = $query->fetch();
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        $pathMin['file'] = substr($pathMin['file'], 1);
        if (unlink($pathMin['file'])){
            try {
                $query = $this->db->prepare($sql);
                $d = array($idBig);
                $query->execute($d);
                $pathBig = $query->fetch();
            } catch (PDOexception $e){
                print "Erreur : ".$e->getMessage()."";
                die();
            }
            $pathBig['file'] = substr($pathBig['file'], 1);
            if (unlink($pathBig['file'].'.png')){
                $sql = "DELETE FROM posts WHERE id=?";
                try {
                    $query = $this->db->prepare($sql);
                    $d = array($idMin);
                    $query->execute($d);
                } catch (PDOexception $e){
                    print "Erreur : ".$e->getMessage()."";
                    die();
                }
                try {
                    $query = $this->db->prepare($sql);
                    $d = array($idBig);
                    $query->execute($d);
                } catch (PDOexception $e){
                    print "Erreur : ".$e->getMessage()."";
                    die();
                }
            }
        }
    }

    public function getImg($id){
//	    Recupere file avec id et retourne file;
        $sql = "SELECT file FROM posts WHERE id=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($id);
            $query->execute($d);
            $pathBig = $query->fetch();
            $type = explode('.', $pathBig[0]);
            if (empty($type[1])){
                return substr($pathBig[0], 1).'.png';
            } else {
                return substr($pathBig[0], 1);
            }
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }

    public function destroyBigImgInGalerie($id){
        $sql = "SELECT file FROM posts WHERE id=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($id);
            $query->execute($d);
            $pathBig = $query->fetch();
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        $pathBig['file'] = substr($pathBig['file'], 1);
        if (unlink($pathBig['file'].'.png')){
            $sql = "DELETE FROM posts WHERE id=?";
            try {
                $query = $this->db->prepare($sql);
                $d = array($id);
                $query->execute($d);
            } catch (PDOexception $e){
                print "Erreur : ".$e->getMessage()."";
                die();
            }
            $sql = "DELETE FROM interactions WHERE post_id=?";
            try {
                $query = $this->db->prepare($sql);
                $d = array($id);
                $query->execute($d);
            } catch (PDOexception $e){
                print "Erreur : ".$e->getMessage()."";
                die();
            }
        }
    }

    public function saveNamePhotoToDb($id, $name){
        $idBig = $id - 1;
        $sql = "UPDATE posts SET `name`=? WHERE id=?";
        try {
            $query = $this->db->prepare($sql);
            $d = array($name, $idBig);
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
        try {
            $query = $this->db->prepare($sql);
            $d = array($name, $id);
            $query->execute($d);
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}
