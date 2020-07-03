<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

// $path = 'path/to/your/image.jpg';

function detect_text($path)
{
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();

    printf('%d texts found:' . PHP_EOL, count($texts));
    foreach ($texts as $text) {
        print($text->getDescription() . PHP_EOL);

        # get bounds
        $vertices = $text->getBoundingPoly()->getVertices();
        $bounds = [];
        foreach ($vertices as $vertex) {
            $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
        }
        print('Bounds: ' . join(', ',$bounds) . PHP_EOL);
    }

    $imageAnnotator->close();
}

$a=detect_text("../ocr.jpg") ;