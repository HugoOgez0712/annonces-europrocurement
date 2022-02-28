jQuery(document).ready(function() {
    if($('.p_article').length){
        $('.p_article').each(function() {
            var id = $(this).attr('id');
            gtag('event', 'display_pub_'+id+'', {
                'event_label': 'Affichage de la publicit&eacute; '+id+'',
                'event_category': 'display_pub',
                'event_value' : 'display_pub_'+id+'',
                'non_interaction': true
            });
        });
    }
})