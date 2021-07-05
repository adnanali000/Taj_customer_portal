<?php
include('conn.php');
include('function.php');
session_start();

if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}

// if user wants to access Admin section
if( $_SESSION['userRole'] == 0){
  // session_destroy();
  header("location: home.php");
}

if (isset($_SESSION['userid']) && $_SESSION['userRole'] == 1 ) {
  $userid = $_SESSION['userid'];
// print_r($_SESSION);

?>


<!doctype html>
<html lang="en">
  <head>
  	<title>Admin</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="../adminPanel/sidebar-01/css/style.css">
	<link href="http://fonts.cdnfonts.com/css/neutra-text-alt" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.bootstrap4.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.dataTables.css">
    <link rel="stylesheet" href="../assets/DataTables2/DataTables-1.10.25/css/jquery.dataTables.min.css">


  </head>
  <style>

  /* action button css */
  .action{
    display: flex;
    flex-direction: row;
  }
  .swal2-title{
    font-size: 16px !important;
  }
  .swal2-styled.swal2-confirm{
    font-size: 12px !important;
    background-color: #ED1C24 !important;
    color: white !important;
  }
  .paginate_button{
    color: grey;
    background: #eff6ee;
    padding:2px !important;
    
}
.paginate_button:hover{
    background: lightgrey !important;
    border:none !important;
}
.dataTables_filter input {
    color: grey !important;
  }
  .dataTables_wrapper .dataTables_filter input{
    padding: 1px !important;
    border-radius: 0px !important;
    border:1px solid #eff6ee !important;
    text-align: center !important;
}
#sidebar li a:hover{
  color: red !important;
}
td{
    text-align: center;
}
.status{
    background-color: white;
    border: none;
}



  </style>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo mb-5" style="background-image: url(../icon/login.png);"></a>
	        <ul class="list-unstyled components mb-5">
	          <!-- <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu"> 
                <li>
                    <a href="#">Home 1</a>
                </li>
                <li>
                    <a href="#">Home 2</a>
                </li>
                <li>
                    <a href="#">Home 3</a>
                </li>
	            </ul> 
	          </li> -->
	          <!-- <li>
	              <a href="#">Test 1</a>
	          </li> -->
	          <!-- <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="#">Page 1</a>
                </li>
                <li>
                    <a href="#">Page 2</a>
                </li>
                <li>
                    <a href="#">Page 3</a>
                </li>
              </ul>
	          </li> -->
	          <li>
              <a href="#">Home</a>
	          </li>
	          <li>
              <a href="./adminApprove.php">Approved</a>
	          </li>
            <li>
              <a href="./TL.php">TL</a>
	          </li>
            <!-- <li>
              <a href="#">Test 4</a>
	          </li> -->
            <li>
              <a href="./logout.php">Logout</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  <!-- Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a> -->
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#" data-toggle="tooltip" data-placement="bottom" title="Admin"><?=$userid?></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li> -->
              </ul>
            </div>
          </div>
        </nav>

                          <!-- customer order data  -->


    <div class="container-fluid">

<!-- <form class="form-inline">
  <div class="form-group mx-sm-3 mb-5">
    <label for="tl" class="sr-only">TL</label>
    <input type="text" class="form-control" id="tl" placeholder="TL">
  </div>
  <button type="submit" class="btn btn-danger mb-5">Save</button>
</form> -->


<table class="table table-sm mt-1 table-hover" id="tab">

  <thead class="head title" style="font-size: 14px;">
    <tr class="table-bordered text-black text-center">
    <th scope="col">S.No</th>
    <th scope="col">TL</th>
    <th scope="col" width=40%>Status</th>
    </tr>
  </thead>
  <tbody>
      
   <tr>
    <td class="so">1</td>
    <td>Petrol</td>
    <td>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-success active status">
    <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
  </label>
  <label class="btn btn-danger status">
    <input type="radio" name="options" id="option2" autocomplete="off"> Inactive
  </label>

</div>
    </td>  
   </tr>

   <tr>
    <td class="so">2</td>
    <td>CNG</td>
    <td>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-success active status">
    <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
  </label>
  <label class="btn btn-danger status">
    <input type="radio" name="options" id="option2" autocomplete="off"> Inactive
  </label>

</div>
    </td>   
   </tr>

   <tr>
    <td class="so">3</td>
    <td>DIESAL</td>
    <td>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-success active status">
    <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
  </label>
  <label class="btn btn-danger status">
    <input type="radio" name="options" id="option2" autocomplete="off"> Inactive
  </label>

</div>
    </td>   
   </tr>


 
  </tbody>
</table>
</div>                    

      </div>
		</div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script src="../adminPanel/sidebar-01/js/jquery.min.js"></script> -->
    <script src="../adminPanel/sidebar-01/js/popper.js"></script>
    <script src="../adminPanel/sidebar-01/js/bootstrap.min.js"></script>
    <script src="../adminPanel/sidebar-01/js/main.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/dataTables.buttons.js"></script>
    <script src="../assets/DataTables2/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/buttons.dataTables.js"></script>
    <script src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/TL.js"></script>


    <script>
      $(document).ready(function() {
        $("#tab").DataTable({
          language: {
            search: "",
            searchPlaceholder: "Search...",
            lengthMenu:     "Show _MENU_ Entries"
          },
          "ordering": false
        });
      
      //tooltip on edit and delete button
      $('[data-toggle="tooltip"]').tooltip({
      trigger : 'hover'
      })        
      
      })

      
      </script>

  </body>
</html>
<?php } ?>