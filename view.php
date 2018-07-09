<?php

$dbh="";
try {
      $dbh = new PDO('mysql:host=localhost;dbname=overalls_wp393', 'overalls_wp393', '1c5S(1]pah');
    $dbh->query("SET NAMES 'UTF8' ");
} catch (PDOException $e) {
    print "<Br>Error!: " . $e->getMessage() . "<br/>";
    die();
}


$url = $_SERVER['REQUEST_URI'];
//echo "URL: " . $url . "<br>";
$ucode = getLastPathSegment($url);

$u = explode('/', $url);
$ucode = $u[sizeof($u)-1];

$uid=0;
$name= "";
$avatar = "";
$fbog = "";
$sql = "select * from montblanc_fbuser where ucode = '$ucode' ";
//echo "UCODE: " . $sql;
try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
        $uid=$row['uid'];
        $name = $row['fbname'];
        $avatar = $row['avatar'];
        $fbog = $row['fbog'];
	}

}catch (PDOException $ev) {
	$dbh=null;
}

$base_url = "https://overall.studio/montblanc/";

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Montblanc</title>

<meta name="title" content="Mont Blanc" />
<meta name="description" content="" />
<meta name="keyword" content="" />

<meta property="og:url"                content="<?php echo $base_url;?>view/<?php echo $ucode?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="Montblanc Le Petit Prince Collection" />
<meta property="og:description"        content="ร่วมลุ้นรับรางวัลปากกา Montblanc Le Petit Prince Collection มูลค่า 45,000 บาท" />
<meta property="og:image"              content="<?php echo $base_url;?><? echo $fbog;?>" />

<!-- CSS -->
<link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $base_url;?>style.css">

<!--[if lt IE 9]>
    <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
    <script src="bower_components/Respond/dest/respond.min.js"></script>
<![endif]-->


<script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>

<body>
<div class="row justify-content-center">
    <div class="col-md-4">
        <center>
            <img src="<?php echo $base_url;?>main-head.png" class="main-logo"/>
        </center>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <img src='<?php echo $base_url;?><? echo $fbog;?>' class="fbog" />
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class=" text-center">ร่วมลงทะเบียนลุ้นรับปากกา <br>
        Monblanc Le Petit Prince collection 
        <br>มูลค่า 45,000 บาท</h3>
        
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
	<?php
				require_once 'src/Facebook/autoload.php';

				$fb = new Facebook\Facebook([
				  'app_id' => '1940665059558112',
				  'app_secret' => 'd3bc38e32f45c296702b4e8494f54e57',
				  'default_graph_version' => 'v3.0',
				  ]);

				$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email']; // Optional permissions
				$loginUrl = $helper->getLoginUrl('https://overall.studio/montblanc/fb-callback.php', $permissions);

				//echo '<a href="' . htmlspecialchars($loginUrl) . '">Continue with Facebook</a>';

                //echo '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($loginUrl) . '"><i class="fb-icon"></i> Continue with Facebook </a>';
                //echo '<fb:login-button size="xlarge" onlogin="Log.info.bind(\'onlogin callback\')">MMMBBB</fb:login-button>';
                echo "<button class=\"loginBtn loginBtn--facebook\" onclick=\"window.location.href='$loginUrl'\"> ลงทะเบียนด้วย Facebook </button>";
				 ?>
    </div>
</div>
<br><br><br>

</center>
</body>
</html>


<?php

function getLastPathSegment($url) {
    $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
    $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
    $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

    if (substr($path, -1) !== '/') {
        array_pop($pathTokens);
    }
    return end($pathTokens); // get the last segment
}
?>