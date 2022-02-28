<?php
// Cette page est la view du back-office qui liste tous les types d'items


    $item_types = $request['item_types'];
// Récupération de tous les types d'items que l'on stocke dans cette variable

   
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        Liste des
                        types d'items
                    </div>
                    <a href="<?= $router->pathFor('admin.ajoutadsitemtype') ?>"
                            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Ajouter un type d'item</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Ce tableau affiche grâce à un script ajax toutes les itérations des types d'items. Le tableau prend comme base le thead pour générer les éléments en complétant avec les informations de $item_types -->
                        <table class="table table-striped" id="table-1" style="width:100%">
                            <thead>
                                <!-- Ces lignes du tableau servent de modèle pour le remplissage du tbody -->
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                        <!-- La requête ajax rempli cette partie avec l'id, le nom et la description -->
                            </tbody>
                            <!-- Ce foreach sert à générer les liens  -->
                            <?php foreach($item_types as $item_type):?>
                            <tfoot>
                                <tr>
                                    <td><a href="<?= $router->pathFor('admin.gestionadsitemtypedetail', ['id'=> $item_type->item_type_id])  ?>"><?= $item_type->item_type_id ?></a></td>
                                    <td><a href="<?= $router->pathFor('admin.gestionadsitemtypedetail', ['id'=> $item_type->item_type_id])  ?>"><?= $item_type->item_type_nom ?></a></td>
                                    <td><?= $item_type->item_type_desc ?></td>
                                    <!-- Ici, on retrouve les liens qui mènent vers les types d'items en fonction de leur id -->
                                </tr>
                            </tfoot>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>

</div>