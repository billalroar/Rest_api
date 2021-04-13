<?php 
 
 $userstatus = array(); 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['requested']) and isset($_POST['requestedby']) and isset($_POST['date']))
    {
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASS', '');
            define('DB_NAME', 'zamzam');
            //connecting to database and getting the connection object
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //Checking if any error occured while connecting
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                die();
            }
            $stmt = $con->prepare("INSERT INTO `requesttb`(`requestBY`, `requested`, `date`) VALUES (?,?,?);");
 
            //executing the query 
            // $password = md5($_POST['password']);
            $stmt->bind_param("sss",$_POST['requestedby'],$_POST['requested'],$_POST['date']);
            if($stmt->execute()){
                    $userstatus['error'] = false; 
                    $userstatus['message'] = "Send request successfully";
            }else{
                    $userstatus['error'] = true; 
                    $userstatus['message'] = "Request not recive";
                
            }
 
    }else{
        $userstatus['error'] = true; 
        $userstatus['message'] = "Required fields are missing";
    }
}
else{
    $userstatus['error'] = true; 
    $userstatus['message'] = "Invalid Request";
}
 
echo json_encode($userstatus);