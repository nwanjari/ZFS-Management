<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# empty check for get-query string parameter 
if(!isset($_GET['gptid'])) {
    header("Location: /error/fatal.php?code=5000&msg='No ZPool Found'");
    die();
  }

// get parameter from query string
$gptid = $_GET['gptid'];

// call to fetch user group details
$disk = $model->getPhysicalDiskDetails($gptid);
if (!$disk) {
  header("Location: /error/fatal.php?code=5000&msg='Physical Disk GPT ID does not exist'");
  die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/sacnet.css" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <title> SACNet :: Admin </title>
</head>

<body>
<ol class="breadcrumb breadcrumb-admin">
  <li class="breadcrumb-item active">SACNet Admin :: <?php echo _GET_APP_DETAILS()['app_name']  ?> </li>
</ol>

<div class="container"></br>  
  <h3><b>Physical Disk Details</b></h3></br>
</div>

<div class="container">
<div class="card-columns">
    <div class="card">     
      <div class="card-header">
        <b>Physical Disk GPT ID:   <?php echo $disk['pd_gpt_id'] ?></b>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <tr>
            <td>Size</td>     
            <td><?php echo $disk['pd_size']?></td>
          </tr>
          <tr>
            <td>Make</td>     
            <td><?php echo $disk['pd_make']?></td>
          </tr>
          <tr>
            <td>Model</td>     
            <td><?php echo $disk['pd_model']?></td>
          </tr>
          <tr>
            <td>Type</td>     
            <td><?php echo $disk['pd_type']?></td>
          </tr>
          <tr>
            <td>Purchase Date</td>     
            <td><?php echo $disk['pd_purchase_date']?></td>
          </tr>
          <tr>
            <td>Status</td>     
            <td><?php echo $disk['pd_status']?></td>
          </tr>
          <tr>
            <td>Vdev ID</td>     
            <td><?php echo $disk['vd_id']?></td>
          </tr>
        </table>  
      </div>      
     </div>     
</div>
</div>
</body>
</html>