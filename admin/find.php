<?php
session_start();
include("../dbconnect.php");

$sql = "";


$isCmd = isset($_POST['cmd']);
$isUcode = isset($_POST['ucode']);

echo "POST: ";
print_r($_POST);

/////// Update CONFIRM flag
if($isCmd){
    if($_POST['cmd'] == 'confirm'){
        $ucode = $_POST['ucode'];
        $sql = "update montblanc_fbuser set confirm = 1 where ucode = '$ucode' ";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    }
}

$isPhone = isset($_POST['checkphone']);
$isUcode = isset($_POST['ucode']);

$lenPhone = 0;
$lenUcode = 0;



if($isPhone){$lenPhone = strlen(trim($_POST['checkphone']));}
if($isUcode){$lenUcode = strlen(trim($_POST['ucode']));}

if($lenPhone > 0){
    
    $phone = trim($_POST['checkphone']);
    $phone = str_replace('-','',$phone);
    $sql = "select * from montblanc_fbuser where REPLACE(phone,'-','') = '$phone' ";// (firstname is not null and lastname is not null) order by cdate desc ";
    
    
}elseif($lenUcode>0){
    $ucode = trim($_POST['ucode']);
    $sql = "select * from montblanc_fbuser where ucode = '$ucode' ";
}

echo "\n\n\n<!-- SQL : $sql --->\n\n\n";

$data=array();
if(strlen($sql)>0){
    try{
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    
        foreach ($result as $row) {
            
            $data[$i]['ucode'] = $row['ucode'];
            $data[$i]['fbid']  = $row['fbid'];
            $data[$i]['confirm']  = $row['confirm'];
            $data[$i]['fbname']  = $row['fbname'];
            $data[$i]['firstname']  = $row['firstname'];
            $data[$i]['lastname']  = $row['lastname'];
            $data[$i]['avatar']  = '../'. $row['avatar'];
            $data[$i]['email']  = $row['email'];
            $data[$i]['phone']  = $row['phone'];
            $data[$i]['cdate'] = $row['cdate'];
            $i++;
        }
    }catch (PDOException $ev) {
        $dbh=null;
        echo "DB error";
    }
}



$dbh = null;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Montblanc Admin</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />


    

    <style>
        .fbavatar{
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-top: 42px;
            margin-bottom: -24px;
            position: relative;
            top: 50%;
            transform: translateY(-50%);

            /* for NOT-SQUARE Image */
            object-fit: cover;

            border: 8px solid <?php echo $borderColor;?>;
            /*
            green border > 8px solid #0e8c5c
            orange border > 8px solid #ff9d05
            red border > 8px solid #fa0528
            */
        }
        .grey{
            color: #cccccc;
            font-style: italic;
        }
        .grey img{
            opacity: 0.25;
        }
        </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">Montblanc Admin</a>
                <span class="align-right" style=" position: absolute;right: 16px;vertical-align: middle;color: white !important;"><a href="logout.php" style="color: white !important;"><i class="material-icons">input</i>Sign Out</a></span>
            </div>

        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</div>
                    <!--<div class="email">john.doe@example.com</div>-->
                    <!--
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
--> 
            
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="">
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="find.php">
                            <i class="material-icons">how_to_reg</i>
                            <span>Confirm การลงทะเบียน</span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="lucky.php" target="_blank">
                            <i class="material-icons">casino</i>
                            <span>หน้า Lucky Draw</span>
                        </a>
                    </li>
    
                </ul>
            </div>
            <!-- #Menu -->

        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Confirm Registration</h2>
            </div>




            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>SEARCH</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <form method="POST" action="find.php?<?php echo bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));?>">
                                    <table class="table">
                                        <tr><td>เบอร์โทรศัพท์</td><td><input type="text" class="form-control" name="checkphone"></td></tr>
                                        <tr><td colspan=2 align="center">หรือ</td></tr>
                                        <tr><td>QR Code</td><td><input type="text" class="form-control" name="ucode"></td></tr>
                                        <tr><td colspan=2 align="center"><input type=submit value=" ค้นหา "></td></tr>
                                    </table>
                                </form>
                            <?php
                            if(strlen($sql)>0){
                                
                            ?>
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Avatar</th>
                                            <th>FB Name</th>
                                            <th>Full Name</th>
                                            <th>Phone</th>
                                            <!--<th>Email</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $num = 1;
                                            $confirm = 0;
                                            foreach($data as $d){
                                                $ucode = $d['ucode'];
                                                $confirm = $d['confirm'];
                                                $avatar = $d['avatar'];
                                                $fbname = $d['fbname'];
                                                $phone = $d['phone'];
                                                $email = $d['email'];
                                                $fullname = $d['firstname'] . ' ' . $d['lastname'];

                                                $dt = date_create($d['cdate']);
                                                $date = date_format($dt, 'd M - H:i');
                                            
                                                $grey = "";
                                                if(trim($fullname)==""){
                                                    $grey = "class='grey'";
                                                }

                                                echo "\n<form method='post' action='find.php'>";
                                                echo "\n<tr $grey>";
                                                //echo "\n<td>$num</td>";
                                                echo "\n<td><a href='../view/$ucode' target='_blank'>$ucode</a>";
                                                echo "\n\t<div><button type='submit' class='btn btn-success'>Confirm</button></div>";
                                                echo "\n</td>";
                                                echo "\n<td><img src='$avatar' class='fbavatar' /></td>";
                                                echo "\n<td>$fbname</td>";
                                                echo "\n<td>$fullname</td>";
                                                echo "\n<td>$phone</td>";
                                                //echo "\n<td>$email</td>";
                                                //echo "\n<td>$date</td>";
                                                echo "\n</tr>";
                                                echo "\n<input type='hidden' name='cmd' value='confirm'>";
                                                echo "\n<input type='hidden' name='ucode' value='$ucode'>";
                                                echo "\n</form>";
                                                echo "\n";

                                                
                                                $borderColor = "";
                                                if($confirm==1){
                                                    // DONE // Green
                                                    $borderColor = "#0e8c5c";
                                                }elseif($confirm==0){
                                                    // Not yet // Yellow
                                                    $borderColor = "#ffc414";
                                                }

                                                echo "\n<!-- Confirm : [$confirm] -->";
                                                echo "\n<!-- Firstname : [$firstname] -->";
                                                if(trim($fullname)==""){
                                                    $borderColor = "#fa0528"; //red
                                                }
                                                
                                                echo "\n\n<style>.fbavatar{border: 8px solid $borderColor;}</style>";
                                                //print_r($data);
                                                

                                                $num++;
                                            }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
                
            </div>
        </div>
    </section>

    

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>
