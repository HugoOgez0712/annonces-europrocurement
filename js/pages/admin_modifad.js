$(document).ready(function(){

    var num = parseInt($('#num_item').attr('value'));

    var selected = $('#types').find(":selected");

    text = selected.text();
    inputType = selected.data('type');
    itemType = selected.attr('value');
    // type = selected.attr('data-type');

    var html = '<div class="item" id="item_' + num + '" data-order="' + num + '">';
    // data('order');
    html += '<input type="hidden" class="order" name="item_order_' + num + '" value="' + num +'">';
    html += '<input type="hidden" name="item_type_id_fk_' + num + '" value="' + itemType +'">';
    if(inputType == "textarea"){
        html += '<div class="mt-3"><textarea class="value" name="item_value_' + num + '">' + num + '</textarea><button class="suppr-item"type="button">supprimer l\'item</button> </div>' ;
    }else{
        html += text + '<div class="mt-3"><input class="value" type="' + inputType + '" name="item_value_' + num + '" value="' + num + '"><button data-id="' + num + '" class="suppr-item"type="button">supprimer l\'item</button></div>';
        // <button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
    }

    html += '</div>'
    $('#items').append(html);

    num = num + 1;
    $('#num_item').val(num);
});

$('.input').on('drop', function(e){
    console.log('je suis le drop');
})

$('body').on('click','.suppr-item',function(e){
    var id = $(this).attr('data-id');
    $('#item_'+id).remove();

    var num = parseInt($('#num_item').attr('value'));
    num = num - 1;
    $('#num_item').val(num);
})

$( "#items" ).sortable({
    axis: "y",
    placeholder: "item-highlight",
    start: function( event, ui ) {
        // console.log(event);
    },
    sort: function( event, ui ) {
        // console.log(event);
    },
    stop: function( event, ui ) {
        // console.log(ui);
    },
    update: function( event, ui ){
        $('#items .item').each(function(index, value){
            neworder = parseInt(index);
            $(this).attr('data-order',neworder);
            $(this).find('.order').attr('value',neworder);
        });
    }
});