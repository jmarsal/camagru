

## Contributeurs
[@jmarsal](https://github.com/jmarsal)

## Note Final
`107/100`
# Projet Camagru 42
Ce projet vous propose de créer une petite application web permettant de réaliser des
montages basiques à l’aide de votre webcam et d’images prédéfinies.

Evidemment, ces images auront un canal alpha, sinon votre
superposition n’aurait pas la prestance escomptée !

Un utilisateur de votre site devra donc être capable de sélectionner une image dans
une liste d’images superposables (par exemple, des cadres ou des objets à l’utilité douteuse),
prendre une photo depuis sa webcam et admirer le résultat d’un montage digne
de James Cameron.

Toutes les images prises devront être publiques, likeables et commentables.

Qui dit site de pointe, dit language de pointe. Vous serez donc contraints d’utiliser
PHP pour réaliser ce projet.

Vous n’avez pas le droit d’utiliser de framework, micro-framework, librairies ou quoi
que ce soit provenant du monde extérieur (excepté les polices de caractères), aussi bien
pour le serveur que pour le client, donc pas de Bootstrap, pas de jQuery, pas de Symfony
etc... Seules les extensions instalées sur PHP (GD et les drivers SGBD, entre autres), ainsi
que les API javascript natives de vos navigateurs sont autorisées.

Vous devez utiliser l’interface d’abstraction PDO 1 pour acceder à votre base de données,
et définir le mode d’erreur 2
sur PDO::ERRMODE_EXCEPTION.

Vous êtes libres d’utiliser le serveur web de votre choix, que ce soit Apache, Nginx ou
même un built-in web server 3
.

L’ensemble de votre application devra être au minimum compatible sur Firefox (>=41) et Chrome (>= 46).

Votre site devra avoir une mise en page décente (c’est à dire au moins un header, une
section principale et un footer), être présentable sur mobile, et avoir un comportement
et un layout apadpté sur de petites résolutions.

Tous vos formulaires doivent avoir des validations correctes, et l’ensemble de votre
site devra être sécurisé. Ce point est OBLIGATOIRE et sera vérifié longuement en soutenance.

Pour vous faire une petite idée, voiçi quelques éléments qui ne sont pas considérés
comme sécurisés :

• Avoir des mots de passe “en clair” dans une base de données.

• Pouvoir injecter du code HTML ou JavaScript “utilisateur” dans des variables mal
protégées.

• Pouvoir uploader du contenu indésirable.

• Pouvoir modifier une requête SQL.


## Stack
PHP 7.0.22 - MySQL 5.7.19 - SASS - CSS - Architecture MVC sans framework
