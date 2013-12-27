<?PHP

	$module = nrns::module('jappi', ['express']);

	$module->config(function(){
	
		include 'provider/jappiProvider.php';
		
	});

	$module->provider("jappiProvider", "jappi\\jappiProvider");
	
?>