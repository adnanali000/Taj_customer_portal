<?php
include('conn.php');
include('function.php');
session_start();


if (!isset($_SESSION['userid'])) {
  header('location: login.php');
}
if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];

  if (isset($_SESSION['title'])) {
    $title = $_SESSION['title'];
  }


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.bootstrap4.css">
    <link rel="stylesheet" href="../assets/DataTables2/Buttons-1.7.1/css/buttons.dataTables.css">
    <link rel="stylesheet" href="../assets/DataTables2/DataTables-1.10.25/css/jquery.dataTables.min.css">

  </head>

  <body>
                                                <!-- navbar -->
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
          <img src="../icon//login.png" alt="" class="d-inline-block">
          <span class="title mt-3"></span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mr-2">
            <li class="nav-item active">
              <a class="nav-link mt-1" href="#" id="a" style="cursor:text"><?= getName($userid) ?> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user">
                  <i class="fas fa-cog fa-1x" style='color:lightgray'></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#" style="cursor:text"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i><?= getAccount($userid) ?></a>
                <a class="dropdown-item" href="./logout.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Logout</a>
          </ul>

        </div>
      </nav>

                                            <!-- second nav  -->

      <nav class="navbar  mt-2 border-bottom-0 mb-3 navbar-expand-lg navbar-light bg-white">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle ml-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sales Order
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="./allOrder.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i> All Orders</a>
                <a class="dropdown-item" href="./home.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Open Orders</a>
                <a class="dropdown-item" href="./invoicedOrder.php"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Invoiced Orders</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Reports
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#"><i class="fas fa-angle-right" style='font-size:16px;color:red'></i>Ledger Report</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link ml-1 dropdown-toggle text-black" href="./customerbalance.php" target="_blank" id="navbarDropdown" role="button">
                Customer Balance
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/buttons.bootstrap4.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/dataTables.buttons.js"></script>
    <script src="../assets/DataTables2/Buttons-1.7.1/js/buttons.dataTables.js"></script>
    <script src="../assets/DataTables2/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#tab").DataTable({
          language: {
            search: "",
            searchPlaceholder: "Search..."
          },
        });
      })
    </script>
  </body>

  </html>
<?php } ?>