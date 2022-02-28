<?php
$test = $request['test'] ?? null;
$list = $request['list-places'] ?? null;
//Utilisez cette clé dans votre application en la transmettant avec le paramètre key=API_KEY.
// AIzaSyCwK5XWnE0gnynswCrNuFj2YMKl-oHNOXw
$pages = $request['pages'] ??  [];

?>
<?php var_dump($list[0]->{"ann_geoloc"}); 
foreach($list as $ville):
    echo $ville->{"ann_geoloc"};
?>

<?php 
endforeach; ?>
<form autocomplete="off" action="">
  <div class="autocomplete" style="width:300px;" style="position: relative;
  display: inline-block;">
    <input id="myInput" type="text" name="myCountry" placeholder="Country">
  </div>
  <input type="submit">
</form>
<?php 
$villeArray = null;
$villes = array();
$i = 1;
foreach($list as $k => $ville):
    $villes[] =  '"' . $ville->ann_geoloc . '"';
    $i++;
endforeach;
$villeArray = implode(",", $villes);

var_dump($villeArray);
?>


<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3NQcP2xQrv_Bzwq2MdXlgGBxsC8hlEZM&libraries=places&callback=initAutocomplete" async defer></script>

<input type="search" id="address-input" placeholder="Where are we going?" />

<script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
<script>
  var placesAutocomplete = places({
    appId: 'YOUR_PLACES_APP_ID',
    apiKey: 'YOUR_PLACES_API_KEY',
    container: document.querySelector('#address-input')
  });


  const reconfigurableOptions = {
  language: 'de', // Receives results in German
  countries: ['us', 'ru'], // Search in the United States of America and in the Russian Federation
  type: 'city', // Search only for cities names
  aroundLatLngViaIP: false // disable the extra search/boost around the source IP
};
</script>

<script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script> -->
