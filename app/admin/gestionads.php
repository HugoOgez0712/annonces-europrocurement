<?php

namespace App\admin;

use App\classes\ClassAds;

/// Ce module sert à envoyer toutes les données nécessaires à la modification d'une annonce en se basant sur les méthodes de la classAds
class gestionads extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
        //instance de la class Ads pour récupérer les méthodes nécessaires à l'affichage de la liste des annocnes
        $ads = new ClassAds($this->container);
          //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = [];

        $idsite = $this->container->globals['idsite'];

        $query = 'WHERE acces_site = '.$idsite.' ';

           //récupération des catégories dans l'admin pour les afficher sur notre view 
        $datas['categories'] = $ads->getCats();
  
        // $datas['totalads'] = $ads->getAdsAdmin();
        // $datas['total'] = $ads->getTotal();
        $datas['js'] = 'admin_gestionads';

         // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);

         // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'admin/gestionads');

    }

}