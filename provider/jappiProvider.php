<?php
namespace jappi;
use nrns;


class jappiProvider extends nrns\Provider {
	
	//use \router\routeSetter;
	
	public function __construct($routeProvider, $fs, $expressProvider, $injectionProvider, $rootScope) {
		$this->fs = $fs;
		$this->injectionProvider = $injectionProvider;
		$this->expressProvider = $expressProvider;
		$this->rootScope = $rootScope;
	}
	
	public function scan($dir, $baseRoute='/', $baseDir=null) {
		$that = $this;
		
		if(is_string($dir)) {
			$dir = $this->fs->find($dir);
		}
		
		if(!isset($baseDir)) {
			$baseDir = $dir;
		}
		
		
		foreach($dir->items() as $item) {
			
			 
			if($item->isDir()) {
				
				$filename = $item->getFilename();
				
				if(substr($filename, 0, 1) !== '!') {
					$route = str_replace("__", ":", $baseRoute.'/'.$item->getFilename());
				
				
					foreach($item->filesExt('php') as $ctrlfile) {
						
						$this->_addRouteCtrl($ctrlfile->getName(), $route, $ctrlfile, $baseDir);
					}
				
					$this->scan($item, $route, $baseDir);
				}
				
			}
			
			
		}
		return $this;
	}
	
	
	private function _addRouteCtrl($method, $route, $ctrlfile, $baseDir) {
		$that = $this;
		
		$this->expressProvider->{$method}($route, function()use($ctrlfile, $baseDir, $that, $method){
			return $that->callCtrl($ctrlfile, $baseDir, $method);
		});
	}
	
	public function callCtrl($ctrl, $baseDir, $method) {
		$scope = $this->rootScope;
		
		
		$controller = $ctrl->import();
		return $this->injectionProvider->invoke($controller, ['scope'=>$scope]);
		
	}
	
}





?>