<?php


//namespace Google\Cloud\Samples\Vision;
 namespace Google\Cloud\Samples\Auth;

//use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Storage\StorageClient;

require 'autoload.php';

 $path = 'factura.jpg' ;


// Imports the Cloud Storage client library.

function auth_cloud_explicit($projectId, $serviceAccountPath)
{
    # Explicitly use service account credentials by specifying the private key
    # file.
    $config = [
        'keyFilePath' => $serviceAccountPath,
        'projectId' => $projectId,
    ];
    $storage = new StorageClient($config);

    # Make an authenticated API request (listing storage buckets)
    foreach ($storage->buckets() as $bucket) {
        printf('Bucket: %s' . PHP_EOL, $bucket->name());
    }
}
 

auth_cloud_explicit('a3014d1d8608f324f8be3d3dca183b744f327653', "construcloud-228009-a3014d1d8608.json");

function detect_document_text($path)
{
//    $imageAnnotator = new ImageAnnotatorClient(['keyFile'=> json_decode(file_get_contents("construcloud-228009-a3014d1d8608.json"), true)]);
    $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->documentTextDetection($image);
    $annotation = $response->getFullTextAnnotation();

    # print out detailed and structured information about document text
    if ($annotation) {
        foreach ($annotation->getPages() as $page) {
            foreach ($page->getBlocks() as $block) {
                $block_text = '';
                foreach ($block->getParagraphs() as $paragraph) {
                    foreach ($paragraph->getWords() as $word) {
                        foreach ($word->getSymbols() as $symbol) {
                            $block_text .= $symbol->getText();
                        }
                        $block_text .= ' ';
                    }
                    $block_text .= "\n";
                }
                printf('Block content: %s', $block_text);
                printf('Block confidence: %f' . PHP_EOL,
                    $block->getConfidence());

                # get bounds
                $vertices = $block->getBoundingBox()->getVertices();
                $bounds = [];
                foreach ($vertices as $vertex) {
                    $bounds[] = sprintf('(%d,%d)', $vertex->getX(),
                        $vertex->getY());
                }
                print('Bounds: ' . join(', ',$bounds) . PHP_EOL);
                print(PHP_EOL);
            }
        }
    } else {
        print('No text found' . PHP_EOL);
    }

    $imageAnnotator->close();
}

//detect_document_text($path) ;