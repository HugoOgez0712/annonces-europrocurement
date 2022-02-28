<?php
namespace App\modules\ajax;

use App\helpers\SimpleImage;
use App\helpers\Util;
use Spatie\ImageOptimizer\OptimizerChainFactory;


class ajax_upload_tinymce {

    public $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function process($request, $response) {

        $id = $_SESSION['admin']['aut_id'];
        $base = "temp/".$id."/";
        $root = __DIR__."/../../../".ROOT."/temp/".$id."/";
        if(!is_dir($root)) mkdir ("$root", 0777);
        $relpath = isset($_REQUEST['path']) ?  $_REQUEST['path'] : ''; // Use options.uploader.pathVariableName

        $path = $root;

        // Do not give the file to load into the category that is lower than the root
        if (realpath($root.$relpath) && is_dir(realpath($root.$relpath)) && strpos(realpath($root.$relpath).'/', $root) !== false) {
            $path = realpath($root.$relpath).'/';
        }

		/***************************************************
		 * Only these origins are allowed to upload images *
		 ***************************************************/
		$accepted_origins = array("https://www.nouvellespublications.com","https://dev.nouvellespublications.com","https://www.tpbm-presse.com","https://dev.tpbm-presse.com","https://dev.le-tout-lyon.fr","https://www.le-tout-lyon.fr", "http://localhost");

		echo $_SERVER['HTTP_ORIGIN'];
		/*********************************************
		 * Change this line to set the upload folder *
		 *********************************************/
		$imageFolder = $path;

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// same-origin requests won't set an origin. If the origin is set, it must be valid.
			if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
				header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			} else {
				header("HTTP/1.1 403 Origin Denied");
				return;
			}
		}

		// Don't attempt to process the upload on an OPTIONS request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			header("Access-Control-Allow-Methods: POST, OPTIONS");
			return;
		}

		reset ($_FILES);
		$temp = current($_FILES);
		if (is_uploaded_file($temp['tmp_name'])){
			/*
			If your script needs to receive cookies, set images_upload_credentials : true in
			the configuration and enable the following two headers.
			*/
			// header('Access-Control-Allow-Credentials: true');
			// header('P3P: CP="There is no P3P policy."');

			// Sanitize input
			// if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
			// 	header("HTTP/1.1 400 Invalid file name.");
			// 	return;
			// }

			// Verify extension
			if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
				header("HTTP/1.1 400 Invalid extension.");
				return;
			}

			// Accept upload if there was no origin, or if it is an accepted origin
			$filetowrite = $imageFolder . Util::urlify($temp['name']);

			move_uploaded_file($temp['tmp_name'], $filetowrite);

			list($width, $height) = getimagesize($filetowrite);

			if($width > 2000 && file_exists($filetowrite)):
				$image = new SimpleImage();
				$image->fromFile($filetowrite)
				->resize(2000, null)
				->toFile($filetowrite);
			endif;

			$optimizerChain = OptimizerChainFactory::create();
			$optimizerChain->optimize($filetowrite);

			// Determine the base URL
			$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
			$baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";

			// Respond to the successful upload with JSON.
			// Use a location key to specify the path to the saved image resource.
			// { location : '/your/uploaded/image/file'}
			echo json_encode(array('location' => '/'.$base . basename($filetowrite)));
		} else {
			// Notify editor that the upload failed
			header("HTTP/1.1 500 Server Error");
		}
    }
}