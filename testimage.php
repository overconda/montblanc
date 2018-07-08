<?php

$arrImageTemplates = array(
    'img-templates/1.png',
    'img-templates/2.png',
    'img-templates/3.png',
    'img-templates/4.png'
);

$width = 800;
$height = 420;

$imageTemplate = $arrImageTemplates[array_rand($arrImageTemplates,1)];

$ImageProfile = "avatar/10155800946948892.jpg";

/// Avatar circle
resizeImage($ImageProfile, $newProfileImage, 280,280);



///////////// TEST MERGE //////////////////
// Create image instances
$dest = imagecreatefromgif(base_url().$newProfileImage);
$src = imagecreatefrompng(base_url().$imageTemplate);







// Copy and merge
imagecopymerge($dest, $src, 80, 80, 0, 0, 800, 420, 75);

$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $dest, 0, 0, 0, 0, $width, $height, $width, $height);

// Output and free from memory
//header('Content-Type: image/jpeg');
imagejpeg($image_p, 'thisisimage.jpg');

imagedestroy($dest);
imagedestroy($src);
imagedestroy($image_p);


exit;

//// Merge right image
$images = array($ImageWhite,$newProfileImage);
ImageOverlap($images,$ImageRight );



///// write text

//$colorText2 = imagecolorallocate($ImageRight, 0x58, 0x3e, 0x3c);


$textUserName = $username;
$fontSize = 26;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $textUserName, $fontURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize /*font size*/, 0 /*angle*/, $x /*x*/, 220 /*y*/, $colorText, $fontURL, $textUserName);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);

$text = "has selected Gems Pavilion Wedding Ring";
$fontSize = 22;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize /*font size*/, 0 /*angle*/, $x /*x*/, 260 /*y*/, $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);


$text = $ring_name;
$fontSize = 46;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x58, 0x3e, 0x3c);
list($x, $y) = ImageTTFCenter($image, $text, $fontURL,$fontSize ); /// Find Center text
imagettftext($image, $fontSize /*font size*/, 0 /*angle*/, $x /*x*/, 336 /*y*/, $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);

$text = "Wedding Ring White Gold 18K";
$fontSize = 16;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize /*font size*/, 0 /*angle*/, $x /*x*/, 370 /*y*/, $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);


/*
$text = "ร่วมสนุกลุ้นรับแหวนคู่รัก Gems Pavilion";
$fontSize = 20;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontThaiURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize , 0 , $x , 360 , $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);

$text = "Wedding Couple Ring และของรางวัลอื่นๆ";
$fontSize = 20;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontThaiURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize , 0 , $x , 390 , $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);

$text = "มูลค่ามากกว่า 50,000 บาท";
$fontSize = 20;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontThaiURL, $fontSize); /// Find Center text
imagettftext($image, $fontSize , 0 , $x , 420 , $colorText, $fontURL, $text);
imagejpeg($image, $ImageRight, 100);
imagedestroy($image);

*/

/*
$text = "Timeless Love Celebrations Story";
$fontSize = 20;
$image = ImageCreateFromJPEG( $ImageRight );
$colorText = imagecolorallocate($image, 0x96, 0x94, 0x95);
list($x, $y) = ImageTTFCenter($image, $text, $fontURL, $fontSize); /// Find Center text
//imagettftext($image, $fontSize /*font size* /, 0 /*angle* /, $x /*x* /, 390 /*y* /, $colorText, $fontURL, $text);
//imagejpeg($image, $ImageRight, 100);
//imagedestroy($image);
//*/

//// Merge button image
$images = array($ImageRight,$ImageButton);
ImageOverlapButton($images,$ImageRight );



$images = array($ImageRing,$ImageRight);
ImageMergeRing($images, $ImageFinish);

///////////////////////////////

//// imagses = array of images (path)
function ImageMerge($images , $newName){
  $number_of_images = count($images);

  $priority = "columns"; // also "rows"

  if($priority == "rows"){
    $rows = 1;
    $columns = $number_of_images/$rows;
    $columns = (int) $columns; // typecast to int. and makes sure grid is even
  }else if($priority == "columns"){
    $columns = 2;
    $rows = $number_of_images/$columns;
    $rows = (int) $rows; // typecast to int. and makes sure grid is even
  }
  $width = 600; // image width
  $height = 630; // image height

  $background = imagecreatetruecolor(($width*$columns), ($height*$rows)); // setting canvas size
  $output_image = $background;

  // Creating image objects
  $image_objects = array();
  for($i = 0; $i < ($rows * $columns); $i++){
    $image_objects[$i] = imagecreatefromjpeg($images[$i]);
  }

  // Merge Images
  $step = 0;
  for($x = 0; $x < $columns; $x++){
    for($y = 0; $y < $rows; $y++){
      imagecopymerge($output_image, $image_objects[$step], ($width * $x), ($height * $y), 0, 0, $width, $height, 100);
      $step++; // steps through the $image_objects array
    }
  }

  imagejpeg($output_image, $newName,100);
  imagedestroy($output_image);
}

//// imagses = array of images (path)
function ImageMergeRing($images , $newName){
  $number_of_images = count($images);

  $priority = "columns"; // also "rows"

  if($priority == "rows"){
    $rows = 1;
    $columns = $number_of_images/$rows;
    $columns = (int) $columns; // typecast to int. and makes sure grid is even
  }else if($priority == "columns"){
    $columns = 2;
    $rows = $number_of_images/$columns;
    $rows = (int) $rows; // typecast to int. and makes sure grid is even
  }
  $width = 600; // image width
  $height = 630; // image height


  $background = imagecreatetruecolor(($width*$columns), ($height*$rows)); // setting canvas size
  $output_image = $background;

  /*
  $logobg = imagecreatefromjpeg("ogimage/_logobg.jpg");
  imagecopymerge($output_image, $logobg, 0, 0, 0, 0, $width, $height, 100);
  */

  // Creating image objects
  $image_objects = array();
  for($i = 0; $i < ($rows * $columns); $i++){
    $image_objects[$i] = imagecreatefromjpeg($images[$i]);
  }

  // Merge Images
  imagecopymerge($output_image, $image_objects[0], 100, 100, 0, 0, $width, $height, 100);
  imagecopymerge($output_image, $image_objects[1], 600, 0 , 0, 0, $width, $height, 100);

  $white = imagecolorallocate($output_image, 255, 255, 255);
  imagefill($output_image, 1, 1, $white);

  imagejpeg($output_image, $newName,100);
  imagedestroy($output_image);
}



function ImageOverlap($images , $newName){
  $width = 600; // image width
  $height = 630; // image height

  $background = imagecreatetruecolor($width, $height); // setting canvas size
  $output_image = $background;

  // Creating image objects
  $image_objects = array();
  for($i = 0; $i < 2; $i++){
    $image_objects[$i] = imagecreatefromjpeg($images[$i]);
  }


  imagecopymerge($output_image, $image_objects[0], 0, 0, 0, 0, $width, $height, 100);
  imagecopymerge($output_image, $image_objects[1], ((600/2)-(128/2)), 40, 0, 0, $width, $height, 100);

  $white = imagecolorallocate($output_image, 255, 255, 255);
  imagefill($output_image, 550, 550, $white);


  imagejpeg($output_image, $newName,100);
  imagedestroy($output_image);
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




function ImageTTFCenter($image, $text, $font, $size, $angle = 0)
{
    $xi = imagesx($image);
    $yi = imagesy($image);

    $box = imagettfbbox($size, $angle, $font, $text);

    $xr = abs(max($box[2], $box[4]));
    $yr = abs(max($box[5], $box[7]));

    $x = intval(($xi - $xr) / 2);
    $y = intval(($yi + $yr) / 2);

    return array($x, $y);
}
?>
