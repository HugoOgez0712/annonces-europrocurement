<?php
// Cette page représente la partie visible (view) de l'ajout des types d'items. Elle utilise les données envoyées depuis le module ajoutadsitemtype de app/admin
    $item_types = $request['item_types'];
    // On récupère depuis app/admin les données envoyées par le module pour récupérer tous les types d'item
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <!-- Card pour ajout d'un type d'item qui contient le formulaire  -->
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    Ajouter un nouveau type d'items
                </div>
                <div class="card-body">
                    <span id="idsite" data-id="<?= $idsite ?>"></span>
                    <?php
                        $form = new App\helpers\Forms($request['csrf']);
                        $form->setForm($router->pathFor('admin.postajoutadsitemtype'),'post','needs-validation');
                         // formulaire de validation des données pour la création d'un type d'item, le chemin amène vers le module qui post les données
                    


                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_nom',
                            'label' => 'Nom du type d\'item',
                            'required' => false
                        ]);
                        // On propose ici un input texte pour le titre du type d'item
                    
                     
                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_input',
                            'label' => 'Type de champ pour l\'item',
                            'required' => true
                        ]);
                         // On propose ici un input texte pour indiquer quel champ compose le type d'item

                        $form->input([
                            'type' => 'text',
                            'name' => 'item_type_desc',
                            'label' => 'Description du type d\'item',
                            'required' => true
                        ]);
                        // On propose ici un input texte pour décrire le type d'item

                    ?>
                    <?php
              
                        $form->button([
                            'name' => 'sub',
                            'label' => 'Ajouter',
                            'classbox' => 'form-group text-left mt-3',
                            'classinput' => 'btn btn-success',
                            'icone' => 'fas fa-check'
                        ]);
                        $form->end();
                         // Le bouton de validation permet d'envoyer les données à postajoutadsitemtype

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>