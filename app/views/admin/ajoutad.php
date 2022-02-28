<?php
// Cette page représente la partie visible (view) de l'ajout des annonces. Elle utilise les données envoyées depuis le module ajoutad de app/admin

    $totalads = $request['totalads'];
// On récupère depuis app/admin les données envoyées par le module pour récupérer toutes les annonces
    $totaladsArray = json_decode(json_encode($totalads), true);
    // On les stocke dans un array
    $adFirst = $totaladsArray[0];
    $adFirstIdInt = (int)$adFirst['ann_id'] + 1;
    $today = date("Y-m-d H:i:s");
    // On récupère la date pour l'ajouter comme date de publication
    $cats = $request['cats'] ?? null;
    // On récupère les catégories


    $itemtypes = $request['item_types'] ?? null;
    // On récupère les types d'items
    $liste_items = null;
    foreach($itemtypes as $itemtype):
        $liste_items .= '<option value="' . $itemtype->item_type_id . '" data-type="' . $itemtype->item_type_input . '">' . $itemtype->item_type_nom . '</option>';
    endforeach;
    // On crée l'array liste_items pour proposer à l'utilisateur les différents types d'items à ajouter dans l'annonce

    $auteurs = $request['auteurs'];
    $liste_auteurs = [];
    $liste_auteurs['Choisir un auteur'] = null;
    foreach($auteurs as $c):
        $liste_auteurs[$c->aut_prenom.' '.mb_strtoupper($c->aut_nom)] = $c->aut_id;
    endforeach;
       // On crée l'array auteurs pour proposer à l'utilisateur d'ajouter un auteur parmis ceux trouvés en bdd




    $all_cats = [];
    foreach($cats as $cat):
        $all_cats[$cat->cat_nom] = $cat->cat_id;
    endforeach;
      // On crée l'array cats pour proposer à l'utilisateur d'ajouter une catégorie parmis ceux trouvés en bdd

?>
<style type="text/css">
    .input-group-text{
        border-radius: 0;
    }
    .suppr-item{
    border: 0;
    background-color: white;
}

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">

        <!-- Carte pour l'ajout d'une annonce -->
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    Ajouter une nouvelle annonce
                </div>
                <div class="card-body">

                    <span id="idsite" data-id="<?= $idsite ?>"></span>
                    <?php
                    // formulaire de validation des données pour la création d'une annonce
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->setForm($router->pathFor('admin.postajoutad'),'post','needs-validation');
                     
                        $form->hidden([
                            'name' => 'ann_site_id',
                            'value' => 9
                        ]);
                        // id du site où l'annonce apparaîtra

                        $form->hidden([
                            'name' => 'ann_date_publication',
                            'value' => $today
                        ]);
                        // Date du jour ajoutée en hidden

                        $form->hidden([
                            'id' => 'num_item',
                            'name' => 'num_item',
                            'value' => 0
                        ]);
                        // Ces éléments du formulaires en hidden sont ajoutés automatiquement , on y retrouve la date de publication à la date du jour, le numéro du site correspondant et un item
                        $form->select([
                            'name' => 'ann_aut_id',
                            'label' => 'Auteur',
                            'required' => true,
                            'datas' => $liste_auteurs
                        ]);
                        // On choisit ici un auteur parmis tous cex de la liste

                        $form->input([
                            'type' => 'text',
                            'name' => 'ann_titre',
                            'label' => 'Titre de l\'annonce',
                            'required' => false,
                            'classinput' => 'uppercase',
                            'classbox' => 'mt-3'
                        ]);
                        // On propose ici un titre pour l'annonce
                        $form->select([
                            'name' => 'ann_cat_id',
                            'label' => 'Catégorie',
                            'required' => true,
                            'datas' => $all_cats,
                            'classbox' => 'mt-3'
                        ]);
                        // On propose ici un selecteur qui permet de choisir parmis toutes les catégories disponibles
                      
                        ?>
                        <div class="row">
                            <!-- Ici, on propose les items -->
                            <div class="col-10 mt-3 mb-3">
                                <label for="types">Quelle donnée voulez vous ajouter?</label>
                                <select name="types" class='form-control' id="types">
                                    <!-- Ici on propose à l'utilisateur de choisir parmis les types d'items récupérés en BDD  -->
                                    <?= $liste_items ?>
                                </select>
                       
                            </div>
                            <div class="col-2 mt-3 mb-3">
                                <a href="#" class="ad btn btn-primary mb-3" style="margin-top:2rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>

                        <div id="items" style='margin:20px auto;padding:20px;'>
                        <!--  Les items sélectionnés seront ensuite ajoutés dans cette section grâce à notre script JS -->
                        </div>


    
                        <?php

                        $form->input([
                            'type' => 'text',
                            'name' => 'ann_geoloc',
                            'label' => 'Ville',
                            'required' => true,
                            'classinput' => 'cleave_firstupper',
                            'classbox' => 'mt-3'
                        ]);
                        // On peut inscrire ici le nom de la ville par un input texte
                        $form->input([
                            'type' => 'text',
                            'name' => 'ann_desc',
                            'label' => 'Description',
                            'required' => true,
                            'classinput' => 'cleave_firstupper',
                            'classbox' => 'mt-3'
                        ]);
                          // On peut inscrire ici la description de l'article par un input texte
                    ?>

                    <?php
                        $form->select([
                            'name' => 'ann_active',
                            'label' => 'Annonce visible ?',
                            'required' => true,
                            'datas' => [
                                'Oui' => 1,
                                'Non'=> 0
                            ],
                            'classbox' => 'mt-3'
                        ]);
                        // On choisit un boléen pour indiquer si l'article est visible ou non
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Ajouter',
                            'classbox' => 'form-group text-left',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check',
                            'classbox' => 'mt-3'
                        ]);
                        // Le bouton de validation permet d'envoyer les données à postajoutad
                        $form->end();

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
