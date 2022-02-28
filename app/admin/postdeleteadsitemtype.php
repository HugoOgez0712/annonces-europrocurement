<?php

// Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'un type d'item lors de l'appui sur le bouton "supprimer le type d'item". 
 //Il va servir à supprimer l'item type courant en BDD et sur les pages du FO et du BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postdeleteadsitemtype extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
//instance de la class Ads pour récupérer les méthodes nécessaires à la suppression d'un type d'item
        $ads = new ClassAds($this->container);

           //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());


          // valid est un array qui contient les informations nécessaires à la suppression d'un type d'item que l'utilisateur transmet par les différents champs sur la view de la gestion
        // d'une catégorie
        $valid = $validation
        ->numeric('item_type_id')
        ->getDatas();

         // Si les informations transmises sont toutes existantes, la méthode pour supprimer le type d'item en BDD est utlisé avec les informations transmises par l'utilisateur
        if($valid):
            $id = $valid['item_type_id'];
            $del = $ads->deleteItemType($valid);


        // Si l'item type est bien supprimé, l'utilisateur est redirigé sur la liste des types d'items 
            if($del):
                $this->flash('success', 'Le type d\'item est supprimé !');
            else:
                 // Sinon on affiche un message d'erreur
                $this->flash('error', 'Les informations transmises sont incorrectes.');
                return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');

    }

}