<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User data</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
  .custom{
    line-height: 0.2 !important;
    height: 20px !important;
  }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">IT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a href="#">Logout</a></button>
    </form>
  </div>
</nav>
    <div class="container-fluid">
        <div class="col-lg-12">
            <h1 class="text-center text-warning mt-2 mb-3">Display User Data</h1>
            <table class="table table-sm table-striped table-hover table-bordered" id="tab1">
              <thead>
                <tr class="bg-dark text-white text-center">
                    <th scope="col">S. No</th>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Update</th> 
                </tr>
              </thead>
                <?php
                    $counter = 1;
                    include 'conn.php';

                    $q = "select * from personal_info";
                    $query = sqlsrv_query($con,$q);

                    while($res=sqlsrv_fetch_array($query)){
                ?>
                <tbody>                 
                  <tr class="text-center">
                    <td><?= $counter;?></td>
                    <td><?php echo $res['id'];?></td>
                    <td><?php echo $res['name'];?></td>
                    <td><?php echo $res['email'];?></td>
                    <td><?php echo $res['phone'];?></td>
                    <td><button class="btn custom btn-sm btn-danger"><a href="#" class="text-white">Delete</a></button></td>
                    <td><button class="btn custom btn-sm btn-success"><a href="#" class="text-white">Update</a></button></td>
                    
                    <!-- <td><button class="btn custom btn-sm btn-danger"><a href="delete.php?id=<?php echo $res['u_id'];?>" class="text-white">Delete</a></button></td> -->
                    <!-- <td><button class="btn custom btn-sm btn-primary"><a href="update.php?id=<?php echo $res['u_id'];?>&username=<?php echo $res['name'] ?>" class="text-white">Update</a></button></td> -->
                    <?php $counter++;?>
                </tr>

                <?php
                    }
                ?>
              </tbody>

            </table>
        </div>
    
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
          $("#tab1").DataTable({

          });
        });
    </script>
</body>
</html>