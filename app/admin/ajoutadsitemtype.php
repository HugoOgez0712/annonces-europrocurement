<?php
// Ce module sert à envoyer toutes les données nécessaires à la création de la page d'ajout d'un type d'item en se basant sur les méthodes de la classAds
namespace App\admin;


use App\classes\ClassAds;
use App\classes\ClassAdmin;

class ajoutadsitemtype extends \App\views\Genere_admin {

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
  
        //création d'une variable qui récupère l'id du site courant grâce aux informations du container envoyées par globals
        $idsite = $this->container->globals['idsite'];

         //récupération des types d'items dans l'admin
        $datas['item_types'] = $ads->getItemTypes();
        //Fichier javascript récupéré grâce à data
        $datas['js'] = 'admin_ajoutad';

         // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);
          // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'admin/ajoutadsitemtype');

    }

}