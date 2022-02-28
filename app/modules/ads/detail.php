<?php

         // Ce module est déclenché lorsque l'on cherche à afficher une annonce et ses informations. Cette page affichera également les annonces qui ont la même catégorie et la même ville
         
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class detail extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
          //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = array();
        $datas['test'] = 'test';

         // récupération de l'id de l'annonce dans l'URL
        $id = $request->getAttribute('ann_id');
         //instance de la class Ads pour récupérer les méthodes nécessaires à l'affichage des annonces en fonction des catégories
        $ads = new ClassAds($this->container);
        // On stocke dans une variable l'annonce récupérée en BDD qui a en paramètre l'id
        $currentAd = $ads->getAd($id);
        // On stocke dans une variable les items récupérés en BDD qui ont tous l'id de l'annonce
        $currentAdItems = $ads->getItems($id);
        // On stocke dans une variable l'auteur récupéré en BDD qui a le même id que l'ann_aut_id de l'annonce
        $currentAdAut = $ads->getAut((int)$currentAd->ann_aut_id);
        // On stocke dans une variable toutes les annonces récupéré en BDD qui ont la même ville que l'annonce actuelle
        $AdsByCity = $ads->getAdsByCity($currentAd->ann_geoloc);
        // On stocke dans une variable toutes les annonces récupéré en BDD qui ont le même auteur que l'annonce actuelle grâce à l'ann_aut_id
        if($currentAd->ann_aut_id){
        $AdsByAut = $ads->getAdsByAut($currentAd->ann_aut_id);
      }
        // On stocke dans une variable toutes les annonces récupéré en BDD qui ont la même catégorie que l'annonce actuelle grâce à l'ann_cat_id
        $AdsByCat = $ads->getAdsByCat($currentAd->ann_cat_id);
    
        // On transmet toutes ces informations dans le tableau data afin qu'elles soient accessibles via $request dans la view
        $datas['currentAd'] = $currentAd;
        $datas['currentAdItems'] = $currentAdItems;
        $datas['currentAdAut'] = $currentAdAut;
        $datas['AdsByCity'] = $AdsByCity;
        if(isset($AdsByAut)){
        $datas['AdsByAut'] = $AdsByAut;
        }
        $datas['AdsByCat'] = $AdsByCat;
      
        // On stocke dans cette entrée de data toutes les images qui ont la même ann_id
        $datas['images'] = $ads->getImagesAdmin($id);

         //Fichier javascript récupéré grâce à data
        $datas['js'] = 'ads';
          // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);
          // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'ads/detail');

    }

}