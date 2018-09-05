<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# empty check and for get-query parameter 

# get parameter from query string
$zpoolName = $_GET['zpname'];

# check if zpoolname exists


# call to fetch JBODs and location details for JBOD
$jbodAndLocation = $model->getJBODandLocation($zpoolName);

# call to fetch full details of the zpool
$zpoolDetails = $model->getZpoolDetails($zpoolName);

# call to get zfs-datasets of the zpool
$zfsDatasets =$model->getZfsDataset($zpoolName);

# call to get all physical disks associated with the zpool, group by vdev ids
$zpoolPhysicalDisks = $model->getZpoolPhysicalDisk($zpoolName);
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

<div class="container-fluid"></br>
<h2> ZPool Name : <?php echo $zpoolName?></h2>
</div>
<div class="row">
  <div class="col-md-4">
  <h3> ZPool Details </h3>
  <?php var_dump($zpoolDetails); ?>
  </div>

  <div class="col-md-4">
  <?php 
  echo '<h3> ZFS DataSets </h3>';
  var_dump($zfsDatasets);
  echo '<h3> Physical Disks </h3>';
  var_dump($zpoolPhysicalDisks); ?>
  </div>

  <div class="col-md-4">
  <h3> JBOD Details </h3>
  <?php var_dump($jbodAndLocation); ?>
  </div>

</div>

</body>
</html>