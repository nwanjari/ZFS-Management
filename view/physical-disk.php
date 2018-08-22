<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();
$disks = $model->getAllPhysicalDisks();
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

<div class="container-fluid">
<br>
<h2> List of all Physical Disks </h2>
<br>
<br>
<table class="table table-striped">
  <thead>
    <tr>
      <th> Select </th>
      <th> Physical Disk GPT ID </th>
      <th> Size </th>
      <th> Make </th>
      <th> Model </th>      
      <th> Type </th>
      <th> Purchase Date </th>
      <th> Status </th>        
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($disks as $disk)
  {
    echo 
    '<tr>
      <td><input type="checkbox" name="user[]" value="'.$disk['pd_gpt_id'].'"/></td>  
      <td>'.$disk['pd_gpt_id'].'</td>   
      <td>'.$disk['pd_size'].'</td>
      <td>'.$disk['pd_make'].'</td>
      <td>'.$disk['pd_model'].'</td>
      <td>'.$disk['pd_type'].'</td>      
      <td>'.$disk['pd_purchase_date'].'</td>
      <td>'.$disk['pd_status'].'</td>
    </tr>';    
  }
  ?>    
  </tbody>
</table>
</div>

</body>
</html>