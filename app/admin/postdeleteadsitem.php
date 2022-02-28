<?php
// Ce module est déclenché lorsque l'utilisateur appuie sur le bouton corbeille à coté d'un item sur la page détail d'une annonce
namespace App\admin;

use App\helpers\Validation;
use App\classes\ClassAds;

class postdeleteadsitem extends \App\views\Genere_admin {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {
//instance de la class Ads pour récupérer les méthodes nécessaires à la suppression d'une catégorie
        $ads = new ClassAds($this->container);

         //instance de la class Validation pour récupérer, à la soumission du formulaire, les informations transmises par l'utilisateur
        $validation = new Validation($request->getParsedBody());

         // valid est un array qui contient les informations nécessaires à la suppression d'un item
        $valid = $validation
        ->numeric('item_id')
        ->getDatas();

       // Si les informations transmises sont toutes existantes, la méthode pour supprimer l'item en BDD est utilisée avec les informations transmises par l'utilisateur
        if($valid):
            $del = $ads->deleteItem($valid);

            if($del):
     // Si l'item est supprimé l'utilisateur est redirigé vers la liste des annonces

                $this->flash('success', 'L\'item est supprimé !');
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