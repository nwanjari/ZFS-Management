<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

# empty check for get-query string parameter 
if(!isset($_GET['zpname'])) {
  header("Location: /error/fatal.php?code=5000&msg='No ZPool Found'");
  die();
}

# get parameter from query string
$zpoolName = $_GET['zpname'];

# check if zpoolname exists and fetch its full details
$zpoolDetails = $model->getZpoolDetails($zpoolName);
if (!$zpoolDetails) {
  header("Location: /error/fatal.php?code=5000&msg='ZPool does not exist'");
  die();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/menu/build.php');

# call to fetch JBODs and location details for JBOD
$jbodAndLocations = $model->getJBODandLocation($zpoolName);

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
</ol></br>

<div class="row">
  <div class="col-md-1">
  </div>
  <div class="col-md-3">
  <h3> ZPool Properties </h3></br>
      <table class="table table-striped table-bordered">
          <tr>
            <td> Name</td>     
            <td><?php echo $zpoolDetails['zp_name'] ?></td>
          </tr>
          <tr>
            <td> Altroot</td>     
            <td><?php echo $zpoolDetails['zp_altroot'] ?></td>
          </tr>
          <tr>
            <td>Allocated</td>     
            <td><?php echo $zpoolDetails['zp_allocated'] ?></td>
          </tr>
          <tr>
            <td>Auto Replace</td>     
            <td><?php echo $zpoolDetails['zp_autoreplace'] ?></td>
          </tr>
          <tr>
            <td>Capacity Actual</td>     
            <td><?php echo $zpoolDetails['zp_capacity_actual'] ?></td>
          </tr>
          <tr>
            <td>Capacity Physical</td>     
            <td><?php echo $zpoolDetails['zp_capacity_physical'] ?></td>
          </tr>
          <tr>
            <td>Delegation</td>     
            <td><?php echo $zpoolDetails['zp_delegation'] ?></td>
          </tr>
          <tr>
            <td>Tail Mode</td>     
            <td><?php echo $zpoolDetails['zp_tailmode'] ?></td>
          </tr>
          <tr>
            <td>Free</td>     
            <td><?php echo $zpoolDetails['zp_free'] ?></td>
          </tr>
          <tr>
            <td> Guid</td>     
            <td><?php echo $zpoolDetails['zp_guid'] ?></td>
          </tr>
          <tr>
            <td>Health</td>     
            <td><?php echo $zpoolDetails['zp_health'] ?></td>
          </tr>
          <tr>
            <td>Size</td>     
            <td><?php echo $zpoolDetails['zp_size'] ?></td>
          </tr>
          <tr>
            <td>Version</td>     
            <td><?php echo $zpoolDetails['zp_version'] ?></td>
          </tr>
          <tr>
            <td>Available</td>     
            <td><?php echo $zpoolDetails['zp_available'] ?></td>
          </tr>
          <tr>
            <td>Referenced</td>     
            <td><?php echo $zpoolDetails['zp_referenced'] ?></td>
          </tr>
          <tr>
            <td>Compression Ratio</td>     
            <td><?php echo $zpoolDetails['zp_compression_ratio'] ?></td>
          </tr>
          <tr>
            <td>Mounted</td>     
            <td><?php echo $zpoolDetails['zp_mounted'] ?></td>
          </tr>
          <tr>
            <td>Quota</td>     
            <td><?php echo $zpoolDetails['zp_quota'] ?></td>
          </tr>
          <tr>
            <td>Reservation</td>     
            <td><?php echo $zpoolDetails['zp_reservation'] ?></td>
          </tr>
          <tr>
            <td>Record Size</td>     
            <td><?php echo $zpoolDetails['zp_recordsize'] ?></td>
          </tr>
          <tr>
            <td>Mount Point</td>     
            <td><?php echo $zpoolDetails['zp_mountpoint'] ?></td>
          </tr>
          <tr>
            <td>Share NFS</td>     
            <td><?php echo $zpoolDetails['zp_sharenfs'] ?></td>
          </tr>
          <tr>
            <td>Compression</td>     
            <td><?php echo $zpoolDetails['zp_compression'] ?></td>
          </tr>
          <tr>
            <td>Exec</td>     
            <td><?php echo $zpoolDetails['zp_exec'] ?></td>
          </tr>
          <tr>
            <td>Set UID</td>     
            <td><?php echo $zpoolDetails['zp_setuid'] ?></td>
          </tr>
          <tr>
            <td>Read Only</td>     
            <td><?php echo $zpoolDetails['zp_readonly'] ?></td>
          </tr>
          <tr>
            <td>ACL mode</td>     
            <td><?php echo $zpoolDetails['zp_aclmode'] ?></td>
          </tr>
          <tr>
            <td>ACL Inherit</td>     
            <td><?php echo $zpoolDetails['zp_aclinherit'] ?></td>
          </tr>
          <tr>
            <td>Can Mount</td>     
            <td><?php echo $zpoolDetails['zp_canmount'] ?></td>
          </tr>
          <tr>
            <td>Share MB</td>     
            <td><?php echo $zpoolDetails['zp_sharemb'] ?></td>
          </tr>          
        </table>  
  </div>
 
  <div class="col-md-4">
  <?php 
  echo '<h3> ZFS DataSets </h3><br/>';
  ?>
  <div>
  <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th> ZFS Dataset Name </th>
      <th> Size </th>      
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($zfsDatasets as $dataset)
  {
    echo 
    '<tr>      
      <td>'.$dataset['zfsds_name'].'</td>
      <td>'.$dataset['zfsds_size'].'</td>
    </tr>';   
  }
  ?>
  </tbody>
  </table>
  </div>
  <?php
  echo '<h3> Physical Disks </h3><br/>';
  ?>
    <div>
  <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th> VDev Name </th>
      <th> Physical Disk GPT ID </th>      
    </tr>
  </thead>
  <tbody>
  <?php
  foreach($zpoolPhysicalDisks as $disk)
  {
    echo 
    '<tr>      
      <td>'.$disk['vd_name'].'</td>      
      <td><a href="details-physical-disk.php?gptid='.$disk['pd_gpt_id'].'">'.$disk['pd_gpt_id'].'</a></td>      
    </tr>';   
  }
  ?>
  </tbody>
  </table>  
</div>
</div>
  <div class="col-md-3">
  <h3> JBOD Details </h3><br/>
  <!-- Render all available locations on the screen -->
<div class="container-fluid">

<?php
foreach($jbodAndLocations as $row)
  {
    echo 
    '<div class="card">     
      <div class="card-header">
        <b>JBOD ID:   '.$row['jb_id'].'</b>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <tr>
            <td>Location ID:</td>     
            <td>'.$row['location_id'].'</td>
          </tr>
          <tr>
            <td>Building Name:</td>     
            <td>'.$row['building_name'].'</td>
          </tr>
          <tr>
            <td>Room Number:</td>     
            <td>'.$row['room_number'].'</td>
          </tr>
          <tr>
            <td>Rack Number:</td>     
            <td>'.$row['rack_number'].'</td>
          </tr>
        </table>  
      </div>
      <div class="card-footer">
        Contact Person: '.$row['contact_person'].'<br>
        Contact Number: '.$row['contact_number'].'
      </div>
     </div><br/>
     ';
  }
?>
</div>
</div>

</body>
</html>