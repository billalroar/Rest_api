<?php 
 
 $userstatus = array(); 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['email']) and isset($_POST['password']))
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
            $stmt = $con->prepare("SELECT `id` FROM `admin` WHERE `email`= ? and `password` = ?;");
 
            //executing the query 
            // $password = md5($_POST['password']);
            $stmt->bind_param("ss",$_POST['email'],$_POST['password']);
            $stmt->execute();
            $stmt->store_result(); 
            if($stmt->num_rows > 0){
                $u = $stmt->bind_result($id);;
                while($stmt->fetch()){
                    $temp = array();
                    $temp['error'] = false; 
                    $temp['id'] = $id;
                    array_push($userstatus, $temp);
                }
                
            }
            else{
                $userstatus['error'] = true; 
                $userstatus['message'] = "Invalid User and Password";
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