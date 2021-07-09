<?php
include('conn.php');
include('navbar.php');

// if(){

    if(isset($_POST['submit'])){
        // $oldPass = htmlentities($_POST['oldpass'],ENT_QUOTES);
        $newPass = htmlentities($_POST['newpass'],ENT_QUOTES);
        $confirmPass = htmlentities($_POST['confirmpass'],ENT_QUOTES);
        $query = "update CUSTTABLE set PASSWORD = '".$newPass."', CONFIRMPW = '".$confirmPass."' where ACCOUNTNUM = '".$_SESSION['userid']."'";
        $stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
        if($stmt){
            echo "<script>Swal.fire({text:'Password Updated', allowOutsideClick: false}).then(function(result){
              if(result.value){
                window.location.href = 'home.php'
              }
            });
            </script>";

        }else{
            echo "<script>Swal.fire('Some Error Occur')</script>";

        }
    }
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<style>
   #nav2{
        display: none !important;
    }
   
    #changeform{
        padding: 20px;
        border: 1px solid white;
        width: 29%;
        margin:auto;
        margin-top: 7%;
        height: 330px;
        border-radius: 3px;
        box-shadow: 2px 2px 4px 2px gray;
    }
    .btn{
      margin-left: 80% !important;
    }
  
  
    
</style>
<body>

<div class="container-fluid">
<div id="changeform">
<form method="POST" id="changepassword">
  <div class="form-group">
    <label for="olpass">Old Password</label>
    <input type="password" class="form-control" name="oldpass" id="oldpass" aria-describedby="passwordHelp" placeholder="Enter your old password">
      </div>
  <div class="form-group">
    <label for="newpass">New Passowrd</label>
    <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Enter your new password" disabled>
  </div>
  <div class="form-group">
    <label for="confirmpass">Confirm Passowrd</label>
    <input type="password" class="form-control" name="confirmpass" id="confirmpass" placeholder="Confirm password" disabled>
  </div>
  
  <button type="submit" id="submit" class="btn btn-danger pull-right" name="submit" disabled>Save</button>
</form>
</div>  


</div>

<script src="../js/changepassword.js"></script>
</body>
<!-- <?php //}?> -->
</html>
