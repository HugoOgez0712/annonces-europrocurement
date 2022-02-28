<?php

       // Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'une catégorie lors de l'appui sur le bouton "modifier la catégorie". 
 //Il va servir à modifier la catégorie courante en BDD et sur les pages du FO et du BO  
namespace App\admin;

use App\classes\ClassAdmin;
use App\classes\ClassAds;
use App\helpers\Validation;

class postmodifadscategorie extends \App\views\Genere_admin {

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
        ->numeric('cat_id')
        ->notEmpty('cat_nom','cat_slug')
        ->getDatas();

         // Si les informations transmises sont toutes existantes, la méthode pour modifier la catégorie en BDD est utlisée avec les informations transmises par l'utilisateur
        if($valid):

             //instance de la class Ads pour récupérer les méthodes nécessaires à la modification d'une catégorie
            $ad = new ClassAds($this->container);
            // Utilisation de la méthode pour modifier une catégorie avec l'array valid
            $in = $ad->modifCat($valid);

            // Si la catégorie est modifiée, un message confirme la modification et l'utilisateur est redirigé sur la liste des catégories
            if($in):
                $this->flash('success', 'La page  est modifiée !');
            else:
                 // sinon, un message d'erreur est affiché sur la page, et l'utilisateur est envoyé sur la liste des catégories.
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;
            return $this->redirect($request, $response, 200, 'admin.gestionadscategories');


        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.gestionadscategories');

    }

}