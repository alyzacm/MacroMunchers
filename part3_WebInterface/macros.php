<?php

require_once 'php-cassandra/Cassandra/Cassandra.php';

$msg = ''; 
$fats = '';
$proteins='';
$carbs = ''; 
$food_array = array();
$arr_string = '';


if(isset($_POST['submit'])){

    $fats = $_POST['fats'];
    $proteins = $_POST['proteins']; 
    $carbs = $_POST['carbs']; 
    // echo $msg; echo $fats; echo $carbs; echo $proteins . "<br>";

    $total = $fats + $proteins + $carbs; 
    $fat_ratio = $fats / $total; 
    $protein_ratio = $proteins / $total; 
    $carbs_ratio = $carbs / $total; 
    // echo $fat_ratio . "<br>"; echo $carbs_ratio . "<br>"; echo $protein_ratio . "<br>";

    //Connect to Cassandra

    $o_cassandra = new Cassandra();

    $s_server_host     = '127.0.0.1';    // Localhost
    $i_server_port     = 9042; 
    $s_server_username = '';  // We don't have username
    $s_server_password = '';  // We don't have password
    $s_server_keyspace = 'macromunchers';  

    $o_cassandra->connect($s_server_host, $s_server_username, $s_server_password, $s_server_keyspace, $i_server_port);

    $fats_csql = "SELECT fooditems FROM fats WHERE fat_ratio = ". round($fat_ratio, 3);
    $fats_item = $o_cassandra->query($fats_csql);

    $carbs_csql = "SELECT fooditems FROM carbs WHERE carbs_ratio = ". round($carbs_ratio,3);
    $carbs_item = $o_cassandra->query($carbs_csql);

    $protein_csql = "SELECT fooditems FROM protein WHERE protein_ratio = ". round($protein_ratio,3);
    $protein_item = $o_cassandra->query($protein_csql);


    foreach($fats_item as &$value){
        foreach($value as &$value2){
            $food_array = array_merge($food_array, $value2); 
        }
    }

    foreach($carbs_item as &$value){
        foreach($value as &$value2){
            $food_array = array_merge($food_array, $value2); 
        }
    }

    foreach($protein_item as &$value){
        foreach($value as &$value2){
            $food_array = array_merge($food_array, $value2); 
        }
    }

    $food_array = array_unique($food_array);

    if(count($food_array) < 10){
        $random_arr = array_rand($food_array, count($food_array)); 
        for($x = 0; $x < count($food_array); $x++){
            //echo $value2[$random_arr[$x]] . "<br>"; 
            $arr_string .= $food_array[$random_arr[$x]] . "<br>"; 
        }
    }
    else{
        $random_arr = array_rand($food_array, 10); 
        for($x = 0; $x < 10; $x++){
            //echo $value2[$random_arr[$x]] . "<br>"; 
            $arr_string .= $food_array[$random_arr[$x]] . "<br>"; 
        }
    }



}


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Macros | Macro Munchers</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top"  onclick = $("#menu-close").click(); >Macro Munchers</a>
            </li>
            <li>
                <a href="homepage.html" onclick = $("#menu-close").click(); >Home</a>
            </li>
            <li>
                <a href="search.php" onclick = $("#menu-close").click(); >Calories</a>
            </li>
            <li>
                <a href="macros.php" onclick = $("#menu-close").click(); >Macros</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
   <!--  <header id="top" class="header">
        <div class="text-vertical-center">
            <h1>Macro Munchers</h1>
            <h3>Find foods that match your calorie range and macro ratios.</h3>
            <br>
            <a href="#about" class="btn btn-dark btn-lg">Get Started</a>
        </div>
    </header> -->

   

    <!-- Portfolio -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h1>Food Search</h1>
                    <br>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <a href="search.php"><button type="button" class="btn btn-default">Calories</button></a>
                      </div>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success">Macros</button></a>
                        
                      </div>
                    </div>
                    <br><br>

                    <h2>Enter your macro ratios: </h2>


                        <form name="form1" method="POST" action="macros.php">

                            <div class="row">
                                <center>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="fats" aria-describedby="basic-addon1" name="fats">
                                </div>  

                                <br>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="carbs" aria-describedby="basic-addon1" name="carbs">
                                </div> 
                                <br>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="proteins" aria-describedby="basic-addon1" name="proteins">
                                </div> 
                                </center>
                            </div>

                            <br>
                            <br>
                            <center><input type="submit" href="" class="btn btn-dark btn-lg" name="submit"></input></center>
                            <br>
                            <br>
                            <span> <?php 
                                    print_r(str_replace(";",",",$arr_string,$i));
                                    ?>
                            </span>
                        </form> 

                    
                    <!-- <span><?php echo $msg; echo $fats; echo $carbs; echo $proteins; ?></span> -->
                </div>
                <!-- /.col-lg-10 -->



            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong>Macro Munchers</strong>
                    </h4>
                    <p>University of California, Riverside</p>
                    <p> 900 University Ave, Riverside, CA 92521 </p>
                    <ul class="list-unstyled">
                        <li> Alyza Malunao </li>
                        <li> Brittany Seto </li>
                        <li> Justin Jan </li>
                    </ul>
                    <br>
                    
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; Macro Munchers 2016</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>

</body>

</html>
