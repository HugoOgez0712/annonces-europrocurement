<?php
// Cette view correspond à la page de détail d'une annonce que l'on a préalablement choisie. Elle permet de le supprimer ou de le modifier

$currentItemType = $request['currentItemType'];
// Récupération du type d'item de la page courante

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modification d'un type d'items
        <br>
            <span>

                <a href='<?= $site_full_url . '/annonces-' . $currentItemType->item_type_id . '.html' ?>' target="_blank">Voir le type d'items</a>
            </span>
        </h1>
    </div>

    <?php
    // 
        $form = new App\helpers\Forms($request['csrf']);
        $form->uploadfile();
        $form->setForm($router->pathFor('admin.postmodifadsitemtype'),'post','needs-validation');
        $form->setDatas($currentItemType);
    ?>
    <div class="row">
        <!--  DEBUT COLONNE DE GAUCHE -->
        <div class="col-12 col-md-8 col-lg-8">
            <!-- DEBUT CONTENU -->
            <div class="card">
                <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Contenu
                </div>
                <div class="card-body">
                    <?php
                        $form->hidden([
                            'name' => 'item_type_id',
                            'value' => $currentItemType->item_type_id
                        ]);
                    // On récupère l'id du type d'item courant en hidden
                      
                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_nom',
                            'id' => 'input_titre',
                            'label' => 'Titre de la catégorie',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $currentItemType->item_type_nom
                        ]);
                    // Input pour taper le titre du type d'item
                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_input',
                            'id' => 'input_titre',
                            'label' => 'Titre de la catégorie',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $currentItemType->item_type_input
                        ]);
                    // 
                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_desc',
                            'id' => 'input_titre',
                            'label' => 'Titre de la catégorie',
                            'required' => true,
                            'classbox'=> 'mt-3',
                            'value' => $currentItemType->item_type_desc
                        ]);
                    // Input pour rentrer la description du type d'item

                        $form->button([
                            'name' => 'sub',
                            'label' => 'Modifier le type d\'item',
                            'classbox' => 'form-group text-left mt-3',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check'
                        ]);
                // Validation pour envoyer les informations modifiées au module de modification

                        $form->textarea([
                            'type' => 'text',
                            'name' => 'art_texte',
                            'label' => 'Corps de l\'article',
                            'required' => false,
                            'classinput' => 'wysiwyg',
                            'classbox' => 'mt-3'
                        ]);

                    ?>
                </div>
            </div>
            <!-- FIN CONTENU -->
        </div>
        <!-- FIN COLONNE DE GAUCHE -->
        <!-- DEBUT COLONNE DE DROITE -->
        <!-- FIN COLONNE DE DROITE -->

    </div>
    <?php
        $form->end();
    ?>
   
</div>


<div class="row">
    <div class="col-12 col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header text-primary bg-gray-800 text-gray-100">
                    Item type à supprimer
                </div>
            <div class="card-body">
                <div class="mt-5">
                    <div class="p-3">
                        <div class="text-right">
                <?php
                    $form = new App\helpers\Forms($request['csrf']);
                    $form->setForm($router->pathFor('admin.postdeleteadsitemtype'),'post','needs-validation');


                    $form->hidden([
                        'name' => 'item_type_id',
                        'value' => $currentItemType->item_type_id
                    ]);
                    // On récupère l'id de manière cachée pour supprimer le type d'item
                    $form->button([
                        'name' => 'sub',
                        'label' => 'Supprimer le type d\'item',
                        'classbox' => 'form-group text-right',
                        'classinput' => 'btn btn-danger',
                        'icone' => 'fas fa-trash'
                    ]);
                    $form->end();
                     // Formulaire de suppression du type d'item, envoie les informations au module postdeleteadsitemtype
                ?>
                        </div>
                    </div>
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