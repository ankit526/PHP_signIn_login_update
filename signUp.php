<?php
    session_start();
    $_SESSION['message']="If you have account??";
    
    function checkEmpty($fn, $ln, $email, $pwd, $cmfpwd, $cont, $image) {
        if (!empty($fn) and !empty($ln) and !empty($email) and !empty($pwd) and !empty($cmfpwd) and !empty($cont) and !empty($image)) {/*
            echo "First Name: " . "a".$fn."A" . "<br>";
            echo "Last Name: " . $ln . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Password: " . $pwd . "<br>";
            echo "Confirm Password: " . $cmfpwd . "<br>";
            echo "Contact Number: " . $cont . "<br>";
            echo "Image: " . $image;*/
            //print_r($_FILES[$image]);
            return true;
        } else {
            $_SESSION['message']=  "<span style = 'color : red'>One input field is Missing </span>"."<br>";
            
            return false;
        }
    }
    
    if(isset($_POST['submit']))
    {
        $firstname =  trim($_POST["First_name"]);
        $lastname =  trim($_POST["Last_name"]);
        $email =  trim($_POST["Email"]);
        $password =  trim($_POST["password"]);
        $confpassword =  trim($_POST["confirm_password"]);
        $contact =  trim($_POST["contact_no"]);
        $image = $_FILES['profile']['name'];

        if(isset($_FILES['profile'])){

            $filename=$_FILES['profile']['name'];
      
            $filesize=$_FILES['profile']['size'];
      
            $filetmp=$_FILES['profile']['tmp_name'];
      
            $filetype=$_FILES['profile']['type'];
      
            $image = "images/".$email.$filename;
            move_uploaded_file($filetmp,"images/".$email.$filename);
      
         }
        else{
            echo "Not found";
            die();
        }
            
            if(checkEmpty($firstname,$lastname,$email,$password,$confpassword,$contact,$image)== false){
                $_SESSION['message']= "<span style = 'color : red'>Invalid Input</span>";
            }
            
            if($password != $confpassword){
                $_SESSION['message']= "<span style = 'color : red'>Password is not matching</span> ";
            }
            else if(empty($messsage)){
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['confpassword'] = $confpassword;
                $_SESSION['contact'] = $contact;
                $_SESSION['image'] = $image;
                require_once ("includes/dba.inc.php");
            }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


<script src="validation.js"></script>

</head>

<body class="vh-100">

    <div class=" col-sm-6 container d-flex justify-content-center align-items-center">
        <div class=" p-4  signup_center_absolute signup_bg rounded">
        <h4 class="ps-3"><u>Register</u></h4>
            <form action=""  class="p-3 rounded" method="POST" enctype="multipart/form-data">
                <div class=" row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="First_name" class="form-label">First Name</label>
                            <input type="text" name="First_name" class=" form-control" id="First_name"
                                aria-describedby="emailHelp" required minlength="1" value="<?php if(isset($_POST['First_name'])) echo $_POST['First_name']?>">
                                <h6 id = "fname_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="Last_name" class="form-label">Last Name</label>
                            <input type="text" name="Last_name" class="form-control" id="Last_name"
                                aria-describedby="emailHelp" required minlength="2" value="<?php if(isset($_POST['Last_name'])) echo $_POST['Last_name']?>">
                                <h6 id = "lname_err"></h6>

                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email Address
                            </label>
                            <input type="email" name="Email" class="form-control" id="Email"
                                aria-describedby="emailHelp" required minlength="2" value="<?php if(isset($_POST['Email'])) echo $_POST['Email']?>">
                                <h6 id = "mail"></h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact Number</label>
                            <input type="text"  name="contact_no" class="form-control" id="contact_no"
                                aria-describedby="emailHelp" required minlength="2" value="<?php if(isset($_POST['contact_no'])) echo $_POST['contact_no']?>">
                                <h6 id = "ph_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password
                            </label>
                            <input type="password" name="password" class="form-control" id="password"
                                aria-describedby="emailHelp" required minlength="2" >
                                <h6 id = "pass_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required minlength="2">
                                <h6 id = "cpass_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type = "file" name="profile" class="form-control" multiple accept=".png, .jpg" id="image">
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" id = "submit" class="btn btn-primary d-grid gap-2 col-12 mx-auto">Submit</button>
            </form>
            <div class="message_box">
                <?php echo "<br><p class = 'text-center mx-auto'><a class ='anchor_message' href='login.php' alt='Got to login'> Login </a>".$_SESSION['message']?? null ."</p>"?>
            </div>

        </div>
    </div>
    <script src="includes/validation.js"></script>


    
<script>
$(document).ready(function(){
    $('#fname_err').hide();
    $('#lname_err').hide();
    $('#ph_err').hide();
    $('#pass_err').hide();
    $('#cpass_err').hide();

    let fn_err=true;
    let ln_err=true;
    let ph_err=true;
    let bi_err=true;
    let p_err=true;
    let cp_err=true;
    $('#First_name').keyup(function(){
        fnamechk();
    });
    $('#Last_name').keyup(function(){
        lnamechk()
    });

    $('#contact_no').keyup(function(){
        phonechk()
    });
    
    $('#password').keyup(function(){
        passchk()
    });

    $('#confirm_password').keyup(function(){    
        cpasschk()    
    });
    
    function fnamechk(){
        var uname=$('#First_name').val();
        if(uname.length=='' || uname.length<2){
        $('#fname_err').show();
        $('#fname_err').html("please enter at least 2 characters");
        $('#fname_err').focus();
        $('#fname_err').css("color","red");
        fn_err=false;
    }
    else{
        $('#fname_err').hide();
    }
    }

 
    function lnamechk(){
        var uname=$('#Last_name').val();
        if(uname.length=='' || uname.length<2){
            $('#lname_err').show();
            $('#lname_err').html("please enter at least 2 characters");
            $('#lname_err').focus();
            $('#lname_err').css("color","red");
            ln_err=false;
        }else{
            $('#lname_err').hide();
        }
    }
    function phonechk(){
        var pho=$('#contact_no').val();
        if(pho.length=='' || pho.length!=10){
            $('#ph_err').show();
            $('#ph_err').html("invailid mobile");
            $('#ph_err').focus();
            $('#ph_err').css("color","red");
            ph_err=false;
        }else{
            $('#ph_err').hide();
        }
    }

    function passchk(){
        var pchk=$('#password').val();
        var sp=/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;
        var cap=/[A-Z]/;
        if(pchk.length<8 || !sp.test(pchk) || !cap.test(pchk)){
            $('#pass_err').show();
            $('#pass_err').html("please enter at least 8 characters with 1 special and 1 capital letter");
            $('#pass_err').focus();
            $('#pass_err').css("color","red");
            p_err=false;
        }else{
            $('#pass_err').hide();
        }
    }
    function cpasschk(){
        var cpchk=$('#confirm_password').val();
        var pchk=$('#password').val();
        if(cpchk!=pchk){
            $('#cpass_err').show();
            $('#cpass_err').html("pass do not match");
            $('#cpass_err').focus();
            $('#cpass_err').css("color","red");
            cp_err=false;
    }
    else{
        $('#cpass_err').hide();
    }
}

$('#submit').click(function(){

     fn_err=true;
     ln_err=true;
     ph_err=true;
     p_err=true;
     cp_err=true;

     fnamechk();
     lnamechk();
     phonechk();
     passchk();
     cpasschk();
    if((fn_err==true && ln_err==true && ph_err==true  && p_err==true && cp_err==true)){
        return true;
    }
    else{
        return false;
    }
});
});

 

 

 
</script>



    
</body>
</html>