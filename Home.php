<?php
//    if(!isset($_SESSION)){
//     header('Location:login.php');
// }
 session_start();

 //print_r($_SESSION);
 
 if(!isset($_SESSION['id'])){
     header('Location:login.php');
 }
 if (isset($_POST['log_out'])) {
  session_destroy();
  header('Location: signup.php'); // Use Location instead of exit to redirect
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
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
          <a class="nav-link active" aria-current="page" href="">Home</a>
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
    
    <h2 class='text-center' >Hello <?php echo $_SESSION['First_name'] ?></h2>
    <div class="container d-flex ">
      <?php
      //echo $_SESSION["Image"];  
      //die();
      ?>
    <img class="img-fluid w-25 mx-auto rounded mb-4" src="<?php echo $_SESSION["Image"]; ?>" alt="" />
     </div>

<div class=' container col-6 border-1 border-black   text-center ' >
  <table class= ' table '>
  <tr>
      <td>User Id:</td>
      <td><?php echo $_SESSION['id'] ?></td>
    </tr>
    <tr>
      <td>Name</td> 
      <td><?php echo $_SESSION['First_name']." ".$_SESSION['Last_name'] ?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?php echo $_SESSION['email'] ?></td>
    </tr>
    <tr>
      <td>Contact:</td>
      <td><?php echo $_SESSION['Contact_number'] ?></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><?php echo $_SESSION['password'] ?></td>
    </tr>
    
  </table>
</div>
</body>
</html>