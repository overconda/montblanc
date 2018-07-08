<?php
if (!session_id()) {
    session_start();
}

require_once 'src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1940665059558112',
  'app_secret' => 'd3bc38e32f45c296702b4e8494f54e57',
  'default_graph_version' => 'v3.0',
  ]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}


// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('1940665059558112'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  ///echo '<h3>Long-lived</h3>';
  ///var_dump($accessToken->getValue());
}





$_SESSION['fb_access_token'] = (string) $accessToken;



try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,email,name,picture', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();
//var_dump($user); exit;
/*
object(Facebook\GraphNodes\GraphUser)#21 (1) { 
  ["items":protected]=> array(2) { 
    ["id"]=> string(17) "10155800946948892" 
    ["name"]=> string(20) "Suphajit Pankamonsil" 
  } 
}
*/



$fbId = $user['id'];
$fbName = $user['name'];
$fbEmail = $user['email'];
$fbPictureCurl = $user['picture']['url'];
$fbPictureCurl = "https://graph.facebook.com/" . $fbId . "/picture?width=800";
//$fbPictureCurl = "https://graph.facebook.com/" . $fbId . "/picture?height=480&width=480&access_token=" . $accessToken;
//$fbAvatar = 'https://graph.facebook.com/' . $fbId . '/?fields=picture&type=large" />';
//$fbAvatar = 'https://graph.facebook.com/v3.0/' . $fbId . '/picture';//?width=140&height=140';

$avatarFile = 'avatar/' . $fbId . '.jpg';

/*
echo "<p>$fbId</p>";
echo "<p>$fbName</p>";
echo "<p>$fbPictureCurl</p>";
*/

/// save avatar to local image
$file = file_get_contents($fbPictureCurl);
$myfile = fopen($avatarFile, "w") or die("Unable to open file!");
fwrite($myfile, $file);
fclose($myfile);

//grab_image($fbPictureCurl, $avatarFile ); // not work
//echo "<p><img src='https://overall.studio/montblanc/" . $avatarFile . "' width='480' height='480' /></p>";
//exit;


//echo "<img scr='$fbAvatar' /><br>$fbName<br>$fbId"; exit;
////////////////////////////
//////////////////////////// Database
////////////////////////////

include("dbconnect.php");
$sql = "select count(*) as cc from montblanc_fbuser where fbid = '$fbId' ";

$Found = false;

try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
		if($row['cc']>0){
			$Found =  true;
		}
	}
}catch (PDOException $ev) {
	$dbh=null;
	//echo json_encode('error'=> 'DB error');
}

if(!$Found){
	$now = date("Y-m-d H:i:s");
	$sql = "insert into montblanc_fbuser (fbid, fbname, avatar, email , cdate) values('$fbId', '$fbName' , '$avatarFile', '$fbEmail' ,'$now') ";
	//echo $sql;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
}


$userid=0;
$sql = "select uid from montblanc_fbuser where fbid = '$fbId' ";
try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
		$userid=$row['uid'];
	}

}catch (PDOException $ev) {
	$dbh=null;
}

//echo $userid;

$dbh=null;
////////////////////////////
////////////////////////////
////////////////////////////


$_SESSION['fbId'] = $fbId;

echo "<script>";
echo "localStorage.setItem(\"userid\", '$userid');";
echo "localStorage.setItem(\"fbId\", '$fbId');";
echo "localStorage.setItem(\"fbName\", '$fbName');";
echo "localStorage.setItem(\"fbEmail\", '$fbEmail');";
echo "localStorage.setItem(\"fbAvatar\", '$fbAvatar');";
echo "window.location = 'step2.php';";
echo "</script>";



// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://www.gemspavilion.com/gemspavilionwedding/step2.php');

?>
