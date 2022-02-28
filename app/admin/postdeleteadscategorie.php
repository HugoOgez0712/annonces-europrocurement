<?php
 // Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'une catégorie lors de l'appui sur le bouton "supprimer la catégorie". 
 //Il va servir à supprimer la catégorie courante en BDD et sur les pages du FO et du BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postdeleteadscategorie extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
 //instance de la class Ads pour récupérer les méthodes nécessaires à la suppression d'une catégorie
        $ads = new ClassAds($this->container);

         //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());

         // valid est un array qui contient les informations nécessaires à la suppression d'une catégorie que l'utilisateur transmet par les différents champs sur la view de la gestion
        // d'une catégorie
        $valid = $validation
        ->numeric('cat_id', 'ann_cat_id')
        ->getDatas();

         // Si les informations transmises sont toutes existantes, les méthodes pour supprimer l'annonce en BDD sont utlisées avec les informations transmises par l'utilisateur
        if($valid):
            $newCatId = $valid['ann_cat_id'];
            $id = $valid['cat_id'];
            // cette variable permet de récupérer l'id courant de notre annonce, un nouvel id sélectionné par l'utilisatuer lorsqu'il sélectionne une autre catégorie, 
            // et ainsi, toutes les annonces liées à la catégorie supprimée seront liées à celle sélectionnée par l'utilisateur
            $updt = $ads->updateAnnCat($id,$newCatId);
            $del = $ads->deleteCat($valid);
// Si l'annonce est supprimée et une autre remplace l'ancienne pour les annonces, un message confirme la suppression et l'utilisateur est redirigé sur la liste des annonces
            if($del):
                $this->flash('success', 'La catégorie d\'annonce est supprimée !');
            else:
                $this->flash('error', 'Les informations transmises sont incorrectes.');
                return $this->redirect($request, $response, 200, 'admin.gestionadscategories');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.gestionads');

    }

}