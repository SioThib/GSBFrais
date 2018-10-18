<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FunctionsLib extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	/**
	 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
	 
	 * @param $madate au format  jj/mm/aaaa
	 * @return la date au format anglais aaaa-mm-jj
	*/
	function dateFrancaisVersAnglais($maDate)
	{
		@list($jour,$mois,$annee) = explode('/',$maDate);
		return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
	}
	
	/**
	 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa 
	 
	 * @param $madate au format  aaaa-mm-jj
	 * @return la date au format format français jj/mm/aaaa
	*/
	function dateAnglaisVersFrancais($maDate)
	{
	   @list($annee,$mois,$jour)=explode('-',$maDate);
	   $date="$jour"."/".$mois."/".$annee;
	   return $date;
	}
	
	/**
	 * retourne le mois d'une date au format aaaamm 
	 
	 * @param $date au format  jj/mm/aaaa
	 * @return : le mois au format aaaamm
	*/
	function getMois($date)
	{
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
	}

	/**
	 * retourne, sous la forme d'un tableau, les 6 derniers mois 
	 * à partir d'aujourd'hui au format aaaamm, y compris le mois courant
	 * A noter: compte-tenu du fonctionnement de la méthode DateTime::sub,
	 * il peut arriver que l'on retrouve 2 fois le même mois parmi
	 * les 6 mois résultants. On aura, dans ce cas, que 5 mois distincts.
	 
	 * @return : un tableau contenant les 6 mois au format aaaamm
	*/
	function getSixDerniersMois()
	{
		$lesMois = array();

		$date = new datetime ("now");
		$interval = new DateInterval('P1M');
		
		for($i=1; $i<=6; $i++) {
			@list($jour,$mois,$annee) = explode('/',$date->format("d/m/Y"));
			if(strlen($mois) == 1){
				$mois = "0".$mois;
			}
			$lesMois[] = $annee.$mois;
			$date->sub($interval);
		}
		return $lesMois;
	}

	/**
	 * Indique si une valeur est un entier positif ou nul
	 
	 * @param $valeur
	 * @return vrai ou faux
	*/
	public function estEntierPositif($valeur) 
	{
		return preg_match("/[^0-9]/", $valeur) == 0;
	}

	/**
	 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
	 
	 * @param $tabEntiers : le tableau
	 * @return vrai ou faux
	*/
	public function estTableauEntiers($tabEntiers) 
	{
		$ok = true;
		foreach($tabEntiers as $unEntier){
			if(!$this->estEntierPositif($unEntier)){
				$ok=false; 
			}
		}
		return $ok;
	}
	
	/**
	 * Vérifie si une date est inférieure d'un an à la date actuelle
	 
	 * @param $dateTestee 
	 * @return vrai ou faux
	*/
	function estDateDepassee($dateTestee)
	{
		$dateActuelle=date("d/m/Y");
		@list($jour,$mois,$annee) = explode('/',$dateActuelle);
		$annee--;
		$AnPasse = $annee.$mois.$jour;
		@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
		return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
	}
	
	/**
	 * Vérifie la validité du format d'une date française jj/mm/aaaa 
	 
	 * @param $date 
	 * @return vrai ou faux
	*/
	function estDateValide($date)
	{
		$tabDate = explode('/',$date);
		$dateOK = true;
		if (count($tabDate) != 3) {
			$dateOK = false;
		}
		else {
			if (!$this->estTableauEntiers($tabDate)) {
				$dateOK = false;
			}
			else {
				if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
					$dateOK = false;
				}
			}
		}
		return $dateOK;
	}

	/**
	 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
	 
	 * @param $lesFrais 
	 * @return vrai ou faux
	*/
	function lesQteFraisValides($lesFrais)
	{
		return $this->estTableauEntiers($lesFrais);
	}
		

}
