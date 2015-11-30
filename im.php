<?php

header('Content-type: image/jpeg');
$image = new Imagick(glob('image/*.jpg'));
foreach($images as $image){

$image->thumbnailImage(1024, 0);

}

$images->writeImages('images/out.jpg',false);

// echo $image;

?>
