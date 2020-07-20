<?php


namespace Google\Cloud\Samples\Vision;
// namespace Google\Cloud\Samples\Auth;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
//use Google\Cloud\Storage\StorageClient; 

require  'autoload.php';

// $path = 'factura.jpg' ;

putenv('GOOGLE_APPLICATION_CREDENTIALS=../vendor/construcloud-228009-a3014d1d8608.json');



function texto_ocr($path)
{
//    $imageAnnotator = new ImageAnnotatorClient(['keyFile'=> json_decode(file_get_contents("construcloud-228009-a3014d1d8608.json"), true)]);
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->documentTextDetection($image);
    $annotation = $response->getFullTextAnnotation();

    
    $texto_completo='';

                    
    # print out detailed and structured information about document text
    if ($annotation) {
        foreach ($annotation->getPages() as $page) {
//            echo "<br>Inicio pages";
            foreach ($page->getBlocks() as $block) {
//                echo "<br>--Inicio block";
                $block_text = '';
                foreach ($block->getParagraphs() as $paragraph) {
//                    echo "<br>----Inicio paragraph";
                    foreach ($paragraph->getWords() as $word) {
//                        echo "<br>------Inicio word";
                        foreach ($word->getSymbols() as $symbol) {
//                            echo "<br>--------Inicio symbol";
                            $block_text .= $symbol->getText();
                        }
                        $block_text .= ' ';
                    }
                    $block_text .= "\n";
                }
//                printf('Block content: %s', $block_text);
//                printf('Block confidence: %f' . PHP_EOL, $block->getConfidence());

                # get bounds
                $vertices = $block->getBoundingBox()->getVertices();
                $bounds = [];
                foreach ($vertices as $vertex) {
                    $bounds[] = sprintf('(%d,%d)', $vertex->getX(),
                        $vertex->getY());
                }
//                print('Bounds: ' . join(', ',$bounds) . PHP_EOL);
//                print(PHP_EOL);
                
                $texto_completo.= $block_text . "<br>";
            }
        }
    } else {
        print('No text found' . PHP_EOL);
        $texto_completo.=  "NO ENCONTRATO TEXTO";
    }

    $imageAnnotator->close();
    return $texto_completo ;
}

//echo "<BR><BR><BR><BR>" . detect_document_text($path) ;