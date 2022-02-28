<?php
// Cette view correspond à la page de détail d'une catégorie que l'on a préalablement choisie
$cat = $request['currentCat'];
// On récupère les infos de l'annonce courante
$categories = $request['categories'];
// Liste de toute les catégories
$catid = $cat->cat_id;

$all_cats = [];
foreach($categories as $categorie):
    $all_cats[$categorie->cat_nom] = $categorie->cat_id;
endforeach;
// On stocke toutes les catégories récupérées dans un tableau

$items = $request['currentItems'];
// On récupère les items par défaut de la catégorie
$itemtypes = $request['item_types'] ?? null;
// On récupère les types d'items disponibles
$liste_items = null;

$default = $request['default'] ?? null;


foreach($itemtypes as $itemtype):
    $liste_items .= '<option value="' . $itemtype->item_type_id . '" data-type="' . $itemtype->item_type_input . '">' . $itemtype->item_type_nom . '</option>';
endforeach;
// On stocke dans ce tableau l'ensemble des options de type d'items récupérés avec le foreach
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modification d'une annonce
        <br>
            <span>
                <a href='<?= $router->pathFor('ads.categorie', ['ann_id'=> $ann_id])  ?>' target="_blank">Voir la catégorie d'annonces</a>
            </span>
        </h1>
    </div>
    <div class="row">
        <!--  DEBUT COLONNE DE GAUCHE -->
        <div class="col-12 col-md-6">
            <!-- DEBUT CONTENU -->
            <div class="card">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Informations catégories
                </div>
                <div class="card-body">
                    
                    <?php
                      // Formulaire de modification des informations de la catégorie
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->uploadfile();
                        $form->setForm($router->pathFor('admin.postmodifadscategorie'),'post','needs-validation');
                        $form->setDatas($cat);

                        $form->hidden([
                            'name' => 'cat_id',
                            'value' => $cat->cat_id
                        ]);
                    //   id de la catégorie courante

                        $form->input([
                            'type' => 'text',
                            'name' => 'cat_nom',
                            'id' => 'input_titre',
                            'label' => 'Titre de la catégorie',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $cat->cat_nom
                        ]);
                        // On propose ici un input pour le nom pour la catégorie
                     
                        $form->textarea([
                            'type' => 'text',
                            'name' => 'cat_slug',
                            'label' => 'Slug de la catégorie',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $cat->cat_slug
                        ]);
                        // On propose ici un slug pour la catégorie
                       
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Modifier la catégorie d\'annonce',
                            'classbox' => 'form-group text-left mt-3',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check'
                        ]);
                           // Soumission du formulaire jusqu'à postmodifadscategorie
                        $form->end();
                    ?>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Construction du formulaire
                </div>
                <div class="card-body">
                            <div class="col-10 mt-3 mb-3">
                                <label for="types">Quelle donnée voulez vous ajouter?</label>
                                <select name="types" class='form-control' id="types">
                                    <?= $liste_items ?>
                                </select>
                                <!-- <a href="#" class="ad btn btn-primary mb-3"><i class="fas fa-plus"></i></a> -->
                            </div>
                            <div class="col-2 mt-3 mb-3">
                                <a href="#" class="ad btn btn-primary mb-3" style="margin-top:2rem;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <?php
                            $form = new App\helpers\Forms($request['csrf']);
                            $form->uploadfile();
                            $form->setForm($router->pathFor('admin.postmodifcatitem'),'post','needs-validation');
                            $form->setDatas($cat);
                            $form->hidden([
                                'name' => 'form_cat_id',
                                'value' => $cat->cat_id
                            ]);
                            $form->hidden([
                                'id' => 'num_item',
                                'name' => 'num_item',
                                'value' => count($items)
                            ]);

                             // Ces éléments du formulaires en hidden sont ajoutés automatiquement , on y retrouve l'id de la catégorie et l'id de l'item par défaut crée pour la catégorie
                        ?>
                        <div id="items" style='margin:20px auto;padding:20px;'>
                          <?php
                        if($items):
                            foreach($items as $i):
                                $html = '<div class="item" id="item_' . $i->item_order . '" data-order="' . $i->item_order . '">';
                                // data('order');
                                $html .= '<input type="hidden" class="order" name="item_order_' . $i->item_order . '" value="' . $i->item_order .'">';
                                $html .= '<input type="hidden" class="cat_id" name="cat_id_' . $i->item_order . '" value="' . $catid .'">';
                                $html .= '<input type="hidden" class="type" name="item_type_id_fk_' . $i->item_order . '" value="' . $i->item_type_id_fk .'">';
                                if($i->item_type_input == "textarea"){
                                    $html .= '<div class="mt-3 input-group"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><button data-id="' . $i->item_order . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button> </div>' ;
                                }else{
                                    $html .=  '<div class="mt-3 input-group mb-3"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><button data-id="' . $i->item_order . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button></div>';
                                 // Pour chaque nouvel item par défaut crée dans la catégorie, on prévoit les éléments html qui correspondent à l'affichage des items et leur ordre d'apparitions
                                }
                                $html .= '</div>';
                                echo $html;
                            endforeach;
                        elseif($default):
                            $j = 0;
                            // $util::dump($default);
                            foreach($default as $i):
                                $html = '<div class="item" id="item_' . $j . '" data-order="' . $j . '">';
                                // data('order');
                                $html .= '<input type="hidden" class="order" name="item_order_' . $j . '" value="' . $j .'">';
                                $html .= '<input type="hidden" class="cat_id" name="cat_id_' . $j . '" value="' . $catid .'">';
                                $html .= '<input type="hidden" class="type" name="item_type_id_fk_' . $j . '" value="'. $i->item_type_id .'">';
                                if($i->item_type_input == "textarea"){
                                    $html .= '<div class="mt-3 input-group"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><button data-id="' . $j . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button> </div>' ;
                                }else{
                                    $html .=  '<div class="mt-3 input-group mb-3"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v "></i></span> <span class="input-group-text">' . $i->item_type_nom . '</span><button data-id="' . $j . '" class="suppr-item"type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></button></div>';
                                    // Même code que celui fait précédemment, mais qui concerne cette fois les items déjà présents par défaut et non modifiés 
                                }
                                $html .= '</div>';
                                echo $html;
                                $j++;
                            endforeach;      
                        endif;
                        ?>
                        </div>
                        <?php
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Enregistrer',
                            'classbox' => 'form-group text-left',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check',
                            'classbox'=> 'mt-3'
                        ]);
                        // Bouton de soumission des items par défaut
                        $form->end();
                        ?>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Suppression
                </div>
                    <div class="card-body">
                    <?php
                    // formulaire pour la suppression d'une catégorie
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->setForm($router->pathFor('admin.postdeleteadscategorie'),'post','needs-validation');


                        $form->hidden([
                            'name' => 'cat_id',
                            'value' => $cat->cat_id
                        ]);
                        // On sélectionne l'id de la catégorie courante 
                        $form->select([
                            'name' => 'ann_cat_id',
                            'label' => 'Selectionnez la catégorie d\'annonces qui remplacera la catégorie supprimée (afin que les articles gardent une catégorie)',
                            'required' => true,
                            'datas' => $all_cats,
                            'classbox' => 'mt-3'
                        ]);
                        // Afin que les articles ayant cette catégorie ne soient pas dépourvus de catégorie, on propose de remplacer celle que l'on va supprimer par une autre
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Supprimer la catégorie d\'annonce',
                            'classbox' => 'form-group text-right',
                            'classinput' => 'mt-5 btn btn-danger',
                            'icone' => 'fas fa-trash'
                        ]);
                        // Soumission du formulaire pour la suppression de la catégorie
                        $form->end();
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="component" tabindex="-1" role="dialog" aria-labelledby="componentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="componentLabel">Composants disponibles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div><button type="button" data-id="0" class="btn btn-primary composants">Formulaire de contact</button></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
</div>