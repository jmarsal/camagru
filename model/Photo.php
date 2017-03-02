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
	public function createDirectoryIfNotExist(){
		if (!is_dir(REPO_PHOTO)) {
			if (!mkdir(REPO_PHOTO, 0755)){
				die("Directory creation problem !");
			}else {
				return true;
			}
		}
	}
}