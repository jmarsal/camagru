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

    public function addFilterOnImg($pathImg, $filter, $pow=null, $pow2=null, $pow3=null){
        $im = imagecreatefrompng($pathImg);
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
        if (!imagepng($im, $pathImg)){
            die('probleme');
        }
        imagedestroy($im);
    }

    /**
     * Enregistre une image png en base64 dans la Db
     * @param $idUser int Id de l'user a enregistre dans la table.
     * @param $imgPngBase64 string image au format png et en base 64 a enregistre dans la Db.
     * @param $pathToSaveImg string le dossier dans lequel l'image va etre sauvegarde.
     * @param $filter string le filtre a ajouter, par default à null.
     * @return $pathmin array pathmin['id'] = id de la miniature, pathmin['path'] = le path de la miniature.
     */
    public function savePhotoTmpToDb($idUser, $imgPngBase64, $pathToSaveImg, $filter=null){
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');

        list($type, $data) = explode(';', $imgPngBase64);
        list(, $type) = explode('/',$type);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $image_name = md5(uniqid()).'.'.$type;

        file_put_contents( $pathToSaveImg.DS.$image_name, $data);
        $_SESSION['img_name'] = $pathToSaveImg.DS.$image_name;
        if ($filter !== 'none'){
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

            $this->addFilterOnImg($pathToSaveImg.DS.$image_name, $filter, $pow, $pow2, $pow3);
        }

        $this->resizeImg($pathToSaveImg.DS.$image_name, $pathToSaveImg.DS.'min', $image_name.'Min', 150, 150);
//        insertion dans la db

        //return un tab avec path photo + id
        $sql = "INSERT INTO posts (`file`, `created`, `type`, `user_id`)
                      VALUES (:file, :created, :type, :user_id)";
	    try {
//	        Pour l'image original
            $pathBig = '/photo-users/'.$idUser.DS.substr($image_name, 0, -4);
	        $query = $this->db->prepare($sql);
	        $d = array("file" => $pathBig,
                        "created" => $date,
                        "type" => 'big',
                        "user_id" => $idUser);
	        $query->execute($d);
            $pathmin['idBig'] = $this->db->lastInsertId();
//	        pour la miniature
            $pathmin['path'] = '/photo-users/'.$idUser.DS.'min'.DS.substr
				($image_name, 0, -4).'Min'.'.jpg';
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
        $name = str_replace('.jpg', '', $name);
        $name = str_replace('.gif', '', $name);

//        $name = substr($name, 0, -6);
        $dimension = getimagesize($img);
        if (substr(strtolower($img), -4) == ".jpg"){ $image = imagecreatefromjpeg($img); }
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
        imagejpeg($miniature, $path.DS.$name.".jpg", 100);
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
		$sql = "SELECT file, created, id FROM posts WHERE type='min' && `user_id`=?";
		try {
			$query = $this->db->prepare($sql);
            $d = array($id);
			$query->execute($d);
			$row = $query->fetchAll();

			//trie de mon tab par date;
            function date_compare($a, $b)
            {
                $t1 = strtotime($a['created']);
                $t2 = strtotime($b['created']);
                return $t2 - $t1;
            }
            usort($row, 'date_compare');
//            die(var_dump($row));
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
            return substr($pathBig[0], 1).'.png';
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}
