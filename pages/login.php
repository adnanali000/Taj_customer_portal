<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<!-- <link rel="icon" type="image/png" href="../loginpage/images/icons/favicon.ico"/> -->
<link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
<link rel="manifest" href="../site.webmanifest">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../loginpage/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../loginpage/css/util.css">
	<link rel="stylesheet" type="text/css" href="../loginpage/css/main.css">
<!--===============================================================================================-->
    <link rel="stylesheet" href="../css/login.css">
	<link href="http://fonts.cdnfonts.com/css/neutra-text-alt" rel="stylesheet">
	<link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.css">
	<link href="//db.onlinewebfonts.com/c/0d2703af1d063ee7547a5e8a189bdb8f?family=Neutraface+2+Display+Inline" rel="stylesheet" type="text/css"/>
</head>

<body>

<?php
 include('./conn.php');
 if(isset($_POST['submit'])){
 
	$userid = htmlentities($_POST['userid'],ENT_QUOTES);
	$password = htmlentities($_POST['password'],ENT_QUOTES);
	$checkUser = htmlentities($_POST['checkUser'], ENT_QUOTES);

	// testing user for [ admin or customer ]
	// following query will provide all admin records
	$testQuery = "select ui.NETWORKALIAS,ui.NAME, ui.[PASSWORD] 
	from userinfo as ui
	where ui.[ENABLE] = 1 
	and ui.[PASSWORD] is not null 
	and ui.NETWORKALIAS = '".$userid."' and ui.[Password] = '".$password."' ;";

	$stmt3 = sqlsrv_query($conn, $testQuery, array(), array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
	$rowsReturned = sqlsrv_num_rows($stmt3);
	if($rowsReturned == 1){
		// Admin Access
		$query2 = "select UI.NETWORKALIAS,UI.NAME,UI.PASSWORD from USERINFO AS UI where UI.NETWORKALIAS = '".$userid."' and UI.PASSWORD = '". $password."' ";
		$stmt2 = sqlsrv_query($conn, $query2,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
		//$stmt2 ? "success" : "invalid";
		$num2 = sqlsrv_num_rows($stmt2);
		if( $num2 == 1){
			session_start();
			while($res2 = sqlsrv_fetch_array($stmt2)){
				$_SESSION['userid'] = $res2['NETWORKALIAS'];
				$_SESSION['userRole'] = 1;
				header('location: admin.php');
			}
		}else{
			echo '<div class="alert alert-danger bg-white text-center text-danger mb-1 text-large"  role="alert"><i class="fas fa-close" style="color:red;margin:5px;font-size:20px;margin-top:5px;"></i>Wrong Admin Password</div>';	
		}
	//}else if( $rowsReturned == 0){

	}else{
		// if no record found then generate error because user does not have password
		// customer
		$query = "select CT.ACCOUNTNUM,DPT.NAME,CT.[PASSWORD],CT.CONFIRMPW,CT.CustSite
								 FROM CUSTTABLE CT
								 INNER JOIN DIRPARTYTABLE DPT ON CT.PARTY = DPT.RECID
								 where CT.ACCOUNTNUM = '".$userid."' and CT.[PASSWORD] = '".$password."' and CT.CONFIRMPW='".$password."' ";
		$stmt = sqlsrv_query($conn, $query,array(),array("Scrollable"=>'static')) or DIE(sqlsrv_errors());
		//$stmt ? "success" : "invalid";								 
		$num = sqlsrv_num_rows($stmt);
		if( $num == 1){
			session_start();
			while($res = sqlsrv_fetch_array($stmt)){
				$_SESSION['userid']=$res['ACCOUNTNUM'];
				$_SESSION['customersite'] = $res['CustSite'];
				$_SESSION['userRole'] = 0;
				header('location: home.php');
			}
		}else{
			echo '<div class="alert alert-danger bg-white text-center text-danger mb-1 text-large"  role="alert"><i class="fas fa-close" style="color:red;margin:5px;font-size:20px;margin-top:5px;"></i>Wrong Customer Password</div>';	
		}
	}


	// if($userid == 'Nawal.Syed'){
	// 	//admin
			
	// }else{
		
		
	// }
 }
 
 ?>
	
	<div class="limiter">
		<div class="container-login100" id="bgImage" style="background-image: url('../icon/bg6.jpg');">
			<div class="navlogin" id="loginNav">
				<ul class="navli">
					<li><img src="../icon//logo_white.png" alt=""></li>
					<li class="portal">Customer Portal</li>
				</ul>
				<!-- <hr /> -->
			</div>
	
			<div class="message" id="info">
				<h3>COMING TO YOUR  CITY SOON</h3>
				<button><a href="https://tajgasoline.com/customers#Experience" target="_blank" style="color: white;"> Learn more </a></button>
			</div>
			<div class="formbut"  onclick="hide()">
				<button id="loginbtn">Login</button>
			</div>
		<div class="wrap-login100" id="form" style="visibility: hidden;">
		
				<form class="login100-form validate-form"  method="POST" >
					<!-- <span class="login100-form-logo">
						<i class="logo">
                            <img src="../icon/login.png" alt="" />
                        </i>
					</span> -->

					<!-- <span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span> -->
					<!-- <div class="form-check">
  					<input class="form-check-input" type="checkbox" name="check" value="" id="check">
  					<label class="form-check-label" for="check">
    				Admin
  					</label>
					</div>
					 -->
					<div class="wrap-input100 validate-input" id="inp" data-validate = "Enter user id">
						<input class="input100" type="text" name="userid" placeholder="User ID" id="id" >
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" id="name" placeholder="Username" disabled>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="pas" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
                  
					<div class="container-login100-form-btn">
						<button type="submit" id="btnlogin" class="login100-form-btn" name="submit">
							Login
						</button>
					</div>

					 <input type="hidden" name="checkUser" id="checkCustomer" value="0" />
					 <input type="hidden" name="checkUser" id="checkAdmin" value="1" />

				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<!--===============================================================================================-->
	<script src="../loginpage/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/vendor/bootstrap/js/popper.js"></script>
	<script src="../loginpage/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/vendor/daterangepicker/moment.min.js"></script>
	<script src="../loginpage/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../loginpage/js/main.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../js/script.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


</body>
</html>
