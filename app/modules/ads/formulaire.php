<?php

  // Ce module est déclenché lorsque l'utilisateur crée une annonce à partir du front-office
namespace App\modules\ads;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class formulaire extends \App\views\Genere_views {

    public $container;

    public function __construct($container){
        $this->container = $container;
        
    }

    public function process($request, $response) {
        $datas = array();
        $datas['test'] = 'test';
        $ads = new ClassAds($this->container);
        $idsite = $this->container->globals['idsite'];

         // récupération de l'id de l'annonce dans l'URL
         $slug = $request->getAttribute('cat_slug');
         $currentCat = $ads->getCatBySlug($slug);

         $datas['slug'] = $slug;
       
         $id = $currentCat->cat_id;
        // $publish = $ads->insertAd($v) ?null : null;

        //Fichier javascript récupéré grâce à data
        // $datas['js'] = 'ads';

        $currentItems = $ads->getCatsAndItems($id);
      
        // $datas['publish'] = $publish;
        //récupération des catégories pour le formulaire

        $datas['currentItems'] = $currentItems;

        $datas['currentCat'] =  $ads->getCatBySlug($slug);
     
        $datas['cats'] = $ads->getCats();
        //récupération des types d'items pour le formulaire
        $datas['item_types'] = $ads->getItemTypes();
        $datas['auteurs'] = $this->container->auteurs->getAuteurs($idsite);
        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'ads/formulaire');

    }

}