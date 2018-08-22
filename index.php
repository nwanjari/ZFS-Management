<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
//require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/web-admin-management/model/model-mysql.php');

//$model = new admin_model();

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

<!-- @IMPLEMENTATION -->
<!-- Start implementing your code from here -->
<div class="container-fluid">
 <div class="admin-img-jumb jumbotron">
  <h2> <b> ZFS File System Management </b>  </h2>
  <h6> <b> Manage Physical Disks, Loactions, JBODS and ZPools with just one click.  </b>  </h6>
 </div>
</div>

<div class="container-fluid">
<br><h3><b>[ What would you like to do ? ]</b></h3>
<div class="card-columns">

 <div class="card">
 <div class="card-body">
  <h4 class="card-title"><a class="maroon" href ="view/location.php"><i class="fas fa-braille"></i> Locations</a></h4>
  <p class="card-text"> Add/Edit/Delete Physical Locations.</p>
 </div>
 </div>
 
 <div class="card">
 <div class="card-body">
  <h4 class="card-title"><a class="maroon" href ="view/physical-disk.php"><i class="fa fa-object-ungroup" aria-hidden="true"></i> Physical Disks</a></h4>
  <p class="card-text"> Add/Replace Physical Disks.</p>
 </div>
 </div>

</div>
</div>

</body>
</html>