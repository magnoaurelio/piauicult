<?php session_start(); ?>
<html>
     <?php
        include 'inc/head.php';
        include 'app/config/Config.php';
     ?> 
   <body class="home">
         <?php include 'inc/logo.php' ?>
         <?php include 'inc/header.php' ?>
         <?php 
         //include 'inc/topo.php';
	  ?> 
         
          <?php
          try{
          $p = isset($_REQUEST['p'])?$_REQUEST['p']:'home';
           Router::setPage($p);
          } catch (Exception $ex){
              MErro($ex);
          }
           ?>
        
        <style>
          
        </style>
    </body>
     <?php
        include 'inc/footer.php';
     ?> 
</html>
