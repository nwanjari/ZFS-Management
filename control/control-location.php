<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/app-header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/zfs-management/model/model-mysql.php');

$model = new admin_model();

$action = $_POST['action-method'];

switch ($action) {
    case "_ADD_LOCATION":
     
        # Throw error if adding new location failed
        if(!_ADD_LOCATION()) {
            header("Location: /error/msg.php?code=510&msg=Database Error. Please try again after some time");
            exit();
            break;
        }
        # Success
        header("Location: ../view/location.php?messageBox=[SUCCESS] Location added successfully");  
    break;

    case "_DELETE_LOCATION":

        if(empty($_POST['locationIDs'])) {
        header("Location: /error/msg.php?code=410&msg=No%20Location(s)%20Selected.");
        die();
        break;
        }
        $res = _DELETE_LOCATION();
        $res = implode(",", $res);
        header("Location: ../view/location.php?messageBox={$res}");
    break;
}

function _ADD_LOCATION() {
    global $model;

    # Check Parameters
    if (!isset($_POST['locationID'])) return false;
    if (!isset($_POST['buildingName'])) return false;
    if (!isset($_POST['roomNumber'])) return false;
    if (!isset($_POST['rackNumber'])) return false;
    if (!isset($_POST['contactPerson'])) return false;
    if (!isset($_POST['contactNumber'])) return false;

    # Fetch Post Parameters
    $locationID = $_POST['locationID'];
    $buildingName = $_POST['buildingName'];
    $roomNumber = $_POST['roomNumber'];
    $rackNumber = $_POST['rackNumber'];
    $contactPerson = $_POST['contactPerson'];
    $contactNumber = $_POST['contactNumber'];

    # TO DO: Check if Location ID exists

    # TO DO: Check if same location details exist

    # Add the location
    return $model->addNewLocation($locationID, $buildingName, $roomNumber, $rackNumber, $contactPerson, $contactNumber);
}

function _DELETE_LOCATION() {
    global $model;

    # Check Parameter
    if (!isset($_POST['locationIDs'])) return false;

    # Fetch Parameter
    $locationIDs = $_POST['locationIDs'];

    # Delete Location(s)
    foreach ($locationIDs as $locationID) {
        $res[] = $model->deleteLocation($locationID) ? "Deleted Successfully Location ID: {$locationID}" : "Failed to Delete Location ID: {$locationID}";
    }
    
    return $res;

}
?>