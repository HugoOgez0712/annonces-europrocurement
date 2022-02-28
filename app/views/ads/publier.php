<?php
$list = $request['list'] ?? null;
$currentAd = $request['currentAd'] ?? null;

$annonce = json_decode(json_encode($currentAd), true);


// $util::dump($list);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajout d'une annonce</h1>
    </div>

    <?php
        $form = new App\helpers\Forms($request['csrf']);
        $form->uploadfile();
        $form->setForm($router->pathFor('admin.postajoutpage'),'post','needs-validation');
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
                            'name' => 'page_idsite',
                            'value' => $idsite
                        ]);
                        $form->input([
                            'type' => 'text',
                            'name' => 'ann_',
                            'label' => 'Nom de la page',
                            'required' => true
                        ]);
                        $form->input([
                            'type' => 'text',
                            'name' => 'page_title',
                            'id' => 'input_titre',
                            'label' => 'Titre de la page',
                            'required' => true,
                            'classbox' => 'mt-3'
                        ]);
                        $form->textarea([
                            'type' => 'text',
                            'name' => 'page_subtitle',
                            'label' => 'Sous-titre',
                            'required' => true,
                            'classbox' => 'mt-3'
                        ]);
                        $form->input([
                            'type' => 'text',
                            'name' => 'page_alias',
                            'id' => 'input_alias',
                            'label' => 'Alias de la page',
                            'required' => true,
                            'classbox' => 'mt-3'
                        ]);
                        $form->textarea([
                            'type' => 'text',
                            'name' => 'page_desc',
                            'label' => 'Description',
                            'required' => true,
                            'classbox' => 'mt-3'
                        ]);
                        $form->textarea([
                            'type' => 'text',
                            'name' => 'page_content',
                            'label' => 'Contenu',
                            'required' => true,
                            'classinput' => 'wysiwyg',
                            'classbox' => 'mt-3'
                        ]);
                        $form->input([
                            'type' => 'text',
                            'name' => 'page_js',
                            'id' => 'inputjs',
                            'label' => 'Nom du JS à charger',
                            'required' => false,
                            'classbox' => 'mt-3'
                        ]);
                        $form->input([
                            'type' => 'text',
                            'name' => 'page_idcontent',
                            'id' => 'inputidcontenu',
                            'label' => 'Id du contenu(CSS)',
                            'required' => false,
                            'classbox' => 'mt-3'
                        ]);
                    ?>
                </div>
            </div>
            <!-- FIN CONTENU -->
        </div>
        <!-- FIN COLONNE DE GAUCHE -->
        <!-- DEBUT COLONNE DE DROITE -->
        <div class="col-12 col-md-4 col-lg-4">


            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    Enregistrement de la page
                </div>
                <div class="card-body">
                    <div class="mt-3">
                        <?php
                            $form->button([
                                'name' => 'sub',
                                'label' => 'Enregistrer la page',
                                'classbox' => 'form-group text-left',
                                'classinput' => 'btn btn-success',
                                'icone' => 'fas fa-check'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN COLONNE DE DROITE -->

    </div>
    <?php
        $form->end();
    ?>
</div>


<!-- Modal -->
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