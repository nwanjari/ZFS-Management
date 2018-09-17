<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

$action = $_POST['action-method'];

switch ($action) {
    case "_ADD_DISK":
     
        # Throw error if adding new physical disk failed
        if(!_ADD_DISK()) {
            header("Location: /error/msg.php?code=510&msg=Database Error. Please try again after some time");
            exit();
            break;
        }
        # Success
        header("Location: ../view/physical-disk.php?messageBox=[SUCCESS] Physical Disk added successfully");  
    break;

    case "_DELETE_DISK":

        if(empty($_POST['pdGptIDs'])) {
        header("Location: /error/msg.php?code=410&msg=No%20Disk(s)%20Selected.");
        die();
        break;
        }
        $res = _DELETE_DISK();
        $res = implode(",", $res);
        header("Location: ../view/physical-disk.php?messageBox={$res}");
    break;

    case "_UPLOAD_CSV":
        # Check if file is csv otherwise throw error
        if($_FILES['file']['name']) {
            
            $filename = explode('.', $_FILES['file']['name']);
            if($filename[1] != 'csv') {
              header("Location: /error/msg.php?code=410&msg=File%20cannot%20be%20imported.");
              die();
              break;
            }

        $res = _UPLOAD_CSV();
        $res = implode(",", $res);
        header("Location: ../view/physical-disk.php?messageBox={$res}");
        }
    break;
}

function _ADD_DISK() {
    global $model;

    # Check Parameters
    if (!isset($_POST['gptID'])) return false;
    if (!isset($_POST['diskID'])) return false;
    if (!isset($_POST['size'])) return false;
    if (!isset($_POST['make'])) return false;
    if (!isset($_POST['model'])) return false;
    if (!isset($_POST['type'])) return false;
    if (!isset($_POST['purchaseDate'])) return false;
    if (!isset($_POST['status'])) return false;
    
    # Fetch Post Parameters
    $pdGptID = $_POST['gptID'];
    $pdDiskID = $_POST['diskID'];
    $pdSize = $_POST['size'];
    $pdMake = $_POST['make'];
    $pdModel = $_POST['model'];
    $pdType = $_POST['type'];
    $pdPurchaseDate = $_POST['purchaseDate'];
    $pdStatus = $_POST['status'];
    $vdevid = !empty($_POST['vdevid']) ? $_POST['vdevid'] : null ;

    # Add the physical disk
    return $model->addNewPhysicalDisk($pdGptID, $pdDiskID, $pdSize, $pdMake, $pdModel, $pdType, $pdPurchaseDate, $pdStatus,$vdevid);
}

function _DELETE_DISK() {
    global $model;

    # Check Parameter
    if (!isset($_POST['pdGptIDs'])) return false;

    # Fetch Parameter
    $pdGptIDs = $_POST['pdGptIDs'];

    # Delete Location(s)
    foreach ($pdGptIDs as $pdGptID) {
        $res[] = $model->deletePhysicalDiskFromJBOD($pdGptID) && $model->deletePhysicalDisk($pdGptID) ? "Deleted Successfully Disk GPT ID: {$pdGptID}" : "Failed to Delete DISK GPT ID: {$pdGptID}";
    }
    
    return $res;
}

function _UPLOAD_CSV() {
    global $model;
      
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    while($data= fgetcsv($handle))
    {
       $pdGptID = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[0]);
       $pdDiskID = $data[1];
       $pdSize = $data[2];
       $pdMake = $data[3];
       $pdModel = $data[4];
       $pdType = $data[5];
       $pdPurchaseDate =$data[6];
       $pdStatus = $data[7];
       $vdevid = !empty($data[8]) ? $data[8] : null ;
       $jbID = $data[9];
       $installDate = !empty($data[10]) ? $data[10] : null ;
       $coordinates = $data[11];
       $res[] = $model->addNewPhysicalDisk($pdGptID, $pdDiskID, $pdSize, $pdMake, $pdModel, $pdType, $pdPurchaseDate, $pdStatus,$vdevid)
                ? "Added successfully: {$pdGptID}" : "Failed to add: {$pdGptID}";
        
       $model->addPhysicalDiskJBOD($pdGptID, $jbID, $installDate, $coordinates); 
    }

    return $res;
}
?>