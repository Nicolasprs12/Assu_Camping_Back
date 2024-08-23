<?php

namespace App\Models;

class DateHeure
{
	public $sec;
	public $min;
	public $heure;
	public $jour;
	public $mois;
	public $annee;
	public $sem;

	//constructeur
	function __construct($jour = null, $mois = null, $annee = null, $heure = null, $min = null, $sec = null)
	{

		date_default_timezone_set('Europe/Paris');

		$this->jour		= is_null($jour)?	date("d"): $jour;
		$this->mois		= is_null($mois)?	date("m"): $mois;
		$this->annee	= is_null($annee)?	date("Y"): $annee;
		$this->heure	= is_null($heure)?	date("H"): $heure;
		$this->min		= is_null($min)?	date("i"): $min;
		$this->sec		= is_null($sec)?	date("s"): $sec;
	}

	function lireSQL($date)
	{// traite une date au format SQL(ex : "2007-07-17" ou "2007-07-17 23:15:56")

		$this->mois 		= substr($date, 5 ,2);
		$this->jour 		= substr($date, 8, 2);
		$this->annee		= substr($date, 0 ,4);
		if (strlen($date) > 8)
		{
			$this->heure 	= substr($date, 11, 2);
			$this->min		= substr($date, 14, 2);
			$this->sec		= substr($date, 17,2);
		}
		else
		{
			$this->heure 	= 12;
			$this->min		= 0;
			$this->sec		= 0;
		}
	}

	function lireHeureSQL($heure, $sec = true)
	{//traite une heure au format SQL(ex: 23:15:56) - Attention, ne traite que l'heure donc il faut une date à cet objet
		$this->heure 	= substr($heure, 0, 2);
		$this->min		= substr($heure, 3, 2);
		if($sec && strlen($heure) == 8) $this->sec	= substr($heure, 6, 2);
		else $this->sec = '00';
	}

	function ecritDateSQL()
	{//retourne la date au format date SQL
		return $this->annee.'-'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'-'.str_pad($this->jour, 2, 0, STR_PAD_LEFT);
	}

	function ecritDateHeureSQL(){
		//retourne la date au format dateheure SQL
		return $this->annee.'-'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'-'.str_pad($this->jour, 2, 0, STR_PAD_LEFT).' '.str_pad($this->heure, 2, 0, STR_PAD_LEFT).':'.str_pad($this->min, 2, 0, STR_PAD_LEFT).':'.str_pad($this->sec, 2, 0, STR_PAD_LEFT);
	}


	function dateStandard($aaaa = false, $heure = false, $s = false){
		// retourne par defaut la date au format 17/07/07 ou 17/07/2007 si $aaaa est vrai
		// ajoute hh:mm si $heure vrai
		if ($aaaa) $date = str_pad($this->jour, 2, 0, STR_PAD_LEFT).'/'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'/'.$this->annee;
		else $date = str_pad($this->jour, 2, 0, STR_PAD_LEFT).'/'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'/'.substr($this->annee, 2, 2);
		if($heure) $date .= ' '.$this->heureStandard($s);

		return $date;
	}

	function getDateStandard($aaaa = false, $heure = false, $s = false){
		// cf dateStandard
		return $this->dateStandard($aaaa,$heure,$s);
	}

	function heureStandard($s = false)
	{// retourne l'heure au format 18:23 sans (defaut) ou avec les secondes
		if(!$s) return str_pad($this->heure, 2, 0, STR_PAD_LEFT).':'.str_pad($this->min, 2, 0, STR_PAD_LEFT);
		else return str_pad($this->heure, 2, 0, STR_PAD_LEFT).':'.str_pad($this->min, 2, 0, STR_PAD_LEFT).':'.str_pad($this->sec, 2, 0, STR_PAD_LEFT);
	}

	function getDateHeureAerial($ymd = false, $date = true, $heure = false){
		//retourne la date et l'heure au format pour Aerialprocap
		//Y-m-d ou d-m-Y et H:i:s
		$txt = '';
		if($date){
			if($ymd) $txt .= $this->annee.'-'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'-'.str_pad($this->jour, 2, 0, STR_PAD_LEFT);
			else $txt .= str_pad($this->jour, 2, 0, STR_PAD_LEFT).'-'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'-'.$this->annee;
		}
		if($heure){
			if($date) $txt .= ' ';
			$txt .= str_pad($this->heure, 2, 0, STR_PAD_LEFT).':'.str_pad($this->min, 2, 0, STR_PAD_LEFT).':'.str_pad($this->sec, 2, 0, STR_PAD_LEFT);
		}
		return $txt;
	}

	function ecritDateLien()
	{//retourne la date sous la forme jjmmaaaa
		$jour = (strlen($this->jour) == 1)? '0'.$this->jour : $this->jour;
		$mois = (strlen($this->mois) == 1)? '0'.$this->mois : $this->mois;
		return $jour.$mois.$this->annee;
	}

	function lireDateStandard($date,$heure = false){
		//transforme une date standard jj/mm/aaaa au format de l'objet
		//$heure permet de lire les heures donc au format jj/mm/aaaa hh:mm

		if($heure){
			$tabDateHeure = explode(' ', $date);
			$heure = explode(':', $tabDateHeure[1]);
			$this->heure = str_pad($heure[0], 2, 0, STR_PAD_LEFT);
			$this->min = str_pad($heure[1], 2, 0, STR_PAD_LEFT);
			$dateOnly = $tabDateHeure[0];
		}else $dateOnly = $date;

		$tabdate = explode('/', $dateOnly);
		$this->jour = str_pad($tabdate[0], 2, 0, STR_PAD_LEFT);
		$this->mois = str_pad($tabdate[1], 2, 0, STR_PAD_LEFT);
		$this->annee = $tabdate[2];
	}

	function getDateHeureStandard($aaaa = false, $s = false){
		if ($aaaa) $date = str_pad($this->jour, 2, 0, STR_PAD_LEFT).'/'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'/'.$this->annee;
		else $date = str_pad($this->jour, 2, 0, STR_PAD_LEFT).'/'.str_pad($this->mois, 2, 0, STR_PAD_LEFT).'/'.substr($this->annee, 2, 2);

		$date .= ' '.str_pad($this->heure, 2, 0, STR_PAD_LEFT).':'.str_pad($this->min, 2, 0, STR_PAD_LEFT);
		if($s) $date .= ':'.str_pad($this->sec, 2, 0, STR_PAD_LEFT);

		return $date;
	}

	function timestamp()
	{// retourne le timestamp de l'objet en cours
		$timestamp = mktime ($this->heure, $this->min, $this->sec, $this->mois, $this->jour, $this->annee);
		return $timestamp;
	}

	function revTimestamp($timestamp)
	{//modifie l'objet avec le nouveau timestamp
		$this->jour = (int) date("d",$timestamp);
		$this->mois = (int) date("m",$timestamp);
		$this->annee = (int) date("Y",$timestamp);
		$this->heure = (int) date("H",$timestamp);
		$this->min = (int) date("i",$timestamp);
		$this->sec = (int) date("s",$timestamp);
	}

	function week()
	{// retourne la semaine de l'objet en cours
		$week = (int) date("W", $this->timestamp());
		$this->sem = $week;
	}

	function premierJourSem()
	{//deplace la date en cours au lundi de la semaine courante
		$numJour = $this->numJourSem();
		if($numJour == 0) $numJour += 7;
		$this->decalj(1 - $numJour);
	}

	function finJour()
	{//decale les heures de l'objet à la dernière heure de la journée (23:59:59)
		$this->heure = 23;
		$this->min = 59;
		$this->sec = 59;
	}

	function midi()
	{//decale les heures de l'objet à midi (12:00:00)
		$this->heure = 12;
		$this->min = 00;
		$this->sec = 00;
	}

	function debutJour()
	{//decale les heures de l'objet à la première heure de la journée (00:00:00)
		$this->heure = 00;
		$this->min = 00;
		$this->sec = 00;
	}

	function debutMois()
	{//decale la date au 1er du mois
		$this->jour = 01;
	}

	function finMois()
	{//decale la date au dernier jour du mois
		$this->jour = $this->nbJoursMois();
	}

	function nbJoursMois()
	{//retourne le nombre du jour du mois en cours
		return date("t",$this->timestamp());
	}

	function jourFrancais($complet = true)
	{// retourne le jour en français
		$jourEnFrancais = ($complet)? array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi') : array('dim','lun','mar','mer','jeu','ven','sam');
		return $jourEnFrancais[$this->numJourSem()];
	}

	function numJourSem()
	{//retourne le numéro du jour de la semaine 0->dimanche,1->lundi,...
		return (int) date("w", $this->timestamp());
	}

	function moisFrancais($complet = true)
	{// retourne le mois en français
		$moisEnFrancais = ($complet)? array(1=>'janvier','f&eacute;vrier','mars','avril','mai','juin','juillet','ao&ucirc;t','septembre','octobre','novembre','d&eacute;cembre') : array(1=>'jan','fév','mar','avr','mai','jun','jui','aou','sep','oct','nov','déc');
		$num_mois = (int) date("m", $this->timestamp());

		return $moisEnFrancais[$num_mois];
	}

	function decalh($nbheure,$heureEntiere = false){
		//decale l'heure d'un nombre d'heures $nbheure et arrondi à l'heure suivante si demandé
		$newtimestamp = $this->timestamp() + ($nbheure * 60 * 60) + (($heureEntiere)? ((60 - $this->min) * 60) : 0);
		$this->revTimestamp($newtimestamp);
	}

	function decalj($nbjour,$verifChangementHeure = true){
		// décale la date d'un nombre de jour $nbjour
		// $verifChangementHeure permet d'obtenir la même heure malgré un changement d'heure été/hiver - true par defaut

		$heure = $this->heureStandard();

		$newtimestamp = $this->timestamp() + ($nbjour * 60 * 60 * 24);
		$this->revTimestamp($newtimestamp);

		if($verifChangementHeure && $heure != $this->heureStandard()){
			// 1 heure de plus
			$this->decalh(1);
			// si ce n'est pas 1 de plus c'est 1 de moins
			if($heure != $this->heureStandard()) $this->decalh(-2);
		}
	}

	function decalmin($nbmin)
	{//decale la date d'un nombre de minute $nbjmin
		$newtimestamp = $this->timestamp() + ($nbmin * 60);
		$this->revTimestamp($newtimestamp);
	}

	function decals($nbsec)
	{//decale la date d'un nombre de seconde $nbsec
		$newtimestamp = $this->timestamp() + $nbsec;
		$this->revTimestamp($newtimestamp);
	}

	function decalm($nbmois,$debutMois = true)
	{//decale la date d'un nombre de mois $nbmois et deplace au premier jour du mois pour éviter les dates inextantes
		$newtimestamp = mktime(0, 0, 0, $this->mois + $nbmois, ($debutMois ? 1 : $this->jour), $this->annee);
		$this->revTimestamp($newtimestamp);
	}

	function decala($nbans)
	{//decale la date d'un nombre d'annee $nbans
		$newtimestamp = mktime(0, 0, 0, $this->mois, $this->jour , $this->annee - $nbans);
		$this->revTimestamp($newtimestamp);
	}

	function arrondiStep($minutes){
		// decalage de $min + arrondi step suivant
		// ex : si 10:37 et $min = 10 -> décalage à 10:50
		// ex : si 10:37 et $min = 15 -> décalage à 11:00
		$secondes = $minutes * 60;
		$newtimestamp = $this->timestamp() + $secondes + ($secondes - ($this->min * 60 + $this->sec)%$secondes);
		$this->revTimestamp($newtimestamp);
	}

	function arrondiMinute(){
		// arrondi à la minutes entière suivante
		$newtimestamp = $this->sec == 0 ? $this->timestamp() : $this->timestamp() + 60 - $this->timestamp()%60;
		$this->revTimestamp($newtimestamp);
	}

	function texte($multiligne = false, $majuscule = false)
	{// retourne la date en lettre (ex : 10/10/2007 retourne mercredi 10 octobre 2007)
		return ($multiligne)? (($majuscule)? ucwords($this->jourFrancais()) : $this->jourFrancais()).'<br />'.$this->jour.'<br />'.$this->moisFrancais().'<br />'.$this->annee : (($majuscule)? ucwords($this->jourFrancais()) : $this->jourFrancais()).' '.$this->jour.' '.$this->moisFrancais().' '.$this->annee;
	}

	function getAnnee($AA = false){
		if($AA) return substr($this->annee, -2);
		else return $this->annee;
	}

	function getMois(){
		return str_pad($this->mois, 2, 0, STR_PAD_LEFT);
	}

	function getJour(){
		return str_pad($this->jour, 2, 0, STR_PAD_LEFT);
	}

	function getHeure(){
		return str_pad($this->heure, 2, 0, STR_PAD_LEFT);
	}

	function getMin(){
		return str_pad($this->min, 2, 0, STR_PAD_LEFT);
	}

	function getSec(){
		return str_pad($this->sec, 2, 0, STR_PAD_LEFT);
	}

	function verif(){
		$result = checkdate($this->mois,$this->jour,$this->annee);
		return $result;
	}

	function verifHeure(){
		$ok = false;
		if($this->heure >= 0 && $this->heure < 24 && $this->min >= 0 && $this->min < 60 && $this->sec >= 0 && $this->sec < 60) $ok = true;
		return $ok;
	}

	function getAAAAMMJJ(){
		return $this->annee.$this->getMois().$this->getJour();
	}
	function getAAAAMM(){
		return $this->annee.$this->getMois();
	}
	function getJJMMAAAA(){
		return $this->getJour().$this->getMois().$this->annee;
	}

	function lireAAAAMMJJHHMMSS($date){
		//lit la date et l'heure au format des transaction bancaire
		$this->mois 		= substr($date, 4 ,2);
		$this->jour 		= substr($date, 6, 2);
		$this->annee		= substr($date, 0 ,4);
		if (strlen($date) > 8)
		{
			$this->heure 	= substr($date, 8, 2);
			$this->min		= substr($date, 10, 2);
			$this->sec		= substr($date, 12,2);
		}
		else
		{
			$this->heure 	= 12;
			$this->min		= 0;
			$this->sec		= 0;
		}
	}

	// retourn l'age en fonction de la date du jour
	function getAge() {
		$age = date('Y') - $this->ecritDateSQL();
		if (date('md') < date('md', strtotime($this->ecritDateSQL()))) $age--;
		return $age;
	}

// 	function getISO8601(){
// 		return date(DateTime::ISO8601,$this->timestamp());
// 	}
}


