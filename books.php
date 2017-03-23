<?php
 include_once $_SERVER['DOCUMENT_ROOT']."/admin/Controller/BooksController.php";
  include_once $_SERVER['DOCUMENT_ROOT']."/admin/Model/BooksModel.php";
 
 ?>
<!DOCTYPE HTML>
<head>
  <title>Nataliya Library</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script type="text/javascript" src="js/showmore.js"></script>
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
        <h1>Welcome</h1>
		<hr>
		<br><br>
		<p>You selected books by category <b><?php echo $_REQUEST['cb_name'];?></b>, click bookName for Download</p>
		
		<table>
	
		<th  style=" width:5%;background-color:#4D8D01;">Type  </th>
		<th  style=" width:15%;background-color:#4D8D01;">Book Name  </th>
		<th  style=" width:35%;background-color:#4D8D01;">Description  </th>
		<th  style=" width:15%;background-color:#4D8D01;">Image  </th>
		<th  style=" width:5%;background-color:#4D8D01;">Year  </th>
		<th  style=" width:20%;background-color:#4D8D01;">Uploader/Author  </th>
<?php

$bookcontroller = new BooksController(); 
$books=array();
$books = $bookcontroller->getFullBookListfromModelByCategory($_REQUEST['cb_name']) ; 

 for ($i=0; $i<count($books); $i++)
 { 
   $book_file =  pathinfo($books[$i]["b_filename"]); //real file name			 
   $bookExtension = $book_file['extension'] ; // get book  Extension
   
   $image_with_PATH ="images/type/".returnBookTypeImage($bookExtension);
   
     echo "<tr>\n" ;
	// echo "<td>".$books[$i]["cb_name"]."</td>";
	 echo "<td><img src ='".$image_with_PATH."' width='32px' height='32px' ></td>\n";
     echo "<td><a href='".$books[$i]["b_url"].$books[$i]["b_filename"]."' download   >".$books[$i]["b_name"]."</a></td>\n";	 
     echo "<td>".addShowMoreForDescription($books[$i]["b_description"])."</td>\n";	
	 echo "<td><center><img src='".$books[$i]["b_url"]."images/".$books[$i]["b_img1"]."' width='50px' height='50px' ></center></td>\n";
	 echo "<td>".$books[$i]["b_year"]."</td>\n";
	 echo "<td>".$books[$i]["u_login"]."</td>\n";
	 
	  echo "</tr>\n" ;
 } // for


?>		
</table>		
		
	  
	  </div>  <!--// end content  //-->
    </div>  <!--// end site_content  //-->
	
	
<?php 
 /***************  This code include footer *****************************/
       include 'footer.php';        
?>


<?php

function Word10( $text )
{$newtext="";

    $data=  explode(" ", strip_tags($text) );
    $count_words=0;
    if (count($data)<10)  {$count_words=count($data);}
        else { $count_words=10;
             }
    for ($i=0;$i<$count_words;$i++)
    {
      $newtext.=$data[$i]." ";
    }
   // $newtext.="...";
   // $newtext=  str_replace("[/caption]", "", $newtext);

    
    $last_text=explode("[/caption]", $newtext);
    if (isset($last_text[1]) ) {$newtext=$last_text[1];} 
       else {$newtext=$last_text[0];}
    
    return $newtext;
}

function returnBookTypeImage($type="txt")
{  $image="";
	switch ($type) 
	{
    case "doc":
        $image="word.png";
        break;
    case "docx":
        $image="word.png";
        break;
    case "pdf":
        $image="pdf.png";
        break;
	case "txt":
        $image="txt.png";
        break;	
		
    default:
        echo "Your favorite color is neither red, blue, nor green!";
	}	
		
	return $image;	
	
}

/*This function add DIV tag and style to TEXT over 100 symbols */
function addShowMoreForDescription($str)
{
	if (strlen($str)>=50 )
	{  $str = "<div class='more'>".$str."</div>"  ;

          return $str;
     }
   else 
	   return $str;	
	
}

?>

