<?php

 // Ce module est déclenché lors de la soumission du formulaire sur la page de détail d'une annonce lors de l'appui sur le bouton "modifier l'annonce". 
 //Il va servir à modifier l'annonce courante en BDD et sur les pages du FO et du BO
namespace App\admin;

use App\classes\ClassAdmin;
use App\classes\ClassAds;
use App\helpers\Validation;

class postmodifad extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

         //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());

           // valid est un array qui contient les informations nécessaires à la modification d'une annonce que l'utilisateur transmet par les différents champs sur la view de la gestion
        // d'une annonce
        $valid = $validation
        ->numeric('ann_id')
        ->notEmpty('ann_titre','ann_desc','ann_date_creation')
        ->getDatas();

         // Si les informations transmises sont toutes existantes, les méthodes pour modifier l'annonce en BDD sont utlisées avec les informations transmises par l'utilisateur
        if($valid):

            //instance de la class Ads pour récupérer les méthodes nécessaires à la modification d'une annonce
            $ad = new ClassAds($this->container);

            $in = $ad->modifAd($valid);
            
// Si l'annonce est modifiée, un message confirme la modification et l'utilisateur est redirigé sur la même page de l'annonce
            if($in):
                $this->flash('success', 'L\'annonce a été modifiée !');
            else:
                // sinon, un message d'erreur est affiché sur la page, et l'utilisateur reste sur la même page.
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;
        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;
        return $this->redirect($request, $response, 200, 'admin.gestionaddetail', ['id'=>$valid['ann_id']]);
    }
}