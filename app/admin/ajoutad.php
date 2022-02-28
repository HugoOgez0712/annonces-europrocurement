<?php

// Ce module sert à envoyer toutes les données nécessaires à la création de la page d'ajout d'une annonce en se basant sur les méthodes de la classAds
namespace App\admin;

// J'utilise la class Ad
use App\classes\ClassAds;
use App\classes\ClassAdmin;

class ajoutad extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
        $ads = new ClassAds($this->container);
        //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une annonce
        $admin = new ClassAdmin($this->container);
        
        //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = [];

        $idsite = $this->container->globals['idsite'];

        //récupération des annonces dans l'admin
        $datas['totalads'] = $ads->getAdsAdmin();
        //Fichier javascript récupéré grâce à data
        $datas['js'] = 'admin_addetail';
        //récupération des catégories dans l'admin
        $datas['cats'] = $ads->getCats();
        //récupération des types d'items dans l'admin
        $datas['item_types'] = $ads->getItemTypes();

        //récupération des auteurs dans l'admin
        $datas['auteurs'] = $this->container->auteurs->getAuteurs($idsite);

        // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);

        // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'admin/ajoutad');

    }

}