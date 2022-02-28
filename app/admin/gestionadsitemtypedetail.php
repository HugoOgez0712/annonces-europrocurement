<?php

namespace App\admin;

use App\helpers\Util;
use App\helpers\Pagination;
use App\helpers\PaginationBis;
use App\helpers\Validation;
use App\classes\ClassAds;

class gestionadsitemtypedetail extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
         //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
        $datas = array();
        $datas['test'] = 'test';
         // récupération de l'id du type d'item selectionné dans notre URL 
        $id = $request->getAttribute('id');

         // redirection vers la liste des types d'items si l'id n'existe pas
        if(!$id){
            $this->flash('success', 'Page introuvable !');
            return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');
        }

        //instance de la class Ads pour récupérer les méthodes nécessaires à l'affichage d'un type d'item
        $ads = new ClassAds($this->container);
         //récupération de l'item type courant dans l'admin grâce à l'id
        $currentItemType = $ads->getItemType($id);
      

        $datas['js'] = 'admin_ajoutpage';

         // transmission de l'item type courant à la view
        $datas['currentItemType'] = $currentItemType;

           // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
        $request = $request->withAttribute('datas', $datas);

          // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php
        return $this->render($request,$response, 'admin/gestionadsitemtypedetail');

    }

}