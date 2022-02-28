<?php

 // Ce module est déclenché lors de la soumission du formulaire sur la page d'ajout d'un type d'item. Il va servir à créer une nouvelle catégorie en BDD et à l'afficher
    // avec ses informations sur la liste des catégories et lors de sa sélection sur le FO et le BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postajoutadsitemtype extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
 //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());

           // valid est un array qui contient les informations nécessaires à la création d'un type d'item que l'utilisateur transmet par les différents champs sur la view de l'ajout
        // d'un type d'item
        $valid = $validation
        ->notEmpty('item_type_nom', 'item_type_input', 'item_type_desc')
        ->getDatas();
         //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'un type d'item
        $ads = new ClassAds($this->container);
        //var_dump($request->getParsedBody());exit;

          // Si les informations transmises sont toutes existantes, la méthode pour créer un type d'item en BDD est utlisée avec les informations transmises par l'utilisateur
        if($valid):

            $in = $ads->insertItemType($valid);

              // Si le type d'item est crée en BDD, on redirige l'utilsateur sur la page de détail du nouveau type d'item
            if($in):
                $this->flash('success', 'Le type d\'items est ajouté !');
                return $this->redirect($request, $response, 200, 'admin.gestionadsitemtypes');

                  // Sinon, on affiche un message d'erreur et on redirige l'utilisateur vers la page d'ajout d'un type d'item
            else:
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.ajoutadsitemtype');

    }

}