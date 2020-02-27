<?php
class API{
  private $apiKey = '95b2f5b743e7b8c4d049012114a3226231ce83f2245f59b5ed0b083e';
  private $annee = '2017-18';


  public function urlExist($url){
    $handle = @fopen($url, 'r');
    if(!$handle){
        return false;
    }
    return true;
  }

  function __construct() {
    $url1 = 'https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&apikey='.$this->apiKey;
    $url2 = 'https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&apikey='.$this->apiKey;
    if(!$this->urlExist($url1)||!$this->urlExist($url2)){
      header("Location: ./error.php");
    }
  }



  public function api1Request($arg){
      return file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics'.$arg.'&refine.rentree_lib='.$this->annee.'&apikey='.$this->apiKey);
  }

  public function api2Request($arg){
      return file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur'.$arg.'&apikey='.$this->apiKey);
  }


}


 ?>
