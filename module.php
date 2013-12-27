<?PHP

	$module = nrns::module('jappi', ['express', 'fs']);

	$module->config(function(){
	
		include 'provider/jappiProvider.php';
		
	});

	$module->provider("jappiProvider", "jappi\\jappiProvider");
	
?>