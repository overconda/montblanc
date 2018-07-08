<?php
require_once('_image_engine.php');

$arrImageTemplates = array(
    'img-templates/1.png',
    'img-templates/2.png',
    'img-templates/3.png',
    'img-templates/4.png'
);

$imageTemplate = $arrImageTemplates[array_rand($arrImageTemplates,1)];

$ImageProfile = "avatar/10155800946948892.jpg";

$FacebookImage = imgMergeForFB($ImageProfile, $imageTemplate, true , 250, 250, 40, 40);

echo "<p>Finish!</p>";
echo "<p>Image is : $FacebookImage</p>";
echo "<p><img src='$FacebookImage' /></p>";
?>