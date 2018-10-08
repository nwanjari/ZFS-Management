<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# call to fetch disks which has failed status
$disks =$model->getFailedDisks();

$vdevWithDiskFailures = $model->getVdevFailedDisksCount();

  $criticalVdevs = array();
  $warningVdevs = array();
  $criticalVdevDetails = null;
  $warningVdevDetails = null;

foreach($vdevWithDiskFailures as $vdev) {
  $diskCount = $model->getVdevDisksCount($vdev['vd_id']);
  $totalDisk = (int)($diskCount[0]);
  $compareTo = $totalDisk/2;
  $failedDisk = (int)$vdev['count(vd_id)'];
  
  //critical
  if($failedDisk >= $compareTo) {
    $criticalVdevs[] = $vdev['vd_id'];
  }

  //warning
  else {
    $warningVdevs[] = $vdev['vd_id'];
  }
}

if($criticalVdevs != null) {
  $criticalVdevDetails = $model->getVdevDetails($criticalVdevs);
}
if ($warningVdevs != null) {
  $warningVdevDetails = $model->getVdevDetails($warningVdevs);
}

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
<h1><br> VDEV Health: </h1>
<h3> Critical </h3>
<table class="table">
 <thead>
  <tr>
    <th> VDEV ID </th>
    <th> VDEV Name </th>
    <th> ZPool Name </th>
  </tr>  
 </thead>
 <tbody>
  <?php
  if( $criticalVdevDetails != null ) {  
  foreach ($criticalVdevDetails as $Vdev) 
  {
    echo
    '<tr>      
      <td class="bg-danger">'.$Vdev['vd_id'].'</td>   
      <td>'.$Vdev['vd_name'].'</td>
      <td>'.$Vdev['zp_name'].'</td>
    </tr>';

  }
}
  ?>
 </tbody>
</table>

<h3> Warning </h3>

<table class="table">
 <thead>
  <tr>
    <th> VDEV ID </th>
    <th> VDEV Name </th>
    <th> ZPool Name </th>
  </tr>  
 </thead>
 <tbody>
  <?php
  if( $warningVdevDetails != null ) {  
  foreach ($warningVdevDetails as $Vdev) 
  {
    echo
    '<tr>      
      <td class="bg-warning">'.$Vdev['vd_id'].'</td>   
      <td>'.$Vdev['vd_name'].'</td>
      <td>'.$Vdev['zp_name'].'</td>
    </tr>';

  }
}
  ?>
 </tbody>
</table>

<h1><br> Disk Failures: </h1>
<table class="table table-striped">
  <thead>
    <tr>      
      <th> Physical Disk GPT ID </th>
      <th> Size </th>
      <th> Make </th>
      <th> Model </th>      
      <th> Type </th>
      <th> Purchase Date </th>
      <th> Status </th> 
      <th> Vdev ID </th>           
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($disks as $disk)
  {
    echo 
    '<tr>      
      <td>'.$disk['pd_gpt_id'].'</td>   
      <td>'.$disk['pd_size'].'</td>
      <td>'.$disk['pd_make'].'</td>
      <td>'.$disk['pd_model'].'</td>
      <td>'.$disk['pd_type'].'</td>      
      <td>'.$disk['pd_purchase_date'].'</td>
      <td>'.$disk['pd_status'].'</td>
      <td>'.$disk['vd_id'].'</td>
    </tr>';    
  }
  ?>    
  </tbody>
</table>
<a href="/sn-admin/apps/zfs-management/" class="btn btn-sacnet btn-outline-danger btn-lg">Return to Apps Home</a>
<br>
<hr>
</div>
</div>
</body>
</html>