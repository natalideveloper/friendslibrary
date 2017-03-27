<?php
 include_once $_SERVER['DOCUMENT_ROOT']."/admin/Controller/BooksController.php";
 ?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Nataliya Library</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">

   <?php 
 /***************  This code include header *****************************/
       include 'header.php';        
   ?>
  
  
  
    <div id="site_content">
	
	
	 <?php 
 /***************  This code include sidebar *****************************/
       include 'sidebar.php';        
   ?>	
	
	
  
      <div class="content">
	   <br>
	  
       <h3> Error 404</h3>
	  <?php 
	  if (isset($_REQUEST["error_code"]))
	    echo "Error code: ".   $_REQUEST["error_code"];   
?>
	   </div> <!--//content //-->
    </div>  <!--// site_content //-->
<?php 
 /***************  This code include footer *****************************/
       include 'footer.php';        
?>