<?php

$ucode = 'aar9pw6u';
$fbImage = "avatar-temp/10155800946948892-20180712140825v.png";
$qrImage = "qr-temp/" . $ucode . ".png";

$FinalImage = "ogimage/" . $ucode . ".png";



mergeImage($qrImage, $fbImage, $FinalImage,118,312);

echo "<p><img src='$fbImage' /></p>\n";
echo "<p><img src='$qrImage' /></p>\n";
echo "<p><img src='$FinalImage' /></p>";


function mergeImage($imgForeground, $imgBackground, $imgFinish, $x, $y ){
    //set the source image (foreground)
    $sourceImage = $imgForeground;

    //set the destination image (background)
    $destImage = $imgBackground;

    //get the size of the source image, needed for imagecopy()
    list($srcWidth, $srcHeight) = getimagesize($sourceImage);

    //create a new image from the source image
    $src = imagecreatefrompng($sourceImage);

    //create a new image from the destination image
    $dest = imagecreatefrompng($destImage);

    //set the x and y positions of the source image on top of the destination image
    $src_xPosition = $x; // pixels from the left
    $src_yPosition = $y; // pixels from the top

    //set the x and y positions of the source image to be copied to the destination image
    $src_cropXposition = 0; //do not crop on the side
    $src_cropYposition = 0; //do not crop at the top

    //merge the source and destination images
    imagecopy($dest,$src,$src_xPosition,$src_yPosition,$src_cropXposition,$src_cropYposition,$srcWidth,$srcHeight);

    //output the merged images to a file
    imagepng($dest,$imgFinish);

    //destroy the source image
    imagedestroy($src);

    //destroy the destination image
    imagedestroy($dest);
}
?>