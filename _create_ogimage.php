<?php

// static image
$ImageWhite = "ogimage/_white.jpg";
$ImageButton = "ogimage/_button.jpg";
$ImageLogo = "ogimage/_logobg.jpg";


/// dynamic image
/*
$ImageRing = "assets/images/ring/6.jpeg";
$ImageProfile = "ogimage/u.jpg";
$newProfileImage = "ogimage/profile-128.jpg";
$ImageFinish = "ogimage/_finish.jpg";
*/



$fontURL = "assets/fonts/MinionPro-Regular.ttf";
$fontThaiURL = "assets/fonts/Trirong-Regular.ttf";

/// Avatar circle
resizeImage($ImageProfile, $newProfileImage, 128,128);
cropCircle($newProfileImage, $newProfileImage);
imagecircle($newProfileImage,5, 128, 128);

$ImageRight = 'ogimage/_right.jpg';

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
function ImageOverlapButton($images , $newName){
  $width = 600; // image width
  $height = 630; // image height

  $background = imagecreatetruecolor($width, $height); // setting canvas size
  $output_image = $background;

  // Creating image objects
  $image_objects = array();
  for($i = 0; $i < 2; $i++){
    $image_objects[$i] = imagecreatefromjpeg($images[$i]);
  }

  //list($width, $height) = getimagesize($image_objects[0]);




  imagecopymerge($output_image, $image_objects[0], 0, 0, 0, 0, $width, $height, 100);
  imagecopymerge($output_image, $image_objects[1], 0, 400, -24, 0, $width, $height, 100);

  //$white = imagecolorallocate($output_image, 255, 255, 255);
  //imagefill($output_image, 550, 550, $white);
  $bg = imagecolorallocate($output_image, 255, 255, 255); // white background
  imagefill($output_image, 1, 580, $bg);


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


function cropCircle($filename, $newName){
  // Step 1 - Start with image as layer 1 (canvas).
  $img1 = ImageCreateFromjpeg($filename); // change this to your image path
  $x=imagesx($img1)-$width ;
  $y=imagesy($img1)-$height;


  // Step 2 - Create a blank image.
  $img2 = imagecreatetruecolor($x, $y);
  $bg = imagecolorallocate($img2, 255, 255, 255); // white background
  imagefill($img2, 0, 0, $bg);


  // Step 3 - Create the ellipse OR circle mask.
  $e = imagecolorallocate($img2, 0, 0, 0); // black mask color

  // Draw a ellipse mask
  // imagefilledellipse ($img2, ($x/2), ($y/2), $x, $y, $e);

  // OR
  // Draw a circle mask
  $r = $x <= $y ? $x : $y; // use smallest side as radius & center shape
  $r-=6;
  imagefilledellipse ($img2, ($x/2), ($y/2), $r, $r, $e);



  // Step 4 - Make shape color transparent
  imagecolortransparent($img2, $e);



  // Step 5 - Make shape color transparent
  imagecopymerge($img1, $img2, 0, 0, 0, 0, $x, $y, 100);



  // Step 6 - Output merged image
  //header("Content-type: image/png"); // output header
  //imagepng($img1); // output merged image
  imagejpeg($img1, $newName,100);

  // Step 7 - Cleanup memory
  imagedestroy($img2); // kill mask first
  imagedestroy($img1); // kill canvas last
}

function imagecircle($source,$r,$x,$y){
  $gpcolor = imagecolorallocate($source, 0xd0, 0xba, 0xbc);
  for($i = 0;$i<=2*pi();$i+=(pi()/180)){
    imageline($source,cos($i)*$r+$x,sin($i)*$r+$y,
      cos($i+(pi()/180))*$r+$x,sin($i+(pi()/180))*$r+$y,$gpcolor);
  }
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
