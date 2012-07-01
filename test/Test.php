<?php

   /*
    *   Created by Marc Pacheco on 31/6/12.        *
    *   Copyright (c) 2012, All rights reserved.   *
                                                   */

     // The first parameter requires the Class GeneralColorsOfImage is the directory where located the image (compatible formats: jpg, png, gif, bpm).
     // The second parameter is the precision of reading pixels (recomended between 0.4 and 20, the ideal is between 0.8 and 4). 
     // The third parameter indicates the number of colors to show.
     // If the fourth parameter indicates true, with percentage will be calculated on the amount of colors shown in the third parameter. 
     // If false is indicated, the percentages will be indicated respected the total colors.

     // The colors are listed from highest to lowest quantity in the image.

     
   include_once 'GeneralColorsOfImage.php';

     $GeneralColorsOfImage = new GeneralColorsOfImage('/PaletteColors/prove.jpg', 4, 16, true);
     $array = $GeneralColorsOfImage->getPercentatgeOfColors();


     echo "<link rel='Stylesheet' type='text/css' href='colors.css'/> ";

     if($GeneralColorsOfImage->readPixels()){
        foreach ($array as $color => $percentage){
	     $percentager = round($percentage,3);
	
	     echo "<div class='content'>";
	     echo "<div class='colors' style='background-color:$color;'></div>";
	     echo "<div class='arrow'></div><div class='information'>$percentager%<br>$color </div>";
	     echo "</div>";
         }
             $ex = explode("/", $GeneralColorsOfImage->getImage()); $img = end($ex);
             echo "<img src='$img'/>";
       
     }

?>