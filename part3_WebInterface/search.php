<?php

require_once 'php-cassandra/Cassandra/Cassandra.php';

$upper='';
$lower = ''; 
$arr_string = '';
$food_array = array();


if(isset($_POST['submit'])){

    array_push($food_array, "All results are per 100g: <br>"); 

    //$msg ="Please Try Again";
    $upper = $_POST['upper'];
    $lower = $_POST['lower']; 
    // echo $lower; echo $upper; 


    $o_cassandra = new Cassandra();

    $s_server_host     = '127.0.0.1';    // Localhost
    $i_server_port     = 9042; 
    $s_server_username = '';  // We don't have username
    $s_server_password = '';  // We don't have password
    $s_server_keyspace = 'macromunchers';  

    $o_cassandra->connect($s_server_host, $s_server_username, $s_server_password, $s_server_keyspace, $i_server_port);


    for ($x = $lower; $x <= $upper; $x++) {
        $s_cql = "SELECT * FROM calories WHERE calcount = ". $x;
        $st_results = $o_cassandra->query($s_cql);
        

        //$food_items = implode(" ", $st_results);

        foreach($st_results as &$value){
            //print_r($value['calcount']);
            foreach($value['fooditems'] as &$value2){
                //$food_array = array_merge($food_array, $value2);  
                //print_r($value2);
                //$parsed_fooditems = explode(';', $value2); 
                //foreach($parsed_fooditems as $item){
                    $food_string = "(Calories: " .$value['calcount'] . ")\t-\t" . $value2; 
                //}
                array_push($food_array, $food_string); 

            }
        }

        //print_r($st_results); 
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


    $o_cassandra->close();


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

    <title>Calories | Macro Munchers</title>

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

   

    <!-- Portfolio -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h1>Food Search</h1>
                    <br>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success">Calories</button>
                      </div>
                      <div class="btn-group" role="group">
                        <a href="macros.php"><button type="button" class="btn btn-default">Macros</button></a>
                        
                      </div>
                    </div>


                    <hr class="small">
                    <div class="row">
                    
                    <h2>Enter your calorie range: </h2>
                        <br>

                        <form name="form1" method="POST" action="search.php">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="col-md-4 col-md-offset-1">
                                        <center> 
                                            <div class="input-group">
                                              <input type="text" class="form-control" placeholder="Lower bound" aria-describedby="basic-addon1" name="lower">
                                            </div>
                                        </center>

                                    </div>


                                    <div class="col-md-4 col-md-offset-2">
                                        <center> 
                                            <div class="input-group">
                                              <input type="text" class="form-control" placeholder="Upper bound" aria-describedby="basic-addon1" name="upper">
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <center><input type="submit" href="" class="btn btn-dark btn-lg" name="submit"></input></center>
                            <br>
                            <br>
                            <span><?php 
                                    print_r(str_replace(";",",",$arr_string,$i));
                                    ?>
                            </span>

                        </form>
                    </div>
                    <!-- /.row (nested) -->
                    <!-- <a href="#" class="btn btn-dark">View More Items</a> -->
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
