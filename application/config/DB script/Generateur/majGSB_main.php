 Programme d'actualisation des lignes des tables,  
 cette mise à jour peut prendre plusieurs minutes...
 
 Mais quand ce message s'affiche ... bizarrement, 
 c'est pour dire que l'exécution du script est terminée !!!
 
 Comment expliquer cela ???
<?php
include("include/fct.inc.php");

/* Modification des paramètres de connexion */

$serveur='mysql:host=localhost';
$bdd='dbname=testGSB';   		
$user='ts1' ;    		
$mdp='ts1' ;	

/* fin paramètres*/

$pdo = new PDO($serveur.';'.$bdd, $user, $mdp);
$pdo->query("SET CHARACTER SET utf8"); 

set_time_limit(0);
creationFichesFrais($pdo);
creationFraisForfait($pdo);
creationFraisHorsForfait($pdo);
majFicheFrais($pdo);

?>