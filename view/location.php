<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();
$locations = $model->getAllLocations();
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
  <br>
  <h3><b>Available Physical Locations</b></h3>
  <br>
  <br>
</div>

<div class="container">
<div class="card-columns">
<?php
foreach($locations as $location)
  {
    echo 
    '<div class="card">     
     <div class="card-header">
     <input type="checkbox" name="user[]" value="'.$location['location_id'].'"/> Location ID:'.$location['location_id'].'</div>
     <div class="card-body">
     <table>
     <tr>
     <td>Building Name:</td>
     <td></td>
     <td>'.$location['building_name'].'</td>
     </tr>
     <tr>
     <td>Room Number:</td>
     <td></td>
     <td>'.$location['room_number'].'</td>
     </tr>
     <tr>
     <td>Rack Number:</td>
     <td></td>
     <td>'.$location['rack_number'].'</td>
     </tr>
     </table>  
     </div>
     </div>
     ';  
  }
?>
</div>
</div>

</body>
</html>