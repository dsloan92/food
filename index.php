<?php


//Start session
session_start();
//require auto-load file
require ("vendor/autoload.php");
//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Create an instance of the base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function(){
    $view = new Template();
    echo $view->render('views/home.html');
    //echo "<h1>Hello Food</h1>";
});

//define a breakfast route
$f3->route('GET /breakfast', function(){
   $view = new Template();
   echo $view->render('views/breakfast.html');
});

//defind a lunch route
$f3->route('GET /lunch', function(){
   $view = new Template();
   echo $view->render('views/lunch.html');
});

//define a buffet breakfast route
$f3->route('GET /breakfast/buffet', function(){
   $view = new Template();
   echo $view->render('views/breakfast-buffet.html');
});

//Define a route that accepts a food parameter
$f3->route('GET /@item', function ($f3, $params){
    var_dump($params);
    $item = $params['item'];
    echo "<p>You ordered $item</p>";

    $foodWeServe = array("tacos", "pizza", "lumpia");
    if (!in_array($item, $foodWeServe)){
        echo "<p>Sorry... we don't serve $item</p>";
    }

    switch($item){
        case 'tacos':
            echo "<p>we serve tacos on Tuesdays</p>";
            break;
        case 'pizza':
            echo "<p>Pepperoni or veggie</p>";
            break;
        case 'bagels':
            $f3->reroute("/breakfast");
        default:
            $f3->error(404);
    }
});

//Define a route called order
$f3->route('GET /order', function (){
    $view = new Template();
    echo $view->render('views/form1.html');
});
//Define a route called order2
$f3->route('POST /order2', function (){
    //var_dump($_POST);
    $_SESSION['food'] = $_POST['food'];
    $view = new Template();
    echo $view->render('views/form2.html');
});
//Define a route called Summary
$f3->route('POST /summary', function (){
    var_dump($_POST);
    $_SESSION['meal'] = $_POST['meal'];
    var_dump($_SESSION);
    $view = new Template();
    echo $view->render('views/results.html');
});



//Run fat free
$f3->run();

