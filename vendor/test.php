<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'autoload.php';

use Google\Cloud\Vision\VisionClient;

$vision = new VisionClient(['keyFile'=> json_decode(file_get_contents("construcloud-228009-a3014d1d8608.json"), true)]);

// Annotate an image, detecting faces.
$image = $vision->image(
    fopen('sombreros2.jpg', 'r'),
    ['faces']
);

$annotation = $vision->annotate($image);

// Determine if the detected faces have headwear.
foreach ($annotation->faces() as $key => $face) {
    if ($face->hasHeadwear()) {
        echo "Face $key has headwear.\n"; 
    }
}
  
echo "TERMINADO"; 