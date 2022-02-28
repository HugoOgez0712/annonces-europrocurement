<?php
$test = $request['test'] ?? null;
$list = $request['list-by-category'] ?? null;
$pages = $request['pages'] ??  [];

// $util::dump($list);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liste-annonces-par-catégorie</title>
</head>
<body>
    <ul>
<?php foreach($list as $k => $annonce): ?>
    <li><a href="<?= $router->pathFor('ads.detail'),'-',$annonce->ann_id ?>"><?= $annonce->ann_titre?> catégorie : <?= $annonce->cat_nom ?></a></li>
    <?php endforeach; ?>
</ul>
</body>
</html>