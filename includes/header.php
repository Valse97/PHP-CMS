<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 24/06/2017
 * Time: 12:14
 */

include("app/database.php");
include("app/class/Cms.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/sweetalert.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="./assets/js/jquery-ui.min.js"></script>
  <script src="./assets/js/jquery.validate.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="./assets/js/sweetalert.min.js"></script>
<?php
    if(isset($gestione) && $gestione == true){
    echo '<link href="./assets/css/gestioni.css" rel="stylesheet">';
    }
    ?>
    <?php
    if(isset($gestione) && $gestione == true){
        echo '<script src="./assets/js/gestioni.js"></script>';

        if(isset($gestione_god) && $gestione_god == true){
            echo '<script src="./assets/js/gestioni-god.js"></script>';
        }
    }
    ?>

    <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
    margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}

    /* Set gray background color and 100% height */
    .sidenav {
    padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
    background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
    .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Contact</a></li>
          <?php
            $isGod = true;
            $isAdmin = true;

          if($isAdmin || $isGod){

              echo "<li class=\"dropdown\">
                            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"javascript:void(0)\">Page 1
                            <span class=\"caret\"></span></a>
                            <ul class=\"dropdown-menu\">";
              $components = Cms::getAllComponents();

              foreach($components as $component){
                  echo "<li><a href=\"#\">Gestione ".ucfirst($component->plural_name)."</a></li>";
              }

              echo "</ul>
                    </li>";
          }

          if($isGod){
                ?>
              <li><a href="menu-god.php">GOD Menu</a></li>
          <?php
          }
          ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-1 sidenav">
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
        <div class="col-sm-10 text-left">