<?php  

if(isset($_GET['id'])){
   include "connect.php";
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}

	$id = validate($_GET['id']);

	$sql = "DELETE FROM cart
	        WHERE id=$id";
   $result = mysqli_query($conn, $sql);
   if ($result) {
   	  header("Location: ../cart.php?success=successfully deleted");
   }else {
      header("Location: ../cart.php?error=unknown error occurred&$user_data");
   }

}else {
	header("Location: ../cart.php");
}