<!-- Bootstrap core JavaScript-->
<script src="js/plugins/jquery.min.js"></script>
<script src="js/plugins/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendor/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Script pour afficher les graphiques -->

<!-- Core plugin JavaScript-->
<script src="js/plugins/jquery.easing.min.js"></script>

<script src="js/plugins/jq_textarea_min.js" ></script>
<script src="js/plugins/jq_autosize.js" ></script>
<script src="js/plugins/validation_bootstrap.js" ></script>
<script src="js/default_admin.js" ></script>
<link rel="stylesheet" href="/js/plugins/trumbowyg/ui/trumbowyg.min.css" />
<script src="js/plugins/trumbowyg/trumbowyg.min.js"></script>
<script src="js/plugins/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" ></script>

<!-- // }7+(KQfz2Zw5 -->
<?php
$minify = ($site_debug) ? null : null;
if( isset($request['js']) ): require_once __DIR__.'/pages/'.$request['js'].'.php'; endif;

$ckArray = array('admin.ajoutpage','admin.gestionpagedetail','admin.ajoutarticle','admin.articledetailadmin');
if(in_array($path,$ckArray)){
?>
<script src="https://cdn.tiny.cloud/1/6k5xkp0bd711jdeib5kn9ulaqsbi8gxs7sqqr62asoxhu3za/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>


    if($('.wysiwyg').length){
        // Configuration de l'upload des images
        function example_image_upload_handler (blobInfo, success, failure, progress) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'ajax_upload_tinymce');

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function() {
                var json;

                if (xhr.status === 403) {
                    failure('HTTP Error: ' + xhr.status, { remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);
                console.log('test');
                console.log(json);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            xhr.onerror = function () {
                failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        };
        <?php
            $albums = isset($request['albums']) && !is_null($request['albums']) ? $request['albums'] : false;
            if($albums):
        ?>
        // Configuration du choix de la galerie
        var dialogGallery =  {
            title: 'Choisissez une galerie',
            body: {
                type: 'panel',
                items: [
                    {
                        type: 'selectbox', // component type
                        name: 'galerie', // identifier
                        label: 'Galeries disponibles',
                        disabled: false, // disabled state
                        size: 3, // number of visible values (optional)
                        items: [
                        <?php
                            $albums = $request['albums'];
                            $count = count($albums);
                            $i = 1;
                            foreach($albums as $k=>$v):
                                echo ($i < $count) ? "{ value: '".$k."', text: '". addslashes($v) ."' }," : "{ value: '".$k."', text: '". addslashes($v) ."'}";
                                $i++;
                            endforeach;
                        ?>
                        ]
                    }
                ]
            },
            buttons: [
                {
                    type: 'cancel',
                    name: 'closeButton',
                    text: 'Cancel'
                },
                {
                    type: 'submit',
                    name: 'submitButton',
                    text: 'Choisir',
                    primary: true
                }
            ],
            onSubmit: function (api) {
                var data = api.getData();
                tinymce.activeEditor.execCommand('mceInsertContent', false, '<p>[' + data.galerie + ']</p>');
                api.close();
            }
        };
        <?php
            endif;
        ?>

        // Configuration du choix de la galerie
        var dialogReadMore =  {
            title: 'Ajouter un lien en lire plus',
            body: {
                type: 'panel',
                items: [
                    {
                        type: 'input', // component type
                        name: 'link', // identifier
                        label: 'Lien',
                        disabled: false, // disabled state
                    },
                    {
                        type: 'input', // component type
                        name: 'text', // identifier
                        label: 'Texte cliquable',
                        disabled: false, // disabled state
                    }
                ]
            },
            buttons: [
                {
                    type: 'cancel',
                    name: 'closeButton',
                    text: 'Cancel'
                },
                {
                    type: 'submit',
                    name: 'submitButton',
                    text: 'Insérer',
                    primary: true
                }
            ],
            onSubmit: function (api) {
                var data = api.getData();
                tinymce.activeEditor.execCommand('mceInsertContent', false, '<p class="readmore"><a href="' + data.link + '" >' + data.text + '</a></p>');
                api.close();
            }
        };

        // Configuration du mailto
        var dialogEmail =  {
            title: 'Email',
            body: {
                type: 'panel',
                items: [
                {
                    type: 'input',
                    name: 'text',
                    label: 'Ancre de lien'
                },
                {
                    type: 'input',
                    name: 'email',
                    label: 'Adresse mail'
                }
                ]
            },
            buttons: [
                {
                    type: 'cancel',
                    name: 'closeButton',
                    text: 'Annuler'
                },
                {
                    type: 'submit',
                    name: 'submitButton',
                    text: 'Insérer',
                    primary: true
                }
            ],
            onSubmit: function (api) {
                var data = api.getData();
                tinymce.activeEditor.execCommand('mceInsertContent', false, '<a href="mailto:' + data.email +'">' + data.text + '</a>');
                api.close();
            }
        };

        tinymce.init({
            images_upload_handler: example_image_upload_handler,
            selector: '.wysiwyg',
            skin : 'small',
            icons: 'small',
            height: 600,
            menubar: true,
            language: 'fr_FR',
            plugins: [
                'advlist autolink lists hr link image imagetools media charmap print preview anchor',
                'searchreplace visualblocks fullscreen tabfocus toc fullscreen',
                'insertdatetime media table hr wordcount visualchars visualblocks advcode powerpaste formatpainter export' 
            ],
            // extended_valid_elements: 'span',
            // valid_elements : "*[*]",
            image_advtab: true,
            formats:{
                underline: { inline: 'u', exact: true },
                strikethrough: { inline: 's', exact: true }
            },
            style_formats: [
					{ 
                    title: 'Titres et blocs', 
                    items: [
                        { title: 'Titre H2', block: 'h2' },
                        { title: 'Titre H3', block: 'h3' },
                        { title: 'Titre H4', block: 'h4' },
						{ title: 'P', inline: 'p' },
   						{ title: 'Div', block: 'div' }
                    ] 
                },
 					{ title: 'Citation', block: 'blockquote', wrapper: true  },
					{ title: 'A lire aussi', block: 'div', classes: 'readmore', styles: {}, exact : true  },
					{ title: 'Encart', block: 'div', classes: 'encart', styles: {}, exact : true  },
                    { title: 'Encadré', selector: 'p,div', classes: 'encadre', styles: {}, exact : true },
                    {title: 'Image Left', selector: 'img', styles: {'float' : 'left','margin': '0 10px 0 10px'}},
                    {title: 'Image Right', selector: 'img', styles: {'float' : 'right','margin': '0 10px 0 10px'}}
            ],         
            toolbar: [
                'code | bold underline strikethrough italic | alignment | hr | bullist numlist | outdent indent | color | fontsizeselect insert | styleselect | Readmore link Email | image media Galerie table | undo redo | removeformat', 
                'copy paste cut | superscript subscript charmap | toc | fullscreen | visualchars visualblocks wordcount | export | wrapselection wrapselection2'
            ],
            setup: function (editor) {
                <?php
                    if($albums):
                ?>
                editor.ui.registry.addButton('Galerie', {
                    icon: 'gallery',
                    tooltip: 'Choisir une galerie',
                    onAction: function () {
                        //Open window
                        editor.windowManager.open(dialogGallery)
                    }
                });
                <?php
                endif;
                ?>
                editor.ui.registry.addButton('Readmore', {
                    icon: 'non-breaking',
                    tooltip: 'Lien "Lire plus"',
                    onAction: function () {
                        //Open window
                        editor.windowManager.open(dialogReadMore)
                    }
                });
					

                editor.ui.registry.addButton('Email', {
                    text: '<strong>@</strong>',
                    tooltip: 'Insérer un lien mailto',
                    onAction: function () {
                        //Open window
                        editor.windowManager.open(dialogEmail)
                    }
                });
                /* example, adding a group toolbar button */
                editor.ui.registry.addGroupToolbarButton('alignment', {
                    icon: 'align-left',
                    tooltip: 'Alignements',
                    items: 'alignleft aligncenter alignright | alignjustify'
                });
                editor.ui.registry.addGroupToolbarButton('color', {
                    icon: 'color-picker',
                    tooltip: 'Couleurs',
                    items: 'forecolor backcolor'
                });
                editor.ui.registry.addButton('wrapselection', {
                    text: 'Encadré',
                    onAction: function () {
                        editor.insertContent("<div class='encadre'>" + editor.selection.getContent() + "</div>");
                    }
                });
                editor.ui.registry.addButton('wrapselection2', {
                    text: 'Encadré pub',
                    onAction: function () {
                        editor.insertContent("<div class='encadre_pub'>" + editor.selection.getContent() + "</div>");
                    }
                });
            },
            content_style: 
                'a{text-decoration:none;}' + 
					 '.readmore{line-height: 1.9em;}' +
                '.readmore:before{border-right: solid 1px #BFBFBF;content: "A lire aussi";display: inline-block;font-weight: 600;margin-right: 10px;padding-right: 10px;border-right: solid 1px #ebe3e5;font-size: 1.1em;}' + 
                '.readmore a{display: inline !important;}' + 
					 '.encart{position:relative;border-bottom:1px solid #e9e5e6;border-top:1px solid #e9e5e6;padding:20px 20px 20px 28px}' +
					 '.encart:before{position: absolute;top: 18px;left: 4px;bottom: 18px;width: 4px;border-radius: 2px;content: "";background-color:#BFBFBF}' +
                '*{font-family: "Inter",sans-serif;}' + 
                '.encadre{ padding:20px;background:#f1f1f1;margin-top:32px;}' + 
                '.encadre_pub{padding:15px;background:#f1f1f1;border:1px solid #cbc5c6;font-size:0.9em;margin-top:32px;}' + 
                'img { max-width:100%; } ' + 
                'blockquote{margin-left:0 !important;border:none !important;margin-top: -16px;margin-bottom: 32px;padding-left: 32px;padding-top: 32px;background-image: url(../img/UI/quote.svg);background-repeat: no-repeat;background-position: top left;background-size: 64px 64px;font-style: italic; } ' +
					 'blockquote p{font-weight: 600; } ' +
                'p{ font-family: "Inter",sans-serif;font-size: 1em;line-height: 1.5em;color: #2B2526; font-weight: 400;-moz-osx-font-smoothing: grayscale;-webkit-font-smoothing: antialiased;}',
            style_formats_autohide : true,
            style_formats_merge: false,
            powerpaste_allow_local_images: true,
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'prompt',
            //quickbars_insert_toolbar: 'quickimage quicktable | h2 h3 bullist numlist formatselect',
            //quickbars_selection_toolbar: 'bold italic superscript subscript | bullist numlist | formatselect | quicklink blockquote',
            image_caption: true,
            /* enable title field in the Image dialog*/
            image_title: true,
            valid_elements : ""
+"a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev"
  +"|shape<circle?default?poly?rect|style|tabindex|title|target|type],"
+"abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase"
  +"|height|hspace|id|name|object|style|title|vspace|width],"
+"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
  +"|shape<circle?default?poly?rect|style|tabindex|title|target],"
+"base[href|target],"
+"basefont[color|face|id|size],"
+"bdo[class|dir<ltr?rtl|id|lang|style|title],"
+"big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"blockquote[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
  +"|onmouseover|onmouseup|style|title],"
+"body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],"
+"br[class|clear<all?left?none?right|id|style|title],"
+"button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur"
  +"|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type"
  +"|value],"
+"caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
  +"|valign<baseline?bottom?middle?top|width],"
+"colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl"
  +"|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
  +"|valign<baseline?bottom?middle?top|width],"
+"dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
+"del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
+"em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],"
+"form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang"
  +"|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit"
  +"|style|title|target],"
+"frame[class|frameborder|id|longdesc|marginheight|marginwidth|name"
  +"|noresize<noresize|scrolling<auto?no?yes|src|style|title],"
+"frameset[class|cols|id|onload|onunload|rows|style|title],"
+"h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"head[dir<ltr?rtl|lang|profile],"
+"hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|size|style|title|width],"
+"html[dir<ltr?rtl|lang|version],"
+"iframe[align<bottom?left?middle?right?top|class|frameborder|height|id"
  +"|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style"
  +"|title|width],"
+"img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height"
  +"|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|src|style|title|usemap|vspace|width],"
+"input[accept|accesskey|align<bottom?left?middle?right?top|alt"
  +"|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang"
  +"|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
  +"|readonly<readonly|size|src|style|tabindex|title"
  +"|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text"
  +"|usemap|value],"
+"ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],"
+"kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick"
  +"|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
  +"|onmouseover|onmouseup|style|title],"
+"legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang"
  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type"
  +"|value],"
+"link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],"
+"map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],"
+"noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"noscript[class|dir<ltr?rtl|id|lang|style|title],"
+"object[align<bottom?left?middle?right?top|archive|border|class|classid"
  +"|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
  +"|vspace|width],"
+"ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|start|style|title|type],"
+"optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick"
  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
  +"|onmouseover|onmouseup|selected<selected|style|title|value],"
+"p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|style|title],"
+"param[id|name|type|value|valuetype<DATA?OBJECT?REF],"
+"pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
  +"|onmouseover|onmouseup|style|title|width],"
+"q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"s[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
+"samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"script[charset|defer|language|src|type],"
+"select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name"
  +"|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style"
  +"|tabindex|title],"
+"small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title],"
+"strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"style[dir<ltr?rtl|lang|media|title|type],"
+"sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title],"
+"table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|class"
  +"|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules"
  +"|style|summary|title|width],"
+"tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id"
  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
  +"|valign<baseline?bottom?middle?top],"
+"td[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
  +"|style|title|valign<baseline?bottom?middle?top|width],"
+"textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name"
  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
  +"|readonly<readonly|rows|style|tabindex|title],"
+"tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
  +"|valign<baseline?bottom?middle?top],"
+"th[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
  +"|style|title|valign<baseline?bottom?middle?top|width],"
+"thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
  +"|valign<baseline?bottom?middle?top],"
+"title[dir<ltr?rtl|lang],"
+"tr[abbr|align<center?char?justify?left?right|bgcolor|char|charoff|class"
  +"|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title|valign<baseline?bottom?middle?top],"
+"tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
+"u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
+"ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
  +"|onmouseup|style|title|type],"
+"var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
  +"|title]"
        });
    }
</script>
<?php 
}
?>
<script>
	 if($('.wysiwyg-middle').length){
        <?php
        $ids = null;
        if(isset($lots)):
            for($i=1;$i<=count($lots);$i++):
                $ids .="'#vlot_texte_$i',";
            endfor;
        endif;
        ?>
        var middleEditor = [<?= $ids ?>,'#vlot_texte','#dos_desc'];
        middleEditor.forEach(function(item){
            console.log(item);
            if($(item).length){
                $(item).trumbowyg();
            }
        });
        
	 	// tinymce.init({
        //     images_upload_handler: example_image_upload_handler,
        //     selector: '.wysiwyg-middle',
        //     skin : 'small',
        //     icons: 'small',
        //     height: 600,
        //     menubar: false,
        //     language: 'fr_FR',
        //     plugins: [
        //         'advlist autolink lists hr link image imagetools media charmap print preview anchor',
        //         'searchreplace visualblocks fullscreen tabfocus toc fullscreen',
        //         'insertdatetime media table hr wordcount visualchars visualblocks advcode powerpaste formatpainter export' 
        //     ],
        //     style_formats: [
		// 			{ 
        //             title: 'Titres et blocs', 
        //             items: [
        //                 { title: 'Titre H2', block: 'h2' },
        //                 { title: 'Titre H3', block: 'h3' },
        //                 { title: 'Titre H4', block: 'h4' },
		// 						{ title: 'P', inline: 'p' },
   		// 					{ title: 'Div', block: 'div' }
        //             ] 
        //         },
		// 			 { title: 'Encart', block: 'div', classes: 'encart', styles: {}, exact : true  },
        //         { title: 'Encadré', selector: 'p,div', classes: 'encadre', styles: {}, exact : true },
        //     ],
           
        //     toolbar: [
        //         'code | copy paste cut | bold underline strikethrough italic | alignment | hr | bullist numlist | outdent indent | ' +
		// 			 'color | insert | styleselect | link  table | undo redo removeformat | fullscreen visualchars visualblocks | export'
        //     ],
        //     setup: function (editor) {
					
        //         /* example, adding a group toolbar button */
        //         editor.ui.registry.addGroupToolbarButton('alignment', {
        //             icon: 'align-left',
        //             tooltip: 'Alignements',
        //             items: 'alignleft aligncenter alignright | alignjustify'
        //         });
        //         editor.ui.registry.addGroupToolbarButton('color', {
        //             icon: 'color-picker',
        //             tooltip: 'Couleurs',
        //             items: 'forecolor backcolor'
        //         });
        //     },
        //     content_style: 
        //         'a{text-decoration:none;}' + 
		// 			 '.encart{position:relative;border-bottom:1px solid #e9e5e6;border-top:1px solid #e9e5e6;padding:20px 20px 20px 28px}' +
		// 			 '.encart:before{position: absolute;top: 18px;left: 4px;bottom: 18px;width: 4px;border-radius: 2px;content: "";background-color:#BFBFBF}' +
        //         '*{font-family: "Inter",sans-serif;}' + 
        //         '.encadre{ padding:20px;background:#f1f1f1;}' + 
        //         'img { max-width:100%; } ' + 
        //         'p{ font-family: "Inter",sans-serif;font-size: 1em;line-height: 1.5em;color: #2B2526; font-weight: 400;-moz-osx-font-smoothing: grayscale;-webkit-font-smoothing: antialiased;}',
        //     style_formats_autohide : true,
        //     style_formats_merge: false,
        //     powerpaste_allow_local_images: true,
        //     powerpaste_word_import: 'clean',
        //     powerpaste_html_import: 'prompt',
        //     //quickbars_insert_toolbar: 'quickimage quicktable | h2 h3 bullist numlist formatselect',
        //     //quickbars_selection_toolbar: 'bold italic superscript subscript | bullist numlist | formatselect | quicklink blockquote',
        //     image_caption: true,
        //     /* enable title field in the Image dialog*/
        //     image_title: true,
        // });
    }

    if($('.wysiwyg-mini').length){
        var miniEditor = ['#pdt_description','#pdt_description_numeric','#vann_entete','#site_texte_abo'];
        miniEditor.forEach(function(item){
            console.log(item);
            if($(item).length){
                $(item).trumbowyg();
            }
        });
                
        // tinymce.init({
        //     language: 'fr_FR',
        //     selector: '.wysiwyg-mini',
        //     skin : 'small',
        //     icons: 'small',
        //     height: 200,
        //     menubar: false,
        //     plugins: [
        //         'advcode advlist autolink lists link charmap powerpaste formatpainter'
        //     ],
        //     toolbar: [
        //         'code | bold underline strikethrough italic | alignment | hr | superscript subscript charmap | bullist numlist | outdent indent | color | insert | styleselect | link | undo redo | removeformat', 
        //     ],
		// 		style_formats: [
		// 			{ 
        //             title: 'Titres et blocs', 
        //             items: [
        //                 { title: 'Titre H2', block: 'h2' },
        //                 { title: 'Titre H3', block: 'h3' },
        //                 { title: 'Titre H4', block: 'h4' },
		// 						{ title: 'P', inline: 'p' },
   		// 					{ title: 'Div', block: 'div' }
        //             ] 
        //         },
 		// 			 { title: 'Citation', block: 'blockquote', wrapper: true  },
		// 			 { title: 'A lire aussi', block: 'div', classes: 'readmore', styles: {}, exact : true  },
		// 			 { title: 'Encart', block: 'div', classes: 'encart', styles: {}, exact : true  },
        //         { title: 'Encadré', selector: 'p,div', classes: 'encadre', styles: {}, exact : true },
        //     ],
		// 		style_formats_autohide : true,
		// 		style_formats_merge: false,
        //     powerpaste_word_import: 'clear',
        //     powerpaste_html_import: 'prompt'
        // });
    }

    if($('.wysiwyg-media').length){
        // ClassicEditor
		// 	.create( document.querySelector( '.wysiwyg-media' ), {
				
		// 		toolbar: {
		// 			items: [
		// 				'mediaEmbed',
		// 			],
		// 			shouldNotGroupWhenFull: true
		// 		},
		// 		language: 'fr',
		// 		licenseKey: '',
				
				
				
		// 	} )
		// 	.then( editor => {
		// 		window.editor = editor;
		
				
				
				
		// 	} )
		// 	.catch( error => {
		// 		console.error( 'Oops, something went wrong!' );
		// 		console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
		// 		console.warn( 'Build id: 59tccs5uy08m-37y78b34k0ix' );
		// 		console.error( error );
		// 	} );
    }
// Fonction pour afficher le graphique du nombre de vues par mois sur la page d'accueil admin
    (function() {

  const ctx = document.getElementById('myChart');
					const myChart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: [<?= $labels ?>],
							datasets: [{
								label: 'Nombre de vues',
								data: [<?= $vues ?>]
                
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});

})();
</script>