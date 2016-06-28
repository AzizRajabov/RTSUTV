<?php
	
abstract class Upload {
	
	protected $dir;
	protected $mime_types;
	
	public function uploadFile($file) {
		if(!$this->isSecurity($file)) return false;
		$uploadfile = $this->dir."/".$file["name"];
		return move_uploaded_file($file["tmp_name"], $uploadfile);
	}
	
	protected function isSecurity($file) {
		$blacklist = array(".php", "phtml", "php3", "php4", "html", "htm");
		foreach($blacklist as $item){
			if(preg_match("/$item\$/i", $file["name"])) return false;
		}
		
		$type = $file["type"];
		for($i = 0; $i <= count($this->mime_types); $i++) {
			if($type == $this->mime_types[$i]) break;
			if($i + 1 == count($this->mime_types)) return false;
		}
		
		$size = $file["size"];
		if($size > 100000000) return false;
		return true;
	}
}
?>