<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();
$disks = $model->getAllPhysicalDisks();

$messageBoxText = null;
if (empty($_GET)) {
  $messageBox = "invisible";
}
else {
  $messageBox = isset($_GET['messageBox'])?"visible":"invisible";
  if($messageBox) {
    $messageBoxText = $_GET['messageBox'];
  }
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

<br>
<div class="container <?php echo $messageBox ?>">
<span class="d-block p-2 bg-dark text-white"><?php echo $messageBoxText ?></span>
</div>

<div class="container-fluid">
<br>
<h3> <b>List of all Physical Disks</b></h3>

<div class="container-fluid text-right">
<!-- Trigger the modal to add new physical disk-->
<button type="submit" class="btn btn-sacnet btn-outline-danger btn-lg" data-toggle="modal" data-target="#addNewPhysicalDisk">Add New Physical Disk</button>

<!-- Return to Apps Home Button -->
<a href="/sn-admin/apps/zfs-management/" class="btn btn-sacnet btn-outline-danger btn-lg">Return to Apps Home</a>
</div>
</div>
 
<div class="container-fluid"><br><br>
<form name="form-deletePhysicalDisk" action="../control/control-physical-disk.php" method="POST" onsubmit="return confirm('Are you sure to delete selected physical disk(s)?');">
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
      <th> Vdev ID </th>       
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($disks as $disk)
  {
    echo 
    '<tr>
      <td><input type="checkbox" name="pdGptIDs[]" value="'.$disk['pd_gpt_id'].'"/></td>  
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

<!-- Delete Button -->
<button type="submit" class="btn btn-sacnet btn-outline-danger btn-lg">Delete Selected Disk(s)</button>
<input type="hidden" name="action-method" id="action-method" value="_DELETE_DISK"/>

</form>
</div>

<!-- Modal: Add New Physical Disk -->
<div id="addNewPhysicalDisk" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal Content-->
    <div class="modal-content">
      <form name="form-addPhysicalDisk" action="../control/control-physical-disk.php" method="POST">
      <div class="modal-header">
        <h4 class="modal-title">New Physical Disk Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="gptID">Physical Disk GPT ID :</label>
          <input type="text" class="form-control" id="gptID" name="gptID" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="diskID">Disk ID :</label>
          <input type="text" class="form-control" id="diskID" name="diskID" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="size">Size:</label>
          <input type="text" class="form-control" id="size" name="size" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="make">Make:</label>
          <input type="text" class="form-control" id="make" name="make" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="model">Model:</label>
          <input type="text" class="form-control" id="model" name="model" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="type">Type:</label>
          <input type="text" class="form-control" id="type" name="type" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="purchaseDate">Purchase Date:</label>
          <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" required>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <input type="text" class="form-control" id="status" name="status" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="status">Associated VDev ID:</label>
          <input type="vdevid" class="form-control" id="vdevid" name="vdevid" maxlength="100">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sacnet btn-outline-danger" >Add</button>
        <input type="hidden" name="action-method" id="action-method" value="_ADD_DISK"/>
      </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>