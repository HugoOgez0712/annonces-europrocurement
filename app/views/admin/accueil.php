<?php
$sites = $request['sites'] ?? null;
$monthStats = $request['monthly_stat'] ?? null;

$currentYearStat = $request['currentyear_stat'] ?? null;

$allArt = $request['allArt'] ?? null;

$allCats = $request['allCats'] ?? null;

$allAuteurs = $request['countAuteurs'] ?? null;

$labelsData = $request['labels'] ?? null;

$vuesData = $request['vues'] ?? null;

$vues = implode(",", $vuesData);

$labels = implode(",", $labelsData);

$total = 0;
foreach ($currentYearStat as $k) {
	$total++;
}
$mois = [
	'01' => 'janvier',
	'02' => 'février',
	'03' => 'mars',
	'04' => 'avril',
	'05' => 'mai',
	'06' => 'juin',
	'07' => 'juillet',
	'08' => 'août',
	'09' => 'septembre',
	'10' => 'octobre',
	'11' => 'novembre',
	'12' => 'décembre'

];

?>

<div class="container-fluid">

	<div class="row">



		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
								Nombre d'articles publiés cette année</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?></div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
								Nombre d'articles publiés depuis le début</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $allArt ?></div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
								Nombre de jounalistes actifs</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $allAuteurs ?></div>
						</div>
						<div class="col-auto">
							<i class="bi bi-person-circle fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>





	</div>


	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
				
				<canvas id="myChart" width="400" height="200"></canvas>
				
				</div>
			</div>
		</div>
	</div>




	<div class="row mt-3">

		<div class="col-lg-6">





			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Articles publiés par catégories</h6>
				</div>
				<div class="card-body">
					<?php foreach ($allCats as $cat) : ?>
						<?php $pourcentage = 100 * (int)$cat->count / (int)$allArt ?>
						<h4 class="small font-weight-bold"><?= $cat->cat_nom ?> <span class="float-right"><?= $cat->count ?> articles ont été publiés</span></h4>
						<div class="progress mb-4">
							<div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pourcentage ?>%" aria-valuenow="<?= $cat->count ?>" aria-valuemin="0" aria-valuemax="<?= $allArt ?>"></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-lg-6">

			

			<!-- Card Header - Accordion -->

			<!-- Card Content - Collapse -->
		</div>
	</div>
</div>









</div>
</div>


</div>
