<?php

 include_once($_SERVER['DOCUMENT_ROOT']."/admin/Model/BooksModel.php");
 
class BooksController 
{  

 private $modelbooks=NULL;
 
 public function __construct()    
     {  
          $this->modelbooks = new BooksModel();
		 
     } 
	 
	 
	   public function setModelbooks($modelbooks)
	 {
		 $this->modelbooks=$modelbooks;
	 }	 
      
	 public function getModelbooks()
	 {
		 return $this->modelbooks;
	 }
	 
/**
This function get All books from Model (table books) by User, then put all in array
*/	
    public function getBookListByUserIdfromModel($u_id)  
    {  
	  $booksByUser=array();
	  $booksByUser = $this->modelbooks->getBookListByUserId($u_id);
	  return $booksByUser;
	}	
	
/*this function take all books sorted by userLogin*/	
	 public function getFullBookListfromModel()  
    {  
	  $booksByUser=array();
	  $booksByUser = $this->modelbooks->getFullBookList("u_login");
	  return $booksByUser;
	}
/*this function take all books sorted by Category Name*/	
	 public function getFullBookListfromModelOrderedByCategory()  
    {  
	  $booksByUser=array();
	  $booksByUser = $this->modelbooks->getFullBookList("cb_name");
	  return $booksByUser;
	}
	
/*this function take all books selected category sorted by BookName*/	
	 public function getFullBookListfromModelByCategory($cb_name)  
    {  
	  $booksByUser=array();
	  $booksByUser = $this->modelbooks->getFullBookListByCategory($cb_name);
	  return $booksByUser;
	}
	
	
/*
	this function call to BooksModel and Invoke similiar function, put data to array 
	*/ 
    public function getBookByIdFromModel($b_id)  
    {  
	  $book=array();
	  $book = $this->modelbooks->getBookById($b_id);
	  return $book;
	}	
	
	
      

/*
this function Upload book

*/	  
	  
	public function uploadBook($_FILES, $u_id, $u_login,  $b_description, $b_year, $b_name, $cb_id, $b_img1 )
	{
		
		 if ($_FILES["bookfile"]["error"] > 0)
    {
        echo "Return Code: " . $_FILES["bookfile"]["error"] . "<br />";
    }
    else
    {
        echo "Upload: " . $_FILES["bookfile"]["name"] . "<br />";
        echo "Type: " . $_FILES["bookfile"]["type"] . "<br />";
        echo "Size: " . ($_FILES["bookfile"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["bookfile"]["tmp_name"] . "<br />";

        if (file_exists("upload/" . $_FILES["bookfile"]["name"]))
        {
            echo $_FILES["bookfile"]["name"] . " already exists. ";
        }
        else // file is not exist
        {
			$bookUploadPath=$_SERVER['DOCUMENT_ROOT'] .  '/AllUsersBooks/'.$u_login.'/';
			$imageUploadPath=$_SERVER['DOCUMENT_ROOT'] .  '/AllUsersBooks/'.$u_login.'/images/';
			
			//$url =               $GLOBAL_HOST.'/AllUsersBooks/'.$u_login.'/' ;			
			//$url = $_SERVER['DOCUMENT_ROOT'].'/AllUsersBooks/'.$u_login.'/' ; //!!! very important parameter
			
			$url = $GLOBAL_HOST.'/AllUsersBooks/'.$u_login.'/' ; //!!! very important parameter
			
			
			
			 $book_file =  pathinfo($_FILES["bookfile"]["name"]); //real file name
             $image_file = pathinfo($_FILES["img1File"]["name"]); //real image name
								
             
			
			$book_file_name = $this->makeFileNameFromBookNameInput($b_name);
			 
			$bookFileName_withExtension = $book_file_name.".".$book_file['extension'] ; // create bookfilename with Extension
				
			$imageFileName_withExtension =$book_file_name.".".$image_file['extension'] ; // create image file-name with Extension
			   
			
			if (  $this->folder_exist($bookUploadPath)    ) 
			{
			   /*	
				move_uploaded_file($_FILES["bookfile"]["tmp_name"],  $bookUploadPath. $_FILES["bookfile"]["name"]);
				move_uploaded_file($_FILES["img1File"]["tmp_name"],  $imageUploadPath. $book_file['filename'].".".$image_file['extension']); //image upload               			
				*/
				
				move_uploaded_file($_FILES["bookfile"]["tmp_name"],  $bookUploadPath. $bookFileName_withExtension);
				move_uploaded_file($_FILES["img1File"]["tmp_name"],  $imageUploadPath.$book_file_name.".".$image_file['extension']); //image upload               			
				
				
				//Insert Data to Database
				$this->modelbooks->insertBookData($u_id, $url, $b_description, $b_year, $b_name, $bookFileName_withExtension,$cb_id, $imageFileName_withExtension);
							
				
			}
			else // if folder with user name in ALLUserBooks doesnt exist - we create this folder, than upload file and insert data to DB
			{
				mkdir($bookUploadPath);
				mkdir($imageUploadPath);
			
			/*
				move_uploaded_file($_FILES["bookfile"]["tmp_name"],  $bookUploadPath. $_FILES["bookfile"]["name"]);
				move_uploaded_file($_FILES["img1File"]["tmp_name"],  $imageUploadPath. $book_file['filename'].".".$image_file['extension']);   //image upload           
				*/
				move_uploaded_file($_FILES["bookfile"]["tmp_name"],  $bookUploadPath. $bookFileName_withExtension);
				move_uploaded_file($_FILES["img1File"]["tmp_name"],  $imageUploadPath.$book_file_name.".".$image_file['extension']); //image upload               			
				
				
				//Insert Data to Database
					
				$this->modelbooks->insertBookData($u_id, $url, $b_description, $b_year, $b_name, $bookFileName_withExtension , $cb_id, $imageFileName_withExtension);
					
				
				
			}
			
           
        } // else file not exist
     }
	} // uploadBook	
	  
	  
/*
Update Book  by ADMINISTRATOR
*/
    public function updateBookByAdmin($b_id, $b_name,  $b_description, $b_year, $b_url,  $b_filename,  $cb_id)
	{ // TODO   Update REAL filename 
		 $this->modelbooks->updateBookByAdmin($b_id, $b_name,  $b_description, $b_year, $b_url,  $b_filename,  $cb_id)  ;	
	}	  
/*
Update Book  by User
*/
    public function updateBookByUser($b_id, $b_name,  $b_description, $b_year, $b_url,  $b_filename,  $cb_id)
	{ // TODO   Update REAL filename 
		 $this->modelbooks->updateBookByUser($b_id, $b_name,  $b_description, $b_year, $b_url,  $b_filename,  $cb_id)  ;	
	}		  
	  
	/*
Delete Book data by ADMINISTRATOR
*/
    public function deleteBookByAdmin($b_id)
	{
		 $this->modelbooks->deleteBookByAdmin($b_id)  ;
		 
		/*
	 $current_book = $this->modelbooks->getBookById($b_id);	        
     unlink($GLOBAL_ROOT.$current_book[0]["b_url"].$current_book[0]["b_filename"])	;
	  */ 
     
	
	}	  
	  
/*
Delete Book data by User
*/
    public function deleteBookByUser($b_id)
	{
		 $this->modelbooks->deleteBookByUser($b_id)  ;
    
	}  
	  
/*	  
function check of existing $folder , if not exist  - create this folder
	*/  
  function folder_exist($folder)
   {
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    if($path !== false AND is_dir($path))
    {
        // Return canonicalized absolute pathname
        return $path;
    }

    // Path/folder does not exist
    return false;
  }  


// This function Make book Name file from User Input Book name (first input field)  
function makeFileNameFromBookNameInput($str)
{
 
  $data = explode(" ",$str);
				    	
  $new_filename = "";
  for ($i=0;$i<count($data);$i++)
  {
	$new_filename.=$data[$i]."_";
  }	 
    $book_filename = substr($new_filename, 0,strlen($new_filename)-1); // remove last "-"
    $book_filename = str_replace(".","",$book_filename);   // check end remove .
 
 return $book_filename  ; 
}  
  
  
  
  
	  
  /* this function make redirect to another page*/	  
   public function redirect($location)
   {
	echo "redirect from BookController<br>";
     header('Location: '.$location);	
   }
   
   
   
   
   
   public function test($files)
   {
	   print_r($files);
   }
   
   
   
   
   
      
} // class BooksController


/**********************OUT of Controller input, but use Controller method*********************************/

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //something posted

    if (isset($_POST['submUploader'])) 
	{
       
		session_start();
		$_SESSION["reportUpload"] ="<font color='red'>Upload was successfully</font><br><br>";
		
		
		
		$bookcontroller = new BooksController ();
				
	    $bookcontroller->uploadBook($_FILES,$_SESSION["u_id"], $_SESSION["login"], $_REQUEST['b_description'], 
  	                                $_REQUEST['b_year'], $_REQUEST['b_name'], $_REQUEST['category'] );
		
		
		$bookcontroller->redirect("../bookUploader.php");
		
    } 
	else 
	  {
        //assume btnSubmit
      }
	  
	  /*Update Book by Admin*/
 if (isset($_POST['submBookUpdateByAdmin'])) 
	{
        // btnDelete
		
		session_start();
		$_SESSION["reportBookUpdateByAdmin"] ="<font color='red'>Update was successfully</font><br><br>";
		
		
		
		$bookcontroller = new BooksController ();
				
	    $bookcontroller->updateBookByAdmin($_REQUEST['b_id'], $_REQUEST['b_name'],  $_REQUEST['b_description'], 
		                                   $_REQUEST['b_year'], $_REQUEST['b_url'],  $_REQUEST['b_filename'],  $_REQUEST['cb_id']);		
		$bookcontroller->redirect("../backendSAUpdateBook.php?b_id=".$_REQUEST['b_id']."&action=".$_REQUEST['action']);
		
    } 
	else 
	  {
        //assume btnSubmit
      }	 

	  /*Update Book by Admin*/
 if (isset($_POST['submBookUpdateByUser'])) 
	{
        
		
		session_start();
		$_SESSION["reportBookUpdateByUser"] ="<font color='red'>Update was successfully by User</font><br><br>";
		
		
		
		$bookcontroller = new BooksController();
				
	    $bookcontroller->updateBookByUser($_REQUEST['b_id'], $_REQUEST['b_name'],  $_REQUEST['b_description'], 
		                                   $_REQUEST['b_year'], $_REQUEST['b_url'],  $_REQUEST['b_filename'],  $_REQUEST['cb_id']);		
		$bookcontroller->redirect("../backendUpdateBook.php?b_id=".$_REQUEST['b_id']."&action=".$_REQUEST['action']);
		
    } 
	else 
	  {
        //assume btnSubmit
      }	
	  
	  
	  
} // POST



if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{  
/*=======================================delete book by Admin=============================================== */
     if (isset($_REQUEST['b_id'])&&($_REQUEST['action']=='deleteBookByAdmin') ) //Update User from Admin
	{
        // Array ( [category_id] => 1 [action] => deleteCategory ) 
		
		session_start();
		
		$bookcontroller  = new BooksController();
		$bookcontroller->deleteBookByAdmin($_REQUEST['b_id']);		
		
		$bookcontroller->redirect("../backendSuperAdmin.php");
		
    } 
	else 
	  {
        //assume btnSubmit
      }
/*=======================================delete book by user=============================================== */
    if (isset($_REQUEST['b_id'])&&($_REQUEST['action']=='deleteBookByUser') ) //Update User from Admin
	{
        
		
		session_start();
		
		$bookcontroller  = new BooksController();
		$bookcontroller->deleteBookByUser($_REQUEST['b_id']);		
		
		$bookcontroller->redirect("../backend.php");
		
    } 
	else 
	  {
        //assume btnSubmit
      }
	  
	  
	  
	  
	  

} // GET




?>