<?php
    $host = 'localhost';
    $dbname = 'user_data';
    $dbusername = 'root';
    $dbapassword = '';
    

    function checkExist($conn){
        $checkUserQuery = "SELECT * FROM userdetail WHERE Email = '" . $_SESSION['email'] . "';";
        $result = $conn->query($checkUserQuery);
        //echo $checkUserQuery.'<br>';
        if ($result)
        {
            if ($result->num_rows > 0) {
                //echo "User is already registered.";
                $_SESSION['message'] =  "<span style = 'color : red'>User is already registered.";
                return false;
            } 
            else{
                //echo "User is not registered.";
                $_SESSION['message'] =  "<span style = 'color : red'>User is not registered.</span>";
                return true;
            }
        }
        else {
            die("Server ERROR");
            return false;
        }   
    }
    function registerUser($conn)
    {
        
        /*echo $_SESSION['firstname'] . $_SESSION['lastname'] . $_SESSION['email'] . $_SESSION['password'] . $_SESSION['confpassword'] . $_SESSION['contact'] . $_SESSION['image'].'<br>';

       */ 
        $sql = "INSERT INTO userdetail (First_name, Last_name, Contact_number, Password, Email, Image) VALUES ('" . $_SESSION['firstname'] . "', '" . $_SESSION['lastname'] . "', '" . $_SESSION['contact'] . "', '" . $_SESSION['password'] . "', '" . $_SESSION['email'] . "', '" . $_SESSION['image'] . "')";

        if($conn->query($sql) === true){
            //echo "Register Successfully!";
            $_SESSION['message'] = "<span style = 'color : green'>Register Successfully!</span>";
            session_destroy();
        }
        else{
            die("Error in upload data");
        }
    }
    
    try{
        $conn = new mysqli($host, $dbusername, $dbapassword, $dbname);
        
        //echo "Connection established<br>";
       }
    catch(Exception $e){
        die("Connection failed <br>".$e->getMessage());
    }
    if(checkExist($conn) === true){
        registerUser($conn);
    }
        