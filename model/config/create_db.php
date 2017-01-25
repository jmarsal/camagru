<?
define( 'DB_NAME', 'CamagruDb' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );

class Data_base
{
	public function create_db() {
		// connexion à Mysql sans base de données
		$pdo = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PASSWORD);
 
		// création de la requête sql
		// on teste avant si elle existe ou non (par sécurité)
		$requete = "CREATE DATABASE IF NOT EXISTS `".DB_NAME."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
 
		// on prépare et on exécute la requête
		$pdo->prepare($requete)->execute();

		// connexion à la bdd
		$connexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
 
		// on vérifie que la connexion est bonne
		if($connexion){
			echo "connection avec la db";
		// on créer la requête
		$requete = $pdo->exec("CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`users` (
			`id` INT(5) NOT NULL AUTO_INCREMENT,
			`login` VARCHAR(255) NULL,
			`password` VARCHAR(255) NULL,
			`email` VARCHAR(255) NULL,
			PRIMARY KEY (`id`))
			ENGINE = MyISAM");
		
			$pdo->close();
		$pdo = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PASSWORD);
		// création de la requête sql
		// on teste avant si elle existe ou non (par sécurité)
		$requete = "CREATE DATABASE IF NOT EXISTS `".DB_NAME."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
 
		// on prépare et on exécute la requête
		$pdo->prepare($requete)->execute();


		$connexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
		// if($connexion){
		// 	echo "connection 2 avec la db";
		
		$requete = $pdo->exec("CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`posts` (
			`id` INT(5) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(255) NULL,
			`file` TEXT NULL,
			`created` DATETIME NULL,
			`user_id` (5) INT NULL,
			PRIMARY KEY (`id`),
			INDEX `fk_posts_users_idx` (`user_id` ASC))
			ENGINE = MyISAM");
		
		// connexion à la bdd
		// $connexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
		// on prépare et on exécute la requête
		// $connexion->prepare($requete)->execute();
		// }
		// "SET SQL_MODE=@OLD_SQL_MODE";
		// "SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS";
		// "SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS";
		}
	}
}