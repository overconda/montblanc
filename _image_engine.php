<?php

function imgMergeForFB(
    //// edited by Overconda on Fri 6, Jul 2018
    $profileJPG      /* Profile Image JPG : File path*/,
    $framePNG       /* Frame image with PNG Transparent : File path */,          
    $isResize = false /* Boolean resize profile photo */,
    $photo_w = 0 /* profile photo width to resize */,
    $photo_h = 0 /* profile photo height to resize */,
    $offset_x = 0 /* overlap offset x */,
    $offset_y = 0 /* overlap offset y */

    ////// return Finish URL //////
){
    $arr =  explode('.' ,basename($profileJPG));
    $onlyFileName = $arr[0];
    $ext = $arr[1];

    if($isResize){
        $sourceResized = 'avatar-temp/tmp-' . $onlyFileName . '-'. date('YmdHisv') . '.' . $ext;
        resizeImage($profileJPG, $sourceResized, $photo_w, $photo_h);
    }else{
        $sourceResized = $profileJPG;
    }

    
    

    // create base image
    $photo = imagecreatefromjpeg($sourceResized);
    $frame = imagecreatefrompng($framePNG);

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


    // merge photo with frame and paste on canvas
    imagecopyresized($canvas, $photo, $offset_x, $offset_y, 0, 0, $photo_width, $photo_height,$photo_width, $photo_height); // resize photo to fit in frame
    imagecopy($canvas, $frame, 0, 0, 0, 0, $frame_width, $frame_height);

    
    $FileFinish = 'avatar-temp/' . $onlyFileName . '-' . date('YmdHisv') . '.png';
    imagepng($canvas, $FileFinish);

    // destroy images to free alocated memory
    imagedestroy($photo);
    imagedestroy($frame);
    imagedestroy($canvas);

    return $FileFinish;
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