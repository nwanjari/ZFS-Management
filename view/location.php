<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# Call to get details of all available physical locations
$locations = $model->getAllLocations();

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

<div class="container">
  <br>  
  <h3><b>Available Physical Locations</b>  
  <!-- Trigger the modal to add new location-->
  <button type="submit" class="btn btn-sacnet btn-outline-danger float-right" data-toggle="modal" data-target="#addNewLocationModal">Add New Location</button>    
  </h3>
  <br>
  <br>
</div>

<form name="form-deleteLocation" action="../control/control-location.php" method="POST" onsubmit="return confirm('Are you sure to delete selected location(s)?');">
<!-- Render all available locations on the screen -->
<div class="container">
<div class="card-columns">
<?php
foreach($locations as $location)
  {
    echo 
    '<div class="card">     
      <div class="card-header">
        <input type="checkbox" name="locationIDs[]" value="'.$location['location_id'].'"/> <b>Location ID:   '.$location['location_id'].'</b>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <tr>
            <td>Building Name:</td>     
            <td>'.$location['building_name'].'</td>
          </tr>
          <tr>
            <td>Room Number:</td>     
            <td>'.$location['room_number'].'</td>
          </tr>
          <tr>
            <td>Rack Number:</td>     
            <td>'.$location['rack_number'].'</td>
          </tr>
        </table>  
      </div>
      <div class="card-footer">
        Contact Person: '.$location['contact_person'].'<br>
        Contact Number: '.$location['contact_number'].'
      </div>
     </div>
     ';
  }
?>
</div>
</div>

<!-- Delete and Home button container -->
<div class="container"><br>
<button type="submit" class="btn btn-sacnet btn-outline-danger btn-lg">Delete Selected Location(s)</button>
<input type="hidden" name="action-method" id="action-method" value="_DELETE_LOCATION"/>

<a href="/sn-admin/apps/zfs-management/" class="btn btn-sacnet btn-outline-danger btn-lg float-right">Return to Apps Home</a>
</div>

</form>

<!-- Modal: Add New Location -->
<div id="addNewLocationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal Content-->
    <div class="modal-content">
      <form name="form-addLocation" action="../control/control-location.php" method="POST">
      <div class="modal-header">
        <h4 class="modal-title">New Location Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="locationID">Location ID:</label>
          <input type="text" class="form-control" id="locationID" name="locationID" required maxlength="50">
        </div>
        <div class="form-group">
          <label for="buildingName">Building Name:</label>
          <input type="text" class="form-control" id="buildingName" name="buildingName" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="roomNumber">Room Number:</label>
          <input type="text" class="form-control" id="roomNumber" name="roomNumber" required maxlength="50">
        </div>
        <div class="form-group">
          <label for="rackNumber">Rack Number:</label>
          <input type="text" class="form-control" id="rackNumber" name="rackNumber" required maxlength="50">
        </div>
        <div class="form-group">
          <label for="contactPerson">Contact Person:</label>
          <input type="text" class="form-control" id="contactPerson" name="contactPerson" required maxlength="100">
        </div>
        <div class="form-group">
          <label for="contactNumber">Contact Number:</label>
          <input type="text" class="form-control" id="contactNumber" name="contactNumber" required maxlength="100">
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sacnet btn-outline-danger" >Add</button>
        <input type="hidden" name="action-method" id="action-method" value="_ADD_LOCATION"/>
      </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>