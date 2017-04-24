<?php
 session_start();
 include_once $_SERVER['DOCUMENT_ROOT']."/admin/Controller/BooksController.php";
 include_once $_SERVER['DOCUMENT_ROOT']."/admin/Controller/UsersController.php";
 include_once $_SERVER['DOCUMENT_ROOT']."/admin/Controller/CategoryController.php";
  //include_once $_SERVER['DOCUMENT_ROOT']."/admin/Model/BooksModel.php";
 
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>NLibary Science Work Repositorium</title>
 <script type="text/javascript" src="js/deleteConfirmation.js"></script>
  <script type="text/javascript" src="js/updateConfirmation.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <script type="text/javascript" src="js/showmore.js"></script>
   
</head>
<LINK href="css/styleBackend.css" type=text/css rel=stylesheet />
<body>

<?php 
  if (!isset($_SESSION["login"])) 
  { echo "You didn't login, please quit from this page!<br>";
     echo "<a href='../index.php'>Login </a>" ;
  
  }
  else //logined
  {
	 
  //-->
     if ($_SESSION["login"]!='admin')
	  {
		echo "User cannot stay on this page, please quit from this page!<br>";
        echo "<a href='../index.php'>Login </a>" ;  
	  }
	 
  //-->
    else {
  
  ?>
  



<div id="maketo">
<?php
include_once('admin_menu.php');
?>
<div id="content1">

  <div align="center"> Hello, Super<?php  echo  "<b>".$_SESSION["login"]."</b>" ;?> </div>
  <br>
  
<h2 align="center">Statistics of the site</h2>  

<div align='center'>
<?php
$bookcontroller = new BooksController(); 
$books=0;
$books = $bookcontroller->getCountBookFromModel();

$booksByCategory=0;

$usercontroller = new UsersController(); 
$users=0;
$users = $usercontroller->getCountBookFromModel();

$categorycontroller = new CategoryController(); 
$category=array();
$category = $categorycontroller->getAllCategoriesfromModel();

echo "<b>Total books uploaded:</b> ".$books."<br>";
echo "<b>Total users on the site:</b> ".$users."<br>";


for($i=0;$i<count($category);$i++)
{  
   $booksByCategory = $bookcontroller->getCountBookByCategoryFromModel($category[$i]['cb_id']);
	echo "<b>Total books on <font color='blue'>".$category[$i]['cb_name']."</font> category uploaded:</b> ".$booksByCategory."  <br>";
	//getCountBookByCategoryFromModel($category[$i]['cb_id'])
}

 ?>
 </div>
 
 
 
</div>
<div id="rasporka"></div> 
<div id="footer" align="center">Designed for NLibrary @2017</div>
</div>  <!-- Maketo -->

<?php
  
   } //end of else if ($_SESSION["login"]!='admin')
   
  } // end of else if (!isset($_SESSION["login"]))
  
  ?>
  
</body>
</html>




<?php



?>

