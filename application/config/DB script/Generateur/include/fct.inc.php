<?php

function getLesVisiteurs($pdo)
{
		$req = "select * from visiteur";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
function getLesFichesFrais($pdo)
{
		$req = "select * from ficheFrais";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
function getLesIdFraisForfait($pdo)
{
		$req = "select fraisforfait.id as id, montant from fraisforfait order by fraisforfait.id";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
function getDernierMois($pdo, $idVisiteur)
{
		$req = "select max(mois) as dernierMois from fichefrais where idVisiteur = '$idVisiteur'";
		$res = $pdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['dernierMois'];

}
function getMoisSuivant($mois){
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		if($numMois=="12"){
			$numMois = "01"; 
			$numAnnee++;
		}
		else{
			$numMois++;

		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois;
		return $numAnnee.$numMois;
}
function getMoisPrecedent($mois){
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		if($numMois=="01"){
			$numMois = "12"; 
			$numAnnee--;
		}
		else{
			$numMois--;
		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois;
		return $numAnnee.$numMois;
}
function creationFichesFrais($pdo)
{
	$lesVisiteurs = getLesVisiteurs($pdo);
	$moisActuel = getMois(date("d/m/Y"));
	$moisDebut = "201301";
	$moisFin = getMoisPrecedent($moisActuel);
	foreach($lesVisiteurs as $unVisiteur)
	{
		$moisCourant = $moisFin;
		$idVisiteur = $unVisiteur['id'];
		$n = 1;
		while($moisCourant >= $moisDebut)
		{
			if($n == 1)
			{
				$etat = "CR";
				$moisModif = $moisCourant;
			}
			else
			{
				if($n == 2)
				{
					$etat = "VA";
					$moisModif = getMoisSuivant($moisCourant);
				}
				else
				{
					$etat = "RB";
					$moisModif = getMoisSuivant(getMoisSuivant($moisCourant));
				}
			}
			$numAnnee =substr( $moisModif,0,4);
			$numMois =substr( $moisModif,4,2);
			$dateModif = $numAnnee."-".$numMois."-".rand(1,8);
			$nbJustificatifs = rand(0,12);
			$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
			values ('$idVisiteur','$moisCourant',$nbJustificatifs,0,'$dateModif','$etat');";
			$pdo->exec($req);
			$moisCourant = getMoisPrecedent($moisCourant);
			$n++;
		}
	}
}
function creationFraisForfait($pdo)
{ 
	$lesFichesFrais= getLesFichesFrais($pdo);
	$lesIdFraisForfait = getLesIdFraisForfait($pdo);
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		foreach($lesIdFraisForfait as $unIdFraisForfait)
		{
			$idFraisForfait = $unIdFraisForfait['id'];
			$montantApp = $unIdFraisForfait['montant'];
			if(substr($idFraisForfait,0,1)=="K")
			{
				$quantite =rand(300,1000);
			}
			else
			{
				$quantite =rand(2,20);
			}
			$req = "insert into lignefraisforfait(idvisiteur,mois,idfraisforfait,quantite, montantApplique)
			values('$idVisiteur','$mois','$idFraisForfait',$quantite, $montantApp);";
			$pdo->exec($req);	
		}
	}

}
function getDesFraisHorsForfait()
{
	$tab = array(
				1 => array(
				      "lib" => "repas avec praticien",
					  "min" => 30,
					  "max" => 50 ),
				2 => array(
				      "lib" => "achat de matériel de papèterie",
					  "min" => 10,
					  "max" => 50 ),
				3	=> array(
				      "lib" => "taxi",
					  "min" => 20,
					  "max" => 80 ),
				4 => array(
				      "lib" => "achat d'espace publicitaire",
					  "min" => 20,
					  "max" => 150 ),
				5 => array(
				      "lib" => "location salle conférence",
					  "min" => 120,
					  "max" => 650 ),
				6 => array(
				      "lib" => "Voyage SNCF",
					  "min" => 30,
					  "max" => 150 ),
				7 => array(
					  "lib" => "traiteur, alimentation, boisson",
					  "min" => 25,
					  "max" => 450 ),
				8 => array(
					  "lib" => "rémunération intervenant/spécialiste",
					  "min" => 250,
					  "max" => 1200 ),
				9 => array(
					  "lib" => "location équipement vidéo/sonore",
					  "min" => 100,
					  "max" => 850 ),
				10 => array(
					  "lib" => "location véhicule",
					  "min" => 25,
					  "max" => 450 ),
				11 => array(
					  "lib" => "frais vestimentaire/représentation",
					  "min" => 25,
					  "max" => 450 ) 
		);
	return $tab;
}
function updateMdpVisiteur($pdo)
{
	$req = "select * from visiteur";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		$lettres ="azertyuiopqsdfghjkmwxcvbn123456789";
		foreach($lesLignes as $unVisiteur)
		{
			$mdp = "";
			$id = $unVisiteur['id'];
			for($i =1;$i<=5;$i++)
			{
				$uneLettrehasard = substr( $lettres,rand(33,1),1);
				$mdp = $mdp.$uneLettrehasard;
			}
			
			$req = "update visiteur set mdp ='$mdp' where visiteur.id ='$id' ";
			$pdo->exec($req);
		}


}
function creationFraisHorsForfait($pdo)
{	
	$desFrais = getDesFraisHorsForfait();
	$lesFichesFrais= getLesFichesFrais($pdo);
	
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		$nbFrais = rand(0,5);
		for($i=0;$i<=$nbFrais;$i++)
		{
			$hasardNumfrais = rand(1,count($desFrais)); 
			$frais = $desFrais[$hasardNumfrais];
			$lib = $frais['lib'];
			$min= $frais['min'];
			$max = $frais['max'];
			$hasardMontant = rand($min,$max);
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$hasardJour = rand(1,28);
			if(strlen($hasardJour)==1)
			{
				$hasardJour="0".$hasardJour;
			}
			$hasardMois = $numAnnee."-".$numMois."-".$hasardJour;
			$req = "insert into lignefraishorsforfait(idVisiteur,mois,libelle,date,montant)
			values('$idVisiteur','$mois','$lib','$hasardMois',$hasardMontant);";
			$pdo->exec($req);
		}
	}
}
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

function majFicheFrais($pdo)
{
	$lesFichesFrais= getLesFichesFrais($pdo);
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		//$dernierMois = getDernierMois($pdo, $idVisiteur);
		$req = "select sum(montant) as cumul from ligneFraisHorsForfait where ligneFraisHorsForfait.idVisiteur = '$idVisiteur' 
				and ligneFraisHorsForfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantHorsForfait = $ligne['cumul'];
		$req = "select sum(ligneFraisForfait.quantite * fraisForfait.montant) as cumul from ligneFraisForfait, FraisForfait where
		ligneFraisForfait.idFraisForfait = fraisForfait.id   and   ligneFraisForfait.idVisiteur = '$idVisiteur' 
				and ligneFraisForfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantForfait = $ligne['cumul'];
		$montantEngage = $cumulMontantHorsForfait + $cumulMontantForfait;
		$etat = $uneFicheFrais['idEtat'];
		// if($etat == "CR" )
			// $montantValide = 0;
		// else
			// $montantValide = $montantEngage*rand(80,100)/100;
		$req = "update fichefrais set montantValide =$montantEngage where
		idVisiteur = '$idVisiteur' and mois='$mois'";
		$pdo->exec($req);
		
	}
}
?>




