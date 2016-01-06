<?php

	set_time_limit(0);

	function delsql($dir) {
		$dh=opendir($dir);
		$int=0;
		//找出所有".sql“ 的文件夹：
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				
				if(!is_dir($fullpath)) {
					
					if(stripos($file, '.sql') !== false || stripos($file, '.log') !== false){
						$int++;
						unlink($fullpath);						
					}
					if(stripos($file, '.csvcache') !== false){
						$int++;
						unlink($fullpath);						
					}
				}
			}
		}
		
		closedir($dh);
		echo "del file count:".$int."<br>" ;
	}		
		$dir=dirname(__FILE__);
		delsql("cache");
		
		
?> 
