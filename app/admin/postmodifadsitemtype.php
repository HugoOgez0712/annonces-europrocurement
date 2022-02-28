<?php


 //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une catégorie
   //initialisation d'un array vide pour récupérer toutes les données envoyées à la view grâce à la variable $request
     //création d'une variable qui récupère l'id du site courant grâce aux informations du container envoyées par globals
     // récupération de l'id de la catégorie selectionnée dans notre URL 
     // redirection vers la liste des catégories si l'id n'existe pas
      //récupération des catégories dans l'admin
         //Fichier javascript récupéré grâce à data
          //récupération des catégories dans l'admin
           //récupération des catégories dans l'admin
            //récupération des auteurs avec méthode de l'objet auteurs compris dans le container et grâce à l'id du site courant
              // La variable $request reprendre toutes les informations de l'array data grâce à la fonction "withAttribute"
             // La fonction render nous permet de créer notre view. Elle a en attribut les données stockées dans $request, les données renvoyées dans $response et 
        // la route dont le nom a été défini dans notre fichier routes.php

    // Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'un type d'item lors de l'appui sur le bouton "modifier le type d'item". 
 //Il va servir à modifier le type d'item courante en BDD et sur les pages du FO et du BO  
namespace App\admin;

use App\classes\ClassAdmin;
use App\classes\ClassAds;
use App\helpers\Validation;

class postmodifadsitemtype extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

        //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());

             // valid est un array qui contient les informations nécessaires à la modification d'une catégorie que l'utilisateur transmet par les différents champs sur la view de la gestion
        // d'une catégorie
        $valid = $validation
        ->numeric('item_type_id')
        ->notEmpty('item_type_nom','item_type_input', 'item_type_desc')
        ->getDatas();

         // Si les informations transmises sont toutes existantes, la méthode pour modifier le type d'item en BDD est utlisée avec les informations transmises par l'utilisateur
        if($valid):
 //instance de la class Ads pour récupérer la méthode de modification du type d'item
            $ad = new ClassAds($this->container);

            // Utilisation de la méthode pour modifier un type d'item avec l'array valid
            $in = $ad->modifItemType($valid);

             // Si le type d'item est modifié, un message confirme la modification et l'utilisateur est redirigé sur la liste des types d'items
            if($in):
                $this->flash('success', 'L\item type est modifié !');
            else:
                  // sinon, un message d'erreur est affiché sur la page, et l'utilisateur est envoyé sur la liste des types d'items.
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;
            return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');


        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');

    }

}