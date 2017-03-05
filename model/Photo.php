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

    /**
     * Enregistre une image png en base64 dans la Db
     * @param $idUser int Id de l'user a enregistre dans la table.
     * @param $imgPngBase64 string image au format png et en base 64 a enregistre dans la Db.
     * @param $pathToSaveImg string le dossier dans lequel l'image va etre sauvegarde.
     */
    public function savePhotoTmpToDb($idUser, $imgPngBase64, $pathToSaveImg){
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');

        list($type, $data) = explode(';', $imgPngBase64);
        list(, $type) = explode('/',$type);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $image_name = md5(uniqid()).'.'.$type;

        file_put_contents( $pathToSaveImg.$image_name, $data);
        $_SESSION['img_name'] = $pathToSaveImg.$image_name;

        $this->resizeImg($pathToSaveImg.DS.$image_name, $pathToSaveImg.DS.'min', $image_name.'Min', 150, 150);
//        insertion dans la db
	    $sql = "INSERT INTO posts (`file`, `created`, `type`, `user_id`)
                      VALUES (:file, :created, :type, :user_id)";
	    try {
//	        Pour l'image original
	        $query = $this->db->prepare($sql);
	        $d = array("file" => substr($image_name, 0, -4),
                        "created" => $date,
                        "type" => 'big',
                        "user_id" => $idUser);
	        $query->execute($d);
//	        pour la miniature
            $d = array("file" => BASE_URL.'/photo-users/min/'.substr
				($image_name, 0, -4).'Min'.'.jpg',
                "created" => $date,
                "type" => 'min',
                "user_id" => $idUser);
            $query->execute($d);
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

	public function countPreviewImg(){
		$sql = "SELECT file FROM posts WHERE `type`=?";
		try {
			$query = $this->db->prepare($sql);
			$min = 'min';
			$d = array($min);
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

	public function getPreviewImg(){
		$sql = "SELECT file FROM posts WHERE type='min'";
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
