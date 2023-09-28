<?php 
        
        function checkEmpty($fn, $ln, $email, $pwd, $cmfpwd, $cont, $image) {
            if (!empty($fn) and !empty($ln) and !empty($email) and !empty($pwd) and !empty($cmfpwd) and !empty($cont) and !empty($image)) {
                echo "First Name: " . "a".$fn."A" . "<br>";
                echo "Last Name: " . $ln . "<br>";
                echo "Email: " . $email . "<br>";
                echo "Password: " . $pwd . "<br>";
                echo "Confirm Password: " . $cmfpwd . "<br>";
                echo "Contact Number: " . $cont . "<br>";
                echo "Image: " . $image;
                return true;
            } else {
                echo "One input field is Missing"."<br>";
                return false;
            }
        }
        
    function filter_var()
    {
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $firstname =  trim($_POST["First_name"]);
            $lastname =  trim($_POST["Last_name"]);
            $email =  trim($_POST["Email"]);
            $password =  trim($_POST["password"]);
            $confpassword =  trim($_POST["confirm_password"]);
            $contact =  $_POST["contact_no"];
            $image =  $_POST["image"];
        
            if(checkEmpty($firstname,$lastname,$email,$password,$confpassword,$contact,$image) == false){
                echo "Invalid field test"."<br>";
            
            }
            if($password != $confpassword){
                echo "Password is not matching <br>";
            }
            else{
                echo "Enter successfully"."<br>";
                require_once 'dba.inc.php';
                check_user($email);
            }
        
        }
        else{
            echo "can't able to run"."<br>";
        }
}
?>