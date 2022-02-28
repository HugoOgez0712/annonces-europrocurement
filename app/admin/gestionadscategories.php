<?php

namespace App\admin;

use App\classes\ClassAds;

class gestionadscategories extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
//instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une catégorie
        $ads = new ClassAds($this->container);

         //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = [];

        $idsite = $this->container->globals['idsite'];
        
          //récupération des catégories dans l'admin pour les afficher sur notre view
        $datas['categories'] = $ads->getCats();
         //Fichier javascript récupéré grâce à data
        $datas['js'] = 'admin_gestionadscategories';

         // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);

        // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'admin/gestionadscategories');

    }
}