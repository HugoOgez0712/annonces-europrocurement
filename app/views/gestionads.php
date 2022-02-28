<?php
    // Page pour lister les annonces.
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        Liste des annonces
                        <a href="<?= $router->pathFor('admin.ajoutad') ?>"
                            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Ajouter une annonce</a>
                                <!-- Lien vers la page d'ajout des annonces -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th>Date</th>
                                    <th>Lieu</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Grâce à une requête ajax, on a la liste des annonces basée sur le nombre de colonne du thead -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th>Date</th>
                                    <th>Lieu</th>
                                </tr>
                            </tfoot>
                           
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