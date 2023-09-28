<?php
// if(!isset($_SESSION)){
//     header('Location:login.php');
// }


session_start();

//print_r($_SESSION);

if(!isset($_SESSION['id'])){
    header('Location:login.php');
}

$_SESSION['message'] = '';
$host = 'localhost';
$dbname = 'user_data';
$dbusername = 'root';
$dbapassword = '';

function runQuery($q, $email, $conn, $firstname, $lastname, $password, $contact)
{
    $check = "SELECT * FROM userdetail WHERE Email = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['message'] = 'Already Exist';
        return;
    }

    $stmt = $conn->prepare($q);
    $stmt->bind_param('ssssss', $firstname, $lastname, $contact, $password, $email, $email);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Update Successfully';
        $_SESSION['First_name'] = $firstname;
        $_SESSION['Last_name'] = $lastname;
        $_SESSION['Contact_number'] = $contact;
        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['message'] = 'Server ERROR';
    }
}

if (isset($_POST['log_out'])) {
    session_destroy();
    header('Location: signup.php'); // Use Location instead of exit to redirect
    die();
}

if (isset($_POST['Update'])) {
    try {
        $conn = new mysqli($host, $dbusername, $dbapassword, $dbname);
    } catch (Exception $e) {
        die("Connection failed <br>" . $e->getMessage());
    }

    $firstname = trim($_POST['First_name']);
    $lastname = trim($_POST['Last_name']);
    $email = trim($_POST['Email']);
    $password = trim($_POST['password']);
    $contact = trim($_POST['contact_no']);
    if (isset($_FILES['image'])) {
        $filename = $_FILES['image']['name'];
        $filesize = $_FILES['image']['size'];
        $filetmp = $_FILES['image']['tmp_name'];
        $filetype = $_FILES['image']['type'];

        if (!empty($filename)) {
            unlink($_SESSION['Image']);
            $image = "images/" . $email . $filename;
            move_uploaded_file($filetmp, "images/" . $email . $filename);
            $q = "UPDATE userdetail SET image = ? WHERE Email = ?";
            $stmt = $conn->prepare($q);
            $stmt->bind_param('ss', $image, $email);
            $_SESSION["Image"] = $image;
            if ($stmt->execute()) {
                $_SESSION['image'] = $image;
            } else {
                $_SESSION['message'] = 'Error in upload image';
            }
        }
    }

    if (strcmp($email, $_SESSION['email']) == 0) {
        $q = "UPDATE userdetail SET First_name = ?, Last_name = ?, Contact_number = ?, Password = ? WHERE Email = ?";
        
        $stmt = $conn->prepare($q);
        $stmt->bind_param('sssss', $firstname, $lastname, $contact, $password, $email);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Update Successfully';
            $_SESSION['First_name'] = $firstname;
            $_SESSION['Last_name'] = $lastname;
            $_SESSION['Contact_number'] = $contact;
            $_SESSION['password'] = $password;
            $_SESSION['email'] = $email;
        } else {
            $_SESSION['message'] = 'Server ERROR';
        }
    } else {
        $q = "UPDATE userdetail SET First_name = ?, Last_name = ?, Contact_number = ?, Password = ?, Email = ? WHERE Email = ?";
        runQuery($q, $email, $conn, $firstname, $lastname, $password, $contact);
    }

    mysqli_close($conn);
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

<script src="validation.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="">PHP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="Home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Update.php">Update</a>
        </li>
        <li>
        <form  method = "POST" class ='m-0'>
        <button type="submit" name="log_out" class="btn d-grid col-12 mx-auto">exit</button>
        <form>
        </li>
      </ul>
    </div>
  </div>
</nav>        
<h3 class="text-center"> Update detail </h3>

<div class=" col-sm-6 container d-flex justify-content-center align-items-center">
        <div class=" p-4  signup_center_absolute signup_bg rounded">
            <form action="" class="p-3 rounded" method="POST" enctype="multipart/form-data">
                <div class=" row">

                <div class="d-flex">
                    <img class = "img-fluid w-25 mx-auto rounded mb-4" src="<?php echo $_SESSION["Image"]; ?>" alt="" />
                </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="First_name" class="form-label">First Name</label>
                            <input type="text" name="First_name" class=" form-control" id="First_name"
                                aria-describedby="emailHelp" required minlength="2" value = "<?php echo $_SESSION['First_name'] ?> ">
                                <h6 id = "fname_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="Last_name" class="form-label">Last Name</label>
                            <input type="text" name="Last_name" class="form-control" id="Last_name"
                                aria-describedby="emailHelp" required minlength="2" value = "<?php if(isset($_SESSION['Last_name'])) echo $_SESSION['Last_name'] ?>">
                                <h6 id = "lname_err"></h6>

                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email Address
                            </label>
                            <input type="email" name="Email" class="form-control" id="Email"
                                aria-describedby="emailHelp" required minlength="2" value = "<?php echo $_SESSION['email'] ?> ">
                                <h6 id = "mail"></h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact Number</label>
                            <input type="tel" name="contact_no" class="form-control" id="contact_no"
                                aria-describedby="emailHelp" required minlength="2" value = "<?php echo $_SESSION['Contact_number'] ?> ">
                                <h6 id = "ph_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password
                            </label>
                            <input type="TEXT" name="password" class="form-control" id="password"
                                aria-describedby="emailHelp" required minlength="2" value = "<?php echo $_SESSION['password'] ?> ">
                                <h6 id = "pass_err"></h6>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" multiple accept=".png, .jpg" id="image"
                                aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>

                <button type="submit" name="Update" id = "update" class="btn btn-primary d-grid gap-2 col-12 mx-auto">Update</button>
            </form>
            <div class="message_box">
                <?php echo "<br><p class = 'text-center mx-auto'>".$_SESSION['message'] ."</p>"   ?>
            </div>
        </div>
    </div>
</body>

<script>
$(document).ready(function(){
    $('#fname_err').hide();
    $('#lname_err').hide();
    $('#ph_err').hide();
    $('#pass_err').hide();

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
            $('#ph_err').html("invalid mobile");
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

$('#update').click(function(){

     fn_err=true;
     ln_err=true;
     ph_err=true;
     p_err=true;
     cp_err=true;

     fnamechk();
     lnamechk();
     phonechk();
     passchk();
    if((fn_err==true && ln_err==true && ph_err==true  && p_err==true  )){
        return true;
    }
    else{
        return false;
    }
});
});

 

 

 
</script>


</html>