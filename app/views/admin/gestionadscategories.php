<?php
//Cette view correspond à la liste des catégories affichées dans le back-office 

    $categories = $request['categories'];
    // On stocke dans cette variable toutes les catégories


   
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gray-800 text-gray-100">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        Liste des
                        catégories
                        <a href="<?= $router->pathFor('admin.ajoutadscategorie') ?>"
                            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Ajouter une catégorie</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Slug</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                       <!-- Le tbody est pris en compte par un fichier ajax qui s'occupe d'itérer sur toutes les catégories à partir  -->
                            </tbody>
                       
                            <tfoot>
                                <tr>
                                <th>Id</th>
                                    <th>Nom</th>
                                    <th>Slug</th>
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