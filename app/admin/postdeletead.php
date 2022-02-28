<?php

 // Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'une annonce lors de l'appui sur le bouton "supprimer l'annonce". 
 //Il va servir à supprimer l'annonce courante en BDD et sur les pages du FO et du BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postdeletead extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
 //instance de la class Ads pour récupérer les méthodes nécessaires à la suppression d'une annonce
        $ads = new ClassAds($this->container);

         //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());
      
         // valid est un array qui contient les informations nécessaires à la suppression d'une annonce que l'utilisateur transmet par les différents champs sur la view de la gestion
        // d'une annonce
        $valid = $validation
        ->numeric('ann_id')
        ->getDatas();
      
           // Si les informations transmises sont toutes existantes, les méthodes pour supprimer l'annonce en BDD sont utlisées avec les informations transmises par l'utilisateur
        if($valid):

        //
            $message = null;
            $delItems = $ads->deleteItem($valid);
            $message .= $delItems . ' données supprimées. ';
            $del = $ads->deleteAd($valid);
            $delImages = $ads->deleteImage($valid);
            $message .= $delImages . ' images supprimées. ';
// Si l'annonce est supprimée, un message confirme la suppression et l'utilisateur est redirigé sur la liste des annonces
            if($del):
                $this->flash('success', 'L\'annonce est supprimée ! ' . $message);
            else:
            // Sinon, l'utilisateur est renvoyé sur la page courante de l'annonce avec un message d'erreur
                $this->flash('error', 'Les informations transmises sont incorrectes.');
                return $this->redirect($request, $response, 200, 'admin.gestionaddetail', ['id'=>$valid['ann_id']]);
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.gestionads');

    }

}