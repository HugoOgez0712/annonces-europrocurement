<?php
// Cette page représente la partie visible (view) de l'ajout des catégories. Elle utilise les données envoyées depuis le module ajoutadscategorie de app/admin

    $categories = $request['categories'];
    // On stocke dans cette variable les catégories

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <!-- Card qui contient le formulaire pour ajouter la catégorie d'annonce -->
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    Ajouter une nouvelle catégorie d'annonce
                </div>
                <div class="card-body">
                    <span id="idsite" data-id="<?= $idsite ?>"></span>
                    <?php

                        $form = new App\helpers\Forms($request['csrf']);
                        $form->setForm($router->pathFor('admin.postajoutadscategorie'),'post','needs-validation');
                    // On utilise le form proposé par Slim et on envoie les données à postajoutadscategorie
                        $form->hidden([
                            'name' => 'site_id',
                            'value' => 9
                        ]);
                          // Ces éléments du formulaires en hidden sont ajoutés automatiquement , on y retrouve le numéro du site correspondant

                        $form->input([
                            'type' => 'text',
                            'name' => 'cat_nom',
                            'label' => 'Nom de la catégorie',
                            'required' => false
                        ]);
                     // On propose ici un input texte pour le nom de la catégorie
                      
                        $form->input([
                            'type' => 'text',
                            'name' => 'cat_slug',
                            'label' => 'URL de la Catégorie',
                            'required' => true
                        ]);
                      // On peut inscrire ici le nom du slug de la catégorie
                    ?>
                    <?php
              
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Ajouter',
                            'classbox' => 'form-group text-left mt-3',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check'
                        ]);
                        // Bouton de soumission du formulaire pour l'envoyer au module postajoutadscategorie
                        $form->end();

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>