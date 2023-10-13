<?php
    session_start();

    
//[loggedin]=true;
    $host = 'localhost';
    $dbname = 'user_data';
    $dbusername = 'root';
    $dbapassword = '';
    $_SESSION['message']="don't have account??";
    $mail = "";
    
    function userExist($conn){
       $q = "select * from userdetail where Email = '".$_SERVER['$tempEmail']."';";
       $result = $conn->query($q);
       if ($result)
       {

        if($result->num_rows == 0){
            return false;
        }
        $eachData = $result->fetch_assoc();
        
        //echo $eachData["Password"];
        if(strcmp($_SERVER['$tempPassword'],$eachData["Password"]) != 0){
            return 2;
        }
        if ($result->num_rows > 0) {
            
            $_SESSION['First_name'] = $eachData["First_name"];
            $_SESSION["Image"] = $eachData["image"];
            $_SESSION['Last_name'] = $eachData['Last_name'];
            $_SESSION['Contact_number'] = $eachData['Contact_number'];
            $_SESSION['email'] = $eachData['Email'];
            $_SESSION['id'] = $eachData['Id'];
            $_SESSION['password'] = $eachData['Password'];
            return 1;
           } 
           else{
               //echo "User is not registered.";
               $_SESSION['message'] =  "<span style = 'color : red'>User is not registered.</span>";
               return 0;
           }
       }
       else {
           die("Server ERROR");
           return false;
       }   
    }
    if(isset($_POST['login']))
    {
        function login($conn){
            $_SERVER['$tempEmail'] = trim($_POST["Email"]);
            $mail = 
            $_SERVER['$tempPassword'] = trim($_POST["password"]);
            if(empty($_SERVER['$tempEmail']) and empty($_SERVER['$tempPassword'])){

                $_SESSION['message'] = "<span style = 'color : red'>Enter valid data</span>";
                echo "Valid data";
                return ;
            }

            $userRet = userExist($conn);
            if($userRet == 1){    // 1 :- user exist. 0 : not present 2: password not match
                echo "Running";
                header('location:Home.php');
            }
            else if($userRet == 2){
                $_SESSION['message'] = "<span style = 'color : red'>Password not match</span>";
            }
            else{
                $_SESSION['message'] = "<span style = 'color : red'>User doesn't exist</span>";
                
            }
            
        }
        try{
            $conn = new mysqli($host, $dbusername, $dbapassword, $dbname);
            login($conn);
            //echo "Connection established<br>";
           }
        catch(Exception $e){
            die("Connection failed <br>".$e->getMessage());
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


</head>

<body class="vh-100">

    <div class=" col-sm-6 container d-flex justify-content-center align-items-center">
        <div class=" p-4  signup_center_absolute signup_bg rounded">
            <h4><u>Login</u></h4>
            <form action="" class="p-3 rounded" method="POST">
                <div class=" row">
                    
                    <div class="col-md-12">
                    <div class="mb-3">
                            <label for="Email" class="form-label">Email Address
                            </label>
                            <input type="email" name="Email" class="form-control" id="Email"
                                aria-describedby="emailHelp" value="<?php if(isset($_POST['Email'])) echo $_POST['Email']?>" required minlength="2">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password
                            </label>
                            <input type="password" name="password" class="form-control" id="password"
                                aria-describedby="emailHelp" required minlength="2">
                        </div>
                        
                    </div>
                </div>

                <button type="submit" name="login" class="btn btn-primary d-grid gap-2 col-12 mx-auto">Login</button>
            </form>
            <div class="message_box">
                <?php echo "<br><p class = 'text-center mx-auto'><a class ='anchor_message' href='signUp.php' alt='Got to login'> Register </a>".$_SESSION['message']?? null ."</p>"   ?>
            </div>

        </div>
    </div>
</body>