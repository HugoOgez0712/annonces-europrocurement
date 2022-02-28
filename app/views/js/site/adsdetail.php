<script> jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        console.log('row click');
        window.location = $(this).data("href");
    });
});
</script>

<script type="text/javascript">
  document.getElementById('categorie').value = "<?php echo $_GET['categorie'];?>";
  console.log('adsdetail est chargé :)');
</script>