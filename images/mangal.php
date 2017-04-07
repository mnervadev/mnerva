<?php
       if(isset($_GET['id']) && $_GET['id'] != ''){
           $id = $_GET['id'];
           include_once '../functions/dbCon.php';
    		$sql2 = "DROP TABLE $id";
            $retval = mysqli_query( $db, $sql2 );
            if(! $retval )
            {
              die('Could not delete table: ' . mysqli_error());
            }
            echo "Table deleted successfully\n";
       }
	
?>