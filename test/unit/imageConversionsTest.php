<?php

define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'test');
define('SF_DEBUG',       true);

include(dirname(__FILE__).'/../bootstrap/unit.php'); 

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();

$t = new lime_test(5, new lime_output_color());

$t->diag('unit test to verify the image conversion functionalities');

// a test model, and the corresponding model, must exist in the DB
// with these fields: ID, BLOB

$t->diag('Tests beginning');

// test image existance
$filename = dirname(__FILE__).'/test.jpeg';
$t->ok(stat($filename) != false, 'the file exists');

// test image dimensions
$image = new sfImage($filename, 'image/jpeg');
$t->ok($image instanceof sfImage, 'the image was read into sfImage');
$t->diag('image width: ' . $image->getWidth());
$t->diag('image height: ' . $image->getHeight());
$t->diag("image type: " . $image->getMimeType());
$t->diag("image quality: " . $image->getQuality());

// add image to DB
$rec = new sfTestImages();
$rec->setPicture($filename);
$rec->save();
$rec_id = $rec->getId();
$t->diag('rec id: ' . $rec_id);
unset($rec);

// fetch image from db
$rec = sfTestImagesPeer::retrieveByPk($rec_id);
$t->ok($rec instanceof sfTestImages, 'the image was stored and retrieved from the DB');


$db_img_str = $rec->getPicture();

$new_img = new sfImage();
$new_img->setMimeType('image/jpeg');
$new_img->setQuality(20);
$new_img->loadString($db_img_str);
$t->ok($new_img->getWidth() == $image->getWidth(), 'the new image has been correctly created');
$t->diag('new image quality: ' . $new_img->getQuality());

// resize image
$new_img->resize(30, null);
$t->ok($new_img->getWidth() == 30, 'image was resized');

// save image to filesystem
$new_img->saveAs(dirname(__FILE__) . '/newtest.jpeg');

// remove new image

// remove all records
sfTestImagesPeer::doDeleteAll();


