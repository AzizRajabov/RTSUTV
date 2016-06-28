<?php
	require_once "upload_class.php";

	class UploadVideo extends Upload {
		
		protected $dir = "video";
		protected $mime_types = array("video/mp4", "video/avi", "video/3gp", "video/mpeg", "video/ogg", "video/MP4", "video/flv");
	}
?>