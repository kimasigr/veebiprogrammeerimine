<?php
	class Photoupload {
		/*public $testPublic;
		private $testPrivate;*/
		//protected // kolmas muutuja variant
		private $tempFile;
		private $imageFileType;
		private $myTempImage;
		
		function __construct($tempFile, $fileType){
			/*$this->testPublic = "Täitsa avalik asjake!";
			$this->testPrivate = $x;
			echo $this->testPrivate;*/
			$this->tempFile = $tempFile;
			$this->imageFileType = $fileType;
			
		}
		
		private function createImage(){
			//lähtudes failiformaadist loome pildiobjekti
			if($this->imageFileType == "jpg" or $imageFileType == "jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempFile);
			}
			if($this->imageFileType == "png"){
				$this->myTempImage = imagecreatefrompng($this->tempFile);
			}
			if($this->imageFileType == "gif"){
				$this->myTempImage = imagecreatefromgif($this->tempFile);
			}
		}
		
		public function resizePhoto($maxWidth, $maxHeight){
			$this->createImage();
			//teeme kindlaks originaalsuuruse
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / $maxWidth;
			} else {
				$sizeRatio = $imageHeight / $maxHeight;
			}
			//muudame suurust
			$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight  / $sizeRatio));
		}
		
		private function resizeImage($image, $origW, $origH, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			//säilitame läbipaistvuse png piltide jaoks
			imagesavealpha($newImage, true);
			$transColor = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
			imagefill($newImage, 0, 0, $transColor);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
			return $newImage;
		}
		
		public function addWatermark($watermarkFile, $marginRight, $marginBottom){
			//lisame vesimärgi
			$stamp = imagecreatefrompng($watermarkFile);
			$stampWidth = imagesx($stamp);
			$stampHeight = imagesy($stamp);
			$stampPosX = imagesx($this->myImage) - $stampWidth - $marginRight;
			$stampPosY = imagesy($this->myImage) - $stampHeight - $marginBottom;
			imagecopy($this->myImage, $stamp, $stampPosX, $stampPosY, 0, 0, $stampWidth, $stampHeight);
		}
		
		public function addTextWatermark($text){
			//lisame teksti
			$textColor = imagecolorallocatealpha($this->myImage,255,255,255,60);//0...127
			imagettftext($this->myImage, 20, -45, 10, 25, $textColor, "../../graphics/arial.ttf", $text);
		}
		
		public function savePhoto($directory, $filename){
			$target_file = $directory .$filename;
			//faili salvestamine
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				if(imagejpeg($this->myImage, $target_file, 90)){
						$notice = " Laeti üles!";
					} else {
						$notice = "FAili üleslaadimine ebaõnnesus!";
					}
			}
			if($this->imageFileType == "png"){
				if(imagejpeg($this->myImage, $target_file, 90)){
						$notice = " Laeti üles!";
					} else {
						$notice = "FAili üleslaadimine ebaõnnesus!";
					}
			}
			if($this->imageFileType == "gif"){
				if(imagegif($this->myImage, $target_file)){
					$notice = "Fail laeti üles!";
				} else {
					$notice = "Faili üleslaadimine ebaõnnestus!";
				}
			}
			return $notice;
		}
		public function clearImages(){
			imagedestroy($this->myTempImage);
			imagedestroy($this->myImage);
		}
		
		public function saveOriginal($directory, $filename){
			$target_file = $directory .$filename;
			if (move_uploaded_file($this->tempFile, $target_file)) {
				$notice .= "Originaalfail laeti üles!";
			} else {
				$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
			}
			return $notice;
		} 
		

	} // class lõppeb, kõik selles failis peab jääma classi sisse
?>