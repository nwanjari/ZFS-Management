<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# call to fetch all available zpools with their JBODs and location details
$result = $model->listallZpoolJBOD();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="stylesheet" href="/css/sacnet.css" crossorigin="anonymous">
    <title> SACNet :: Admin </title>
</head>

<body>
<ol class="breadcrumb breadcrumb-admin">
  <li class="breadcrumb-item active">SACNet Admin :: <?php echo _GET_APP_DETAILS()['app_name']  ?> </li>
</ol>
<div class="container">
<div class="col">
<h1><br> ZPool-JBOD List </h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th> ZPool Name </th>
      <th> JBOD ID </th>
      <th> JBOD Location ID </th>
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($result as $row)
  {
    echo 
    '<tr>
      <td><a href="details-zpool.php?zpname='.$row['zp_name'].'">'.$row['zp_name'].'</a></td>
      <td>'.$row['jb_id'].'</td>
      <td>'.$row['location_id'].'</td>
    </tr>';   
  }
  ?>
  </tbody>
</table>
<a href="create-zpool.php" class="btn btn-sacnet btn-outline-danger btn-lg">Create new ZPool</a>
<a href="/sn-admin/apps/zfs-management/" class="btn btn-sacnet btn-outline-danger btn-lg float-right">Return to Apps Home</a>
<br>
<hr>
</div>
</div>
</body>
</html>