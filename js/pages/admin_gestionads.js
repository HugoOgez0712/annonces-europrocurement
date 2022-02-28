jQuery(document).ready(function() {

    var boxdatepicker ='<div class="input-group date datetimepicker" id="datetimepicker1" data-target-input="nearest"><input id="in0" type="text" name="clt_creation" class="form-control datetimepicker-input" data-target="#datetimepicker1"/><div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>';

    $('#table-1 tfoot th').each( function () {
        var title = $(this).text();
        if(title != ''){
            if(title == 'Date'){
                $(this).html( boxdatepicker );
            } else {
                $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
            }
        }
    });

    var table = $("#table-1").DataTable({
        "pageLength": 25,
        "columns": [
            { "name": "ann_id"},
            { "name": "ann_titre"},
            { "name": "ann_desc"},
            { "name": "cat_nom"},
            { "name": "ann_date_publication"},
            { "name": "ann_geoloc"}
        ],
        initComplete: function () {
            var r = $('#table-1 tfoot tr');
            r.find('th').each(function(){
                $(this).css('padding', 8);
            });
            $('#table-1 thead').append(r);
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "datatable_ads",
            method: "POST"
        },
        "language": {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            },
            "select": {
                    "rows": {
                        _: "%d lignes séléctionnées",
                        0: "Aucune ligne séléctionnée",
                        1: "1 ligne séléctionnée"
                    }
            }
        }
    });

    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
        $('.datetimepicker', this.footer() ).on('hide.datetimepicker datetimepicker.hide', function(){
            var val = $('#in0').val();
            if ( that.search() !== val ) {
                that
                    .search( val )
                    .draw();
            }
        })
    } );

    $('.datetimepicker').datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY',
    });

})