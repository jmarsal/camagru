<?php

class Database
{
	private $_dbName;
	private $_dbHost;
	private $_dbUser;
	private $_dbPassword;
	private $_pdo;
	
	public function __construct($conf, $dbName) {
		$this->$dbName =		$dbName;
		$this->_dbHost =		$conf['host'];
		$this->_dbUser =		$conf['login'];
		$this->_dbPassword =	$conf['password'];
		$this->_pdo = 			$this->_createDb($dbName);
		$this->_pdo =			$this->_createTables($dbName);
	}

	private function _getPod() {
		if ($this->_pdo === null) {
		    $dsn = 'mysql:host='.$this->_dbHost.';dbname='.$this->_dbName;'charset=utf8mb4';
			$pdo = new PDO(     $dsn,
								$this->_dbUser,
								$this->_dbPassword);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_pdo = $pdo;
		}
		return $this->_pdo;
	}

	private function _createDb($dbName) {
		$pdo = $this->_getPod();
		$requete = 'CREATE DATABASE IF NOT EXISTS '."$dbName".
					' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci';
		$pdo->prepare($requete)->execute();
		return $pdo;
	}

	private function _createTables($dbName) {
		$pdo = $this->_getPod();
		if ($pdo) {
			$requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`users` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`login` VARCHAR(255) NULL DEFAULT NULL ,
				`password` VARCHAR(255) NULL DEFAULT NULL ,
				`email` VARCHAR(255) NULL DEFAULT NULL ,
				`cle` VARCHAR(255) NULL ,
				`actif` INT DEFAULT 0,
				`newsletter` INT DEFAULT 1,
				PRIMARY KEY (`id`))
				ENGINE = MyISAM');

			$requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`posts` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(255) NULL ,
				`file` TEXT NULL ,
				`created` DATETIME NULL ,
				`type` VARCHAR(255) NULL ,
				`user_id` INT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_posts_users_idx` (`user_id` ASC))
				ENGINE = MyISAM');

			$requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`mails` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`subject` VARCHAR(255) NULL ,
				`title` VARCHAR(255) NULL ,
				`message` TEXT NULL ,
				`from` VARCHAR(255) NULL ,
				PRIMARY KEY (`id`))
				ENGINE = MyISAM');

            $requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`interactions` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`comment` TEXT NULL ,
				`nbComments` INT NOT NULL DEFAULT 0 ,
				`nbLike` INT UNSIGNED NOT NULL DEFAULT 0 ,
				`post_id` INT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_posts_idx` (`post_id` ASC))
				ENGINE = MyISAM');

            $requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`like` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`userLike` INT UNSIGNED NOT NULL DEFAULT 0 ,
				`post_id` INT NULL ,
				`user_id` INT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_users_idx` (`user_id` ASC))
				ENGINE = MyISAM');

            $requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`comments` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`userComment` TEXT NULL ,
				`post_id` INT NULL ,
				`user_id` INT NULL ,
				`created` DATETIME NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_users_idx` (`user_id` ASC))
				ENGINE = MyISAM');
		}
		return $pdo;
	}

}