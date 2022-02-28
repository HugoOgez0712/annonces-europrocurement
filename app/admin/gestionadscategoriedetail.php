<?php
 
namespace App\admin;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class gestionadscategoriedetail extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
         //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = array();
        $datas['test'] = 'test';
        
        // récupération de l'id de la catégorie selectionnée dans notre URL 
        $id = $request->getAttribute('id');

        // redirection vers la liste des catégories si l'id n'existe pas
        if(!$id){
            $this->flash('success', 'Page introuvable !');
            return $this->redirect($request, $response, 200, 'admin.gestionadscategories');
        }

        //instance de la class Ads pour récupérer les méthodes nécessaires à l'affichage d'une catégorie
        $ads = new ClassAds($this->container);
        
         //récupération de la catégorie grâce à l'id récupéré
        $currentCat = $ads->getCat($id);
        
        //récupération de toutes les catégories sauf celle de la page grâce à l'id récupéré
        $categories = $ads->getCatsException($id);

        //récupération de l'item grâce à l'id récupéré
        $currentItems = $ads->getItems($id);

         //récupération des items par défaut de la catégorie courante
        $defaultItems = $ads->getCatsAndItems($id);
      

        // transmission des items par défaut à la view
        $datas['default'] = $defaultItems;
        //Fichier javascript récupéré grâce à data
        $datas['js'] = 'admin_adcategoriedetail';
         // transmission des items par défaut à la view
        $datas['currentItems'] = $currentItems;
         // transmission de la catégorie courante à la view
        $datas['currentCat'] = $currentCat;
         // transmission de toutes les catégories courante à la view
        $datas['categories'] = $categories;
// transmission de tous les types d'items à la view
        $datas['item_types'] = $ads->getItemTypes();

           // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);
        return $this->render($request,$response, 'admin/gestionadscategoriedetail');

    }

}