<?php

$sourcejpg = "avatar/10155800946948892.jpg";
$sourceResized = 'avatar-temp/tmp-10155800946948892.jpg';


//echo "<p><img src='$sourcejpg' /></p> ";
resizeImage($sourcejpg, $sourceResized, 260,260);
//echo "<p><img src='$sourceResized' /></p> ";

// create base image
$photo = imagecreatefromjpeg($sourceResized);
$frame = imagecreatefrompng("img-templates/2.png");

// get frame dimentions
$frame_width = imagesx($frame);
$frame_height = imagesy($frame);

// get photo dimentions
$photo_width = imagesx($photo);
$photo_height = imagesy($photo);

// creating canvas of the same dimentions as of frame
$canvas = imagecreatetruecolor($frame_width,$frame_height);

// make $canvas transparent
imagealphablending($canvas, false);
$col=imagecolorallocatealpha($canvas,255,255,255,127);
imagefilledrectangle($canvas,0,0,$frame_width,$frame_height,$col);
imagealphablending($canvas,true);    
imagesavealpha($canvas, true);

echo " $frame_width : $frame_height // $photo_width : $photo_height <br><br>";




// merge photo with frame and paste on canvas
//imagecopyresized($canvas, $photo, 0, 0, 0, 0, $frame_width, $frame_height,$photo_width, $photo_height); // resize photo to fit in frame
imagecopyresized($canvas, $photo, 48, 48, 0, 0, $photo_width, $photo_height,$photo_width, $photo_height); // resize photo to fit in frame
imagecopy($canvas, $frame, 0, 0, 0, 0, $frame_width, $frame_height);
//imagecopy($frame, $canvas, 0, 0, 0, 0, $frame_width, $frame_height);

$FileFinish = 'avatar-temp/' . date('YmdHis') . '.png';
// return file
//header('Content-Type: image/png');
imagepng($canvas, $FileFinish);

// destroy images to free alocated memory
imagedestroy($photo);
imagedestroy($frame);
imagedestroy($canvas);

echo "<h1>Finish File is <font color=red>$FileFinish</font></h1><br><br>";
echo "<img src='$FileFinish' />";

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