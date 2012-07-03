<?php

    /*
     *   Created by Marc Pacheco on 31/6/12.        *
     *   Copyright (c) 2012, All rights reserved.   *
                                                    */

    class GeneralColorsOfImage{
	
	    var $image;
	    var $height;
	    var $width;
	    var $precision;
	    var $precision2;
	    var $coinciditions;
	    var $maxnumcolors;
	    var $trueper;
	

	
	    public function __construct($image, $precision, $maxnumcolors, $trueper){
		    try {
			    if(!file_exists($image)){
				    throw new Exception("GeneralColorsOfImage Says: <br>FAILED TO OPEN STREAM");
			    }
		    } catch (Exception $e) {
			    echo $e->getMessage();
			    exit();
		    }
		
		    $this->image = $image;
		    $this->maxnumcolors = $maxnumcolors;
		    $this->trueper = $trueper;
		    $this->getImageSize();
		    $this->getImagePrecision($precision);
		    $this->readPixels();
		
	    }

	    public function readPixels() {
		
		    $image = $this->image;
		    $precision = $this->precision;
		    $precision2 = $this->precision2;
		    $width = $this->width;
		    $height = $this->height;
		
		    $arrayex = explode(".", $image);
		    $typeOfImage = end($arrayex);
		
	  	    try {
		
			    switch ($typeOfImage){
			    case "png":
				    $outputimg = "imagecreatefrompng";
				    break;
			    case "jpg":
				    $outputimg = "imagecreatefromjpeg";
				break;
			    case "gif":
				    $outputimg = "imagecreatefromgif";
				    break;
			    case "bpm":
				    $outputimg = "imagecreatefrombmp";
				    break;
			        default: throw new Exception("GeneralColorsOfImage Says: <br> 
			        		 THE EXTENSION OF THE IMAGE IS INCOMPATIBLE OR THERE IS AN OTHER DATA.");
			   
	 		    }
		
		
		    $img = $outputimg($image);
		
	 	    } catch (Exception $e) {
			    echo $e->getMessage()."\n";
			    exit();
		    }
		
		    for($x = 0; $x < $width; $x += $precision) {
			    for($y = 0; $y < $height; $y += $precision2) {
				    
			    	    $index = imagecolorat($img, $x, $y);
				    $rgb = imagecolorsforindex($img, $index);
				    $r = $rgb["red"];
				    $g = $rgb["green"];
				    $b = $rgb["blue"];
				    $ro = round(round(($r / 0x21)) * 0x21);
				    $go = round(round(($g / 0x21)) * 0x21);
				    $bo = round(round(($b / 0x21)) * 0x21);
				    
                                    if($ro == 264){
				    	$ro = 255;
				    }
				    if($go == 264){
				    	$go = 255;
				    }
                 
                                    if($bo == 264){
                    	                $bo = 255;
                                    }
				    
                                    $hexarray[] = $this->RGBToHex($ro, $go, $bo);
			    }
		    }
		    $coinciditions = array_count_values($hexarray);
		    $this->coinciditions = $coinciditions;
		    return true;
		
	    }
	    
	    public function RGBToHex($r, $g, $b){
		
		    $hex = "#";
		    $hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		    $hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		    $hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
	
		    return strtoupper($hex);
	    }
	    
	    public function getPercentatgeOfColors(){
		
		    $coinciditions = $this->coinciditions;
		
		    $total = 0;
		    foreach ($coinciditions as $color => $cuantity) {
			    $total += $cuantity;
		    }
		    foreach ($coinciditions as $color => $cuantity) {
			    $percentage = (($cuantity/$total)*100);
			    $finallyarray["$color"] = $percentage;
		    }
	
		asort($finallyarray);
	        array_keys($finallyarray);
	        $outputarray = array_slice(array_reverse($finallyarray), 0, $this->maxnumcolors);
	    
	        $trueper = $this->trueper;
	    
	        if($trueper) {
	    	
	               $total = 0;
	               foreach ($outputarray as $color => $cuantity) {
	    	           $total += $cuantity;
	               }
	               foreach ($outputarray as $color => $cuantity) {
	    	           $percentage = (($cuantity/$total)*100);
	    	           $finallyarrayp["$color"] = $percentage;
	               }
	               return $finallyarrayp;

	        } else {
	    	
	           return $outputarray;
		    }
	    }
	
	    public function getImageSize() {
		
		    $imgsize = getimagesize($this->image);
		    $height = $imgsize[1];
		    $width = $imgsize[0];
		    $this->height = $height;
		    $this->width = $width;
		    return "x= ".$width."y= ".$height;
	    }
	    
	    public function getImagePrecision($precision) {
		    
                    abs($precision);
		    $precision = (($this->width*$precision)/500);
		    $precision2 = (($this->height*$precision)/500);
		    $this->precision = $precision;
		    $this->precision2 = $precision2;
	 	    return $precision;
	    }
          
            public function getImage(){
             
                   return $this->image;
            }
    }