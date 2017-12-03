<?php
function get_files($dir) {
	$i=1;
	$thisfile = __FILE__;
	$this_path = pathinfo($thisfile);
	$needfile = "waf.php";
	
    for (; $dir->valid(); $dir->next()) {
        if ($dir->isDir() && !$dir->isDot()) {
            if ($dir->haschildren()) {
                get_files($dir->getChildren());
            };
        }else if($dir->isFile()){
            $file = $dir->getPathName();
			$file_path = pathinfo($file);
			if($file_path['extension']=="php"){
				if($content=file_get_contents($file)){
					$in = "<?php ".'@include "'.$this_path['dirname']."/".$needfile.'";'."?>\n";
					$content = $in.$content;
					file_put_contents($file,$content);
					echo $i."<br>";
					$i=$i+1;
				}else{
					echo "error at ".$file."<br>";
				}
			}
        }
    }
}
$path = "/var/www/html/phpmyadmin_1"; //please modify this if necesscary
$dir = new RecursiveDirectoryIterator($path);
get_files($dir);
?>
