$('.ad').on('click',function(e){

    e.preventDefault();

    var num = parseInt($('#num_item').attr('value'));

    var selected = $('#types').find(":selected");

    text = selected.text();
    inputType = selected.data('type');
    itemType = selected.attr('value');
    // type = selected.attr('data-type');

    var html = '<div class="item" id="item_' + num + '" data-order="' + num + '">';
    // data('order');
    html += '<input type="hidden" class="order" name="item_order_' + num + '" value="' + num +'">';
    html += '<input type="hidden" class="type" name="item_type_id_fk_' + num + '" value="' + itemType +'">';
    if(inputType == "textarea"){
        html += '<div class="mt-3 input-group"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v"></i></span><span class="input-group-text"> '+ text +'</span> <textarea class="value form-control" aria-label="With textarea" name="item_value_' + num + '">' + num + '</textarea><button  data-id="' + num + '" class="suppr-item" type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></button></span> </div>' ;
    }else{
        html += '<div class="mt-3 input-group mb-3"> <span class="input-group-text handle"><i class="fas fa-ellipsis-v handle"></i></span> <span class="input-group-text">' + text + '</span><input class="value form-control" type="' + inputType + '" name="item_value_' + num + '" value="' + num + '"><button data-id="' + num + '" class="suppr-item" type="button"> <span class="input-group-text btn btn-primary"><i class="fa fa-trash"></i></span></div>';
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
    if(id !== undefined){
        $('#item_'+id).remove();
        var num = parseInt($('#num_item').attr('value'));
        num = num > 1 ? num - 1 : 0;
        $('#num_item').val(num);
        $('#items .item').each(function(index, value){
            neworder = parseInt(index);
            $(this).attr('id','item_' + neworder);
            $(this).attr('data-order',neworder);
            $(this).find('.order').attr('value',neworder);
            $(this).find('.value').attr('name','item_value_' + neworder);
            $(this).find('.order').attr('name','item_order_' + neworder);
            $(this).find('.type').attr('name','item_type_id_fk_' + neworder);
            $(this).find('.suppr-item').attr('data-id',neworder);
        });
    }else{
        alert('Erreur, veuillez contacter le support technique.');
    }
})

$( "#items" ).sortable({
    axis: "y",
    placeholder: "item-highlight",
    containment: "parent",
    handle: '.handle',
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
            $(this).find('.value').attr('name','item_value_' + neworder);
            $(this).find('.order').attr('name','item_order_' + neworder);
            $(this).find('.type').attr('name','item_type_id_fk_' + neworder);
        });
    }
});


    id = $('input[name=ann_id]').val();
    date = $('input[name=ann_date_creation]').val();
    
    
        $('input[name="files"]').fileuploader({
            limit: 100,
            extensions: ['image/*'],
            changeInput: ' ',
            theme: 'gallery',
            enableApi: true,
            thumbnails: {
                box: '<div class="fileuploader-items">' +
                          '<ul class="fileuploader-items-list">' +
                              '<li class="fileuploader-input"><div class="fileuploader-input-inner"><div class="fileuploader-main-icon"></div> <span>${captions.feedback}</span></div></li>' +
                          '</ul>' +
                      '</div>',
                item: '<li class="fileuploader-item file-has-popup">' +
                           '<div class="fileuploader-item-inner">' +
                               '<div class="actions-holder">' +
                                   '<a class="fileuploader-action fileuploader-action-sort is-hidden" title="${captions.sort}"><i></i></a>' +
                                   '<a class="fileuploader-action fileuploader-action-settings is-hidden" title="${captions.edit}"><i></i></a>' +
                                   '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                                   '<div class="gallery-item-dropdown">' +
                                       '<a class="gallery-action-rename">${captions.setting_rename}</a>' +
                                   '</div>' +
                               '</div>' +
                               '<div class="thumbnail-holder">' +
                                   '${image}' +
                                   '<span class="fileuploader-action-popup"></span>' +
                                   '<div class="progress-holder"><span></span>${progressBar}</div>' +
                               '</div>' +
                               '<div class="content-holder"><h5 title="${name}">${name}</h5><span>${size2}</span></div>' +
                               '<div class="type-holder">${icon}</div>' +
                           '</div>' +
                      '</li>',
                item2: '<li class="fileuploader-item file-has-popup file-main-${data.isMain}">' +
                           '<div class="fileuploader-item-inner">' +
                               '<div class="actions-holder">' +
                                   '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
                                   '<a class="fileuploader-action fileuploader-action-settings" title="${captions.edit}"><i></i></a>' +
                                   '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                                   '<div class="gallery-item-dropdown">' +
                                       '<a class="gallery-action-rename">${captions.setting_rename}</a>' +
                                   '</div>' +
                               '</div>' +
                               '<div class="thumbnail-holder">' +
                                   '${image}' +
                                   '<span class="fileuploader-action-popup"></span>' +
                               '</div>' +
                               '<div class="content-holder"><h5 title="${name}">${data.nom}</h5><span>${size2}</span></div>' +
                               '<div class="type-holder">${icon}</div>' +
                           '</div>' +
                      '</li>',
                itemPrepend: false,
                startImageRenderer: true,
                canvasImage: false,
                onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl),
                        color = api.assets.textToColor(item.format),
                        $plusInput = listEl.find('.fileuploader-input'),
                        $progressBar = item.html.find('.progress-holder');
    
                    // put input first in the list
                    $plusInput.prependTo(listEl);
    
                    // color the icon and the progressbar with the format color
                    item.html.find('.type-holder .fileuploader-item-icon')[api.assets.isBrightColor(color) ? 'addClass' : 'removeClass']('is-bright-color').css('backgroundColor', color);
                    $progressBar.css('backgroundColor', color);
                },
                onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl);
    
                    // check the image size
                    if (item.format == 'image' && item.upload && !item.imU) {
                        if (item.reader.node && (item.reader.width < 100 || item.reader.height < 100)) {
                            alert(api.assets.textParse(api.getOptions().captions.imageSizeError, item));
                            return item.remove();
                        }
    
                        item.image.hide();
                        item.reader.done = true;
                        item.upload.send();
                    }
    
                },
                onItemRemove: function(html) {
                    html.fadeOut(250);
                }
            },
            dragDrop: {
                container: '.fileuploader-theme-gallery .fileuploader-input'
            },
            upload: {
                url: 'ajax_jquery_upload_file_annonce',
                data: {id:id,date:date},
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                beforeSend: function(item) {
                    // check the image size first (onImageLoaded)
                    if (item.format == 'image' && !item.reader.done)
                        return false;
    
                    // add editor to upload data after editing
                    if (item.editor && (typeof item.editor.rotation != "undefined" || item.editor.crop)) {
                        item.imU = true;
                        item.upload.data.name = item.name;
                        item.upload.data.id = item.data.listProps.id;
                        item.upload.data._editorr = JSON.stringify(item.editor);
                    }
    
                    item.html.find('.fileuploader-action-success').removeClass('fileuploader-action-success');
                },
                onSuccess: function(result, item) {
                    var data = {};
    
                    try {
                        data = JSON.parse(result);
                    } catch (e) {
                        data.hasWarnings = true;
                    }
    
                    // if success update the information
                    if (data.isSuccess && data.files.length) {
                        if (!item.data.listProps)
                        item.data.listProps = {};
                        item.title = data.files[0].title;
                        item.name = data.files[0].name;
                        item.data.nom = data.files[0].name;
                        item.size = data.files[0].size;
                        item.size2 = data.files[0].size2;
                        item.data.url = data.files[0].url;
                        item.data.listProps.id = data.files[0].id;
    
                        item.html.find('.content-holder h5').attr('title', item.name).text(item.name);
                        item.html.find('.content-holder span').text(item.size2);
                        item.html.find('.gallery-item-dropdown [download]').attr('href', item.data.url);
                    }
    
                    // if warnings
                    if (data.hasWarnings) {
                        for (var warning in data.warnings) {
                            alert(data.warnings[warning]);
                        }
    
                        item.html.removeClass('upload-successful').addClass('upload-failed');
                        return this.onError ? this.onError(item) : null;
                    }
    
                    delete item.imU;
                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
    
                    setTimeout(function() {
                        item.html.find('.progress-holder').hide();
                        item.html.find('.fileuploader-action-popup, .fileuploader-item-image').show();
                        item.html.find('.fileuploader-action-sort').removeClass('is-hidden');
                        item.html.find('.fileuploader-action-settings').removeClass('is-hidden');
                    }, 400);
                },
                onError: function(item) {
                    item.html.find('.progress-holder, .fileuploader-action-popup, .fileuploader-item-image').hide();
    
                    // add retry button
                    item.upload.status != 'cancelled' && !item.imU && !item.html.find('.fileuploader-action-retry').length ? item.html.find('.actions-holder').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function(data, item) {
                    var $progressBar = item.html.find('.progress-holder');
    
                    if ($progressBar.length) {
                        $progressBar.show();
                        $progressBar.find('span').text(data.percentage + '%');
                        $progressBar.find('.fileuploader-progressbar .bar').height(data.percentage + '%');
                    }
    
                    item.html.find('.fileuploader-action-popup, .fileuploader-item-image').hide();
                }
            },
            sorter: {
                onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl),
                        fileList = api.getFiles(),
                        list = [];
    
                    // prepare the sorted list
                    api.getFiles().forEach(function(item) {
                        if (item.data.listProps)
                            list.push(item.data.listProps.id);
                    });
    
                    if(list.length){
                        // send request
                        $.post('ajax_ordre_images_annonce', {
                            tabs: list
                        });
                    }
    
                }
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl),
                    $plusInput = listEl.find('.fileuploader-input');
    
                // bind input click
                $plusInput.on('click', function() {
                    api.open();
                });
    
                // bind dropdown buttons
                $('body').on('click', function(e) {
                    var $target = $(e.target),
                        $item = $target.closest('.fileuploader-item'),
                        item = api.findFile($item);
    
                    // toggle dropdown
                    $('.gallery-item-dropdown').hide();
                    if ($target.is('.fileuploader-action-settings') || $target.parent().is('.fileuploader-action-settings')) {
                        $item.find('.gallery-item-dropdown').show(150);
                    }
    
                    // rename
                    if ($target.is('.gallery-action-rename')) {
                        $('#galmodal').modal('show')
                        var form = $('#formodif')
                        form.find('input[name="idphoto"]').val(item.data.listProps.id)
                        form.find('input[name="credit"]').val(item.data.listProps.credit)
                        form.find('textarea').val(item.data.listProps.desc)
                        form.find('input[name="titre"]').val(item.data.nom)
    
                        $('.btmodif').click(function(){
    
                            var form = $('#formodif')
                            var idphoto = form.find('input[name="idphoto"]').val();
                            var titre = form.find('input[name="titre"]').val();
                            var credit = form.find('input[name="credit"]').val();
                            var description = form.find('textarea').val();
                            if(idphoto!== undefined && titre !== '' && description !== ''){
                                var df = new FormData();
                                df.append("id", idalbum);
                                df.append("idphoto", idphoto);
                                df.append("titre", titre);
                                df.append("credit", credit);
                                df.append("desc", description);
                                $.ajax({
                                    data: df,
                                    processData: false,
                                    contentType: false,
                                    type: "POST",
                                    url: "ajax_modif_photo_album",
                                    success: function(rep) {
                                        if(rep){
                                            $('#galmodal').modal('hide');
                                            item.title = titre;
                                            item.data.nom = titre;
                                            item.data.listProps.credit = credit
                                            item.data.listProps.desc = description
                                            $item.find('.content-holder h5').attr('title', titre).html(titre);
    
                                            if (item.popup.html)
                                                item.popup.html.find('h5:eq(0)').text(titre);
    
                                            api.updateFileList();
                                        } else {
                                            swal({
                                                title: "Données manquantes",
                                                text: "Vous devez remplir le titre et la description !",
                                                icon: "warning"
                                            })
                                        }
                                    }
                                });
                            } else {
                                swal({
                                    title: "Données manquantes",
                                    text: "Vous devez remplir le titre et la description !",
                                    icon: "warning"
                                })
                            }
    
                        });
                    }
    
                });
            },
            onRemove: function(item) {
                // send request
                console.log(item.data);
                if (item.data.id)
                    $.post('ajax_delete_image_annonce', {
                        img_id: item.data.id,
                        url:item.data.url
                    });
            },
            captions: {
                feedback: 'Déposez ou Cliquez',
                setting_asMain: 'Utiliser comme image principale',
                setting_download: 'Télécharger',
                setting_edit: 'Modifier',
                setting_rename: 'Modifier les détails',
                rename: 'Nouveau nom de l\'image:',
                renameError: 'Veuillez en renseigner un nouveau.',
                imageSizeError: 'L\'image ${name} est trop petite.',
            }
        });
    
    
    
    $('#selectype').on('change', function(){
        if($(this).val() == 5){
            $('#newtype').removeClass('d-none')
        } else {
            $('#newtype').addClass('d-none')
        }
    })
    