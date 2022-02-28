<?php

namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class categorie extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {

        //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = array();
        $datas['test'] = 'test';
         //instance de la class Ads pour récupérer les méthodes nécessaires à l'affichage des annonces en fonction des catégories
        $ads = new ClassAds($this->container);
        // Récupération dans l'URL du nom de la catégorie
        $slug = $request->getAttribute('cat_slug');
        // récupération de l'id de la catégorie grâce au nom de la catégorie récupéré en URL
        $idSlug = $ads->getIdWithSlug($slug);
        $id = $idSlug->cat_id;

        // Avec l'id de la catégorie, on récupère toute les annonces liées à cette catégorie
        $list = $ads->getAdsByCategory($id);

        // On passe les annonces en fonction de la catégorie dans l'array datas en
        $datas['list-by-category'] = $list;

           // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);

          // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'ads/categorie');

    }

}