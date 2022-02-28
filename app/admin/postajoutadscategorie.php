<?php

    // Ce module est déclenché lors de la soumission du formulaire sur la page d'ajout d'une catégorie. Il va servir à créer une nouvelle catégorie en BDD et à l'afficher
    // avec ses informations sur la liste des catégories et lors de sa sélection sur le FO et le BO
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postajoutadscategorie extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

           //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateurs 
        $validation = new Validation($request->getParsedBody());

         // valid est un array qui contient les informations nécessaires à la création d'une catégorie que l'utilisateur transmet par les différents champs sur la view de l'ajout
        // d'une catégorie
        $valid = $validation
        ->numeric('site_id')
        ->notEmpty('cat_nom', 'cat_slug')
        ->getDatas();
         //instance de la class Ads pour récupérer les méthodes nécessaires à l'ajout d'une catégorie
        $ads = new ClassAds($this->container);
        //var_dump($request->getParsedBody());exit;
          // Si les informations transmises sont toutes existantes, la méthode pour créer une catégorie en BDD est utlisée avec les informations transmises par l'utilisateur
        if($valid):

            $in = $ads->insertCat($valid);

              // Si la catégorie est créée en BDD, on redirige l'utilsateur sur la page de détail de la nouvelle catégorie
            if($in):
                $this->flash('success', 'La catégorie d\'annonces est ajoutée !');
                return $this->redirect($request, $response, 200, 'admin.gestionadscategoriedetail', ['id'=>$in]);

                // Sinon, on affiche un message d'erreur et on redirige l'utilisateur vers la page d'ajout d'une catégorie
            else:
                $this->flash('error', 'Les informations transmises sont incorrectes.');
            endif;

        else:
            $this->flash('error', 'Les informations transmises sont incorrectes.');
        endif;

        return $this->redirect($request, $response, 200, 'admin.ajoutadscategorie');

    }

}