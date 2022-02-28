<script type="text/javascript" src="<?= $site_full_url ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?= $site_full_url ?>/js/main_<?= time() ?>.js"></script>
<?php
if(isset($page) && isset($page->page_name) && $page->page_name == 'Contact'){
?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= $site_rks ?>"></script>
<script>
$('#formcontact').submit(function(event) {
    event.preventDefault();
    grecaptcha.ready(function() {
        grecaptcha.execute('<?= $site_rks ?>', {action: 'contact'}).then(function(token) {
            $('#formcontact').prepend('<input type="hidden" name="token" value="' + token + '">');
            $('#formcontact').prepend('<input type="hidden" name="action" value="contact">');
            $('#formcontact').unbind('submit').submit();
        });;
    });
});
</script>
<?php
}

if(!is_null($flash->getMessages()) && $path != 'site.index'):
  $alertes = $flash->getMessages();
  if(isset($alertes['error']) && $alertes['error'][0] != "Page inexistante !"): ?>
    <script>
  

        Swal.fire({
            text: '<?= $alertes['error'][0] ?>',
            icon: 'error',
            confirmButtonText: 'ok'
        })
        
    </script>
  <?php elseif(isset($alertes['success'])): ?>
    <script>
        Swal.fire({
            text: '<?= $alertes['success'][0] ?>',
            icon: 'success',
            confirmButtonText: 'ok'
        })
    </script>
  <?php endif;
endif;

if(isset($request['js'])){
    require_once __DIR__.'/site/'.$request['js'].'.php';
}
?>

<script src="js/site/ads.js"></script>

<script>
$(document).ready(function() {

    <?php
    if(strpos("/$path/", 'notfound') OR strpos("/$path/", 'abonnement')):
    else:
    ?>
    new SimpleBar($('#customscrollbar')[0], { autoHide: false, scrollbarMaxSize : 100 });
    <?php
    endif;
    ?>
    $('input[type=email]').mask("A", {
        translation: {
            "A": { pattern: /[\w@\-.+]/, recursive: true }
        }
    });
    <?php
    if(isset($alertes['type']) && $alertes['type'][0] == 'connexion'):
    ?>
      $('#connexion').trigger('click');
    <?php
    elseif(isset($alertes['type']) && $alertes['type'][0] == 'send'):
    ?>
        $('#send').trigger('click');
    <?php
    endif;
    ?>

    // $('a .h5').line(2,'...');

    $('form.newsletter, form.newsletter-input').on('submit',function(e){
        e.preventDefault();
        form = $(this);
        $email = $(this).find('input.email').val();
        $.ajax({
            url: 'ajax_sendinblue',
            type: 'post',
            data: {email: $email},
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, element) {
                    form.find('.submsg').addClass(''+element.code+'').html(element.message).removeClass('d-none');
                });
            },
            error: function(err) {
                form.find('.submsg').addClass('error').html('Vous êtes déjà inscrit à notre newsletter. Merci !').removeClass('d-none');
            }
        });
    });
    <?php
    if($displayAds):
    ?>
    /** DEBUT PUBLICITE  */
    if ($('#EeFnrgsSMlQY').length) {
        $.ajax({
            url: 'ajax_publicites',
            type: 'post',
            data: { page: 'pub',origin: '<?= $slim_uri->getName() ?>'},
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, element) {
                    anaytics = false;
                    if($(''+element.parent+'').length && element.type != 'cover' && element.type != 'popup'){
                        $(''+element.parent+'').html(element.body).fadeIn();
                        $(''+element.parent+'').closest('.ad-container').removeClass('d-none');
                        anaytics = true;
                    }else if($(''+element.parent+'').length && element.type == 'cover' && element.type != 'popup'){
                        $(''+element.parent+'').append(element.body);
                        $(''+element.parent+'').css({
                            'background':'url('+element.coverImg+') top center fixed no-repeat',
                            'padding-top':'220px'
                        });
                        $('body').addClass('covered');
                        anaytics = true;
                    }else if($(''+element.parent+'').length && element.type == 'popup'){
                        $(''+element.parent+'').append(element.body);
                        $('#popup,#popup-bg').fadeIn();
                        anaytics = true;
                    }
                    <?php if(!isset($_SESSION['admin'])): ?>
                    if(anaytics === true){
                        gtag('event', 'display_pub_' + element.id + '', {
                            'event_label': 'Display pub ' + element.id + '',
                            'event_category': 'display_pub',
                            'event_value': 'display_pub_' + element.id + '',
                            'non_interaction': true
                        });
                    }
                    <?php endif; ?>
                });
            },
            error: function(err) {}
        });
    }
    
    <?php if(!isset($_SESSION['admin'])): ?>
    $(document).on('click','.hitpub', function(e) {
        $id = $(this).attr('data-pub');
        $.ajax({ url: 'ajax_hit', type: 'post', data: { 'id': $id, 'type': 'pub' } });
        gtag('event', 'hit_pub_' + $id + '', {
            'event_label': 'Clic sur publicit&eacute; client ' + $id + '',
            'event_category': 'hit_pub',
            'event_value': 'hit_pub_' + $id + '',
            'non_interaction': true
        });
    });
    <?php 
    endif;
    endif;
    ?>
});
</script>
<script>
    $.fn.datepicker.dates['fr'] = {
        days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthsShort: ["Janv.", "Févr.", "Mars", "Avril", "Mai", "Juin", "Juil.", "Août", "Sept.", "Oct.", "Nov.", "Déc."],
        today: "Today",
        clear: "Clear",
        format: "mm/dd/yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
    $("#date-input").datepicker({
        orientation: "bottom left",
        format: "dd/mm/yyyy",
        language: 'fr',
        weekStart: '1',
        autoclose: 'true'
        // startDate: '-3d'
    });
</script>

<?php
if(isset($_SESSION['admin'])):
?>
<script>
  $('#publicitetemp').change(function(e){
    var id = $(this).val();
    $('#content').css({
        'background':'url() top center no-repeat',
        'padding-top':'40px'
    });
    $('.publicite').hide();
    $.ajax({
        url: 'ajax_publicites_admin',
        type: 'post',
        data: {'id': id,origin: '<?= $slim_uri->getName() ?>'},
        dataType: 'json',
        success: function(data) {
            $.each(data, function(index, element) {
                anaytics = false;
                if($(''+element.parent+'').length && element.type != 'cover' && element.type != 'popup'){
                    $(''+element.parent+'').html(element.body).fadeIn();
                    $(''+element.parent+'').closest('.ad-container').removeClass('d-none');
                    anaytics = true;
                }else if($(''+element.parent+'').length && element.type == 'cover' && element.type != 'popup'){
                    $(''+element.parent+'').append(element.body);
                    $(''+element.parent+'').css({
                        'background':'url('+element.coverImg+') top center no-repeat',
                        'padding-top':'220px'
                    });
                    $('body').addClass('covered');
                    anaytics = true;
                }else if($(''+element.parent+'').length && element.type == 'popup'){
                    $(''+element.parent+'').append(element.body);
                    $('#popup,#popup-bg').fadeIn();
                    anaytics = true;
                }
                if(anaytics === true){
                    gtag('event', 'display_pub_' + element.id + '', {
                        'event_label': 'Display pub ' + element.id + '',
                        'event_category': 'display_pub',
                        'event_value': 'display_pub_' + element.id + '',
                        'non_interaction': true
                    });
                }
            });
        },
        error: function(err) {}
    });
  })
</script>
<?php
endif;
?>



<!-- Ce script js correspond à la searchbar de la page listing qui a un autocomplete des villes -->
<?php 
if($path == "ads.listing" && isset($list)): 
    ?>
    <script>
    var countries = [
    <?= $villeArray ?>    
    ];
    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}
</script>
<script>
autocomplete(document.getElementById("myInput"), countries);
</script>
<?php endif; 