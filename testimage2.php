<?php
header('content-type: image/png');

   


$source ='avatar/10155800946948892.jpg';
$watermark = imagecreatefrompng('img-templates/2.png');
$watermark_height = imagesy($watermark);
$watermark_width = imagesx($watermark);


resizeImage($source, $source2, 280,280);
$sourceResized = 'imagetemp.jpg';
imagejpeg($source2,$sourceResized,80);

$image = imagecreatetruecolor($watermark_width,$watermark_height);
$image = imagecreatefromjpeg($sourceResized);

imagecopymerge_alpha($image, $watermark, 0, 0, 0, 0, $watermark_width, $watermark_height, 100  );
imagepng($image);




////////////////////////////////////////////////

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
    // creating a cut resource
    $cut = imagecreatetruecolor($src_w, $src_h);

    // copying relevant section from background to the cut resource
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

    // copying relevant section from watermark to the cut resource
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

    // insert cut resource to destination image
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

function resizeImage($filename, $newName, $max_width, $max_height)
{
    list($orig_width, $orig_height) = getimagesize($filename);

    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0,
                                     $width, $height, $orig_width, $orig_height);


    //return $image_p;
    imagejpeg($image_p, $newName,100);
    imagedestroy($image_p);
}
?>