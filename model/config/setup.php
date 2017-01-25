<?php

class Database
{
	private $_dbName;
	private $_dbHost;
	private $_dbUser;
	private $_dbPassword;
	private $_pdo;
	
	public function __construct($dbName, $dbHost = 'localhost', $dbUser = 'root',
								$dbPassword = 'root') {
		$this->$dbName =		$_dbName;
		$this->_dbHost =		$_dbHost;
		$this->_dbUser =		$_dbUser;
		$this->_dbPassword =	$_dbPassword;
		$this->_pdo = 			$this->_createDb($dbName);
		$this->_pdo =			$this->_createTables($dbName);
	}

	private function _getPod() {
		if ($this->_pdo === NULL) {
			$pdo = new PDO('mysql:host='.$this->_dbHost.';
								dbname='.$this->_dbName.'',
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
					' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
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
				PRIMARY KEY (`id`))
				ENGINE = MyISAM');
			$requete = $pdo->exec('CREATE TABLE IF NOT EXISTS '."$dbName".'.`posts` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(255) NULL ,
				`file` TEXT NULL ,
				`created` DATETIME NULL ,
				`user_id` INT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_posts_users_idx` (`user_id` ASC))
				ENGINE = MyISAM');
		}
		return $pdo;
	}
}