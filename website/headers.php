<?php
 
session_start();

echo'<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  
  <title>Gestion dune bibliothèque en ligne</title>

  <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet" type="text/css">
  <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">

  
  <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
  <link rel="stylesheet" href="assets/css/main.css">

  <style>

  body { background-color:#fafafa;}
  .content {
    text-align: center;
    margin-top:150px;
  }
  .content h1 {
    font-family: \'Sansita\', sans-serif;
    letter-spacing: 1px;
    font-size: 50px;
    color: #282828;
    margin-bottom: 10px;
  }
  .content  i {
    color: #FFC107;
  }
  .content span {
    position: relative;
    display: inline-block;
  }
  .content  span:before, .content  span:after {
    position: absolute;
    content: "";
    background-color: #282828;
    width: 40px;
    height: 2px;
    top: 40%;
  }
  .content  span:before {
    left: -45px;
  }
  .content  span:after {
    right: -45px;
  }
  .content p {
    font-family: \'Open Sans\', sans-serif;
    font-size: 18px;
    letter-spacing: 1px;
  }
  .wrapper {
    position: relative;
    display: inline-block;
    border: none;
    font-size: 14px;
    margin: 50px auto;
    left: 50%;
    transform: translateX(-50%);
  }

  .wrapper input {
    border: 0;
    width: 1px;
    height: 1px;
    overflow: hidden;
    position: absolute !important;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px, 1px, 1px, 1px);
    opacity: 0;
  }

  .wrapper label {
    position: relative;
    float: right;
    color: #C8C8C8;
  }

  .wrapper label:before {
    margin: 5px;
    content: "\f005";
    font-family: FontAwesome;
    display: inline-block;
    font-size: 1.5em;
    color: #ccc;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  .wrapper input:checked ~ label:before {
    color: #FFC107;
  }

  .wrapper label:hover ~ label:before {
    color: #ffdb70;
  }

  .wrapper label:hover:before {
    color: #FFC107;
  }

  thead th, tfoot th {
    font-family: \'Rock Salt\', cursive;
  }

  th {
    letter-spacing: 2px;
    text-align: center;
  }

  td {
    letter-spacing: 1px;
  }

  tbody td {
    text-align: center;
  }

  tfoot th {
    text-align: right;
  }

  table {
    table-layout: fixed;
    width: 100%;
    border-collapse: collapse;
    border: 3px solid white;
    background-color: #FFE4C4;
  }

  thead th:nth-child(1) {
    width: 30%;
  }

  thead th:nth-child(2) {
    width: 20%;
  }

  thead th:nth-child(3) {
    width: 15%;
  }

  thead th:nth-child(4) {
    width: 35%;
  }

  th, td {
    padding: 20px;  
  }

  thead, tfoot {
    color: white;
    text-shadow: 1px 1px 1px black;
  }

  thead th, tfoot th, tfoot td {
    background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
    border: 3px solid white;
  }

  tbody tr:nth-child(odd) {
    background-color: #FFE4C4;
  }

  tbody tr:nth-child(even) {
    background-color: white;
  }

  .custom-dropdown--large {
    font-size: 1.5em;
}

.custom-dropdown--small {
    font-size: .7em;
}

.custom-dropdown__select{
    font-size: inherit; 
    padding: .5em; 
    margin: 0; 
}

.custom-dropdown__select--white {
    background-color: #fff;
    color: #444;    
}

@supports (pointer-events: none) and
      ((-webkit-appearance: none) or
      (-moz-appearance: none) or
      (appearance: none)) {

    .custom-dropdown {
        position: relative;
        display: inline-block;
        vertical-align: middle;
    }

    .custom-dropdown__select {
        padding-right: 1.5em; 
        border: 5;
        border-radius: 3px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;    
    }

    .custom-dropdown::before,
    .custom-dropdown::after {
        content: "";
        position: absolute;
        pointer-events: none;
    }

    .custom-dropdown::after { 
        content: "\25BC";
        height: 1em;
        font-size: .625em;
        line-height: 1;
        right: 1.2em;
        top: 50%; margin-top: -.5em;
    }

    .custom-dropdown::before { 
        width: 2em;
        right: 0; top: 0; bottom: 0;
        border-radius: 0 3px 3px 0;
    }

    .custom-dropdown__select[disabled] {
        color: rgba(0,0,0,.3);
    }

    .custom-dropdown.custom-dropdown--disabled::after {
        color: rgba(0,0,0,.1);
    }

    
    .custom-dropdown--white::before {
        top: .5em; bottom: .5em;
        background-color: #fff;
        border-left: 1px solid rgba(0,0,0,.1);
    }

    .custom-dropdown--white::after {
        color: rgba(0,0,0,.9);
    }

    
    @-moz-document url-prefix() {
        .custom-dropdown__select              { padding-right: .9em }
        .custom-dropdown--large .custom-dropdown__select { padding-right: 1.3em }
        .custom-dropdown--small .custom-dropdown__select { padding-right: .5em }
    }

    .msg_emprunt {
      font-family: \'Rock Salt\', cursive;
      letter-spacing: 2px;
      text-align: center;
    }

    .msg_alert{

      color: red;
      text-decoration: bold;
      letter-spacing: 2px;
      text-align: center;

    }


</style>

  
</head>

<body class="home">
  <!-- Fixed navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
      <div class="navbar-collapse collapse">
        <img src="assets/images/logo/logo.png" alt="logo">
        <ul class="nav navbar-nav pull-right">
          
          ';

          //Le header change dépendamment du type de l'utilisateur: administrateur, ou autre. 
            if(isset($_SESSION['username'])){

              //On vérifie si l'username de l'utilisateur qu s'est connecté correspond à ce lui de l'administrateur "az100211"
              if($_SESSION['username'] == "az100211") {

                //Pages accessibles à l'administrateur
                echo '<li><a href="./main.php">Home</a></li>';
                echo '<li><a href="./about.php">About</a></li>';
                echo '<li><a href="./emprunter.php">Emprunter</a></li>';
                echo '<li><a href="./restituer.php">Réstituer</a></li>';
                echo '<li><a href="./livres.php">Livres</a></li>';
                echo '<li><a href="./services.php">Ajout/Suppression</a></li>';
                echo '<li><a href="./adherents.php">Membres</a></li>';
                echo '<li><a class="btn" href="./logout.php">Logout</a></li>';
                echo '<li><a class="btn" href="./signup.php">SIGN UP</a></li>';
                echo '</ul>';

              }

              else {

                //Pages accessibles à tout autre utilisateur
                echo '<li><a href="./main.php">Home</a></li>';
                echo '<li><a href="./about.php">About</a></li>';
                echo '<li><a href="./emprunter.php">Emprunter</a></li>';
                echo '<li><a href="./restituer.php">Réstituer</a></li>';
                echo '<li><a href="./livres.php">Livres</a></li>';
                echo '<li><a class="btn" href="./logout.php">Logout</a></li>';
                echo '<li><a class="btn" href="./signup.php">SIGN UP</a></li>';
                echo '</ul>';
              }
            }
            
          echo'</div>
    </div>
  </div> 
  
  <header id="head">
    <div class="container">
      <div class="row">

    </div>
  </header>';
?>