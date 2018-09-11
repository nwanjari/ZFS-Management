<?php
/**
 *   HEADERS. This module is responsible for session management
 *
 * PHP Version 5
 *
 * @file     sn-admin/model.php
 * @category Admin Panel
 * @package  sn-admin
 * @author   Neha Wanjari <nwanjari@tamu.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

require_once($_SESSION['BASE_URL'].'/mysql/mysql.php');

class admin_model {

	private $db;
    
	public function __construct() {
		if (strcmp(gethostname(), 'sacnet.biobio.tamu.edu') === 0) {
			$this->db = new TAMU_MYSQL("conf.ini");
		}
		else {
			$this->db = new TAMU_MYSQL("conf_dev.ini");
		}		
    }

	# Get all physical loactions available
	public function getAllLocations() {
        try {
            $stmt = $this->db->prepare('SELECT * from SN_ADMIN_ZFS_Location');
            $stmt->execute();
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Add new physical location
	public function addNewLocation($locationID, $buildingName, $roomNumber, $rackNumber, $contactPerson, $contactNumber) {
		if ($locationID == null) return false;
		if ($buildingName == null) return false;
		if ($roomNumber == null) return false;
		if ($rackNumber == null) return false;
		if ($contactPerson == null) return false;
		if ($contactNumber == null) return false;

		try {
			$stmt = $this->db->prepare('INSERT INTO SN_ADMIN_ZFS_Location (location_id, building_name, room_number, rack_number, contact_person, contact_number)
										VALUES (:locationID, :buildingName, :roomNumber, :rackNumber, :contactPerson, :contactNumber)');
			$parms = [ 'locationID'    =>$locationID,
					   'buildingName'  =>$buildingName, 
					   'roomNumber'    =>$roomNumber, 
					   'rackNumber'    =>$rackNumber, 
					   'contactPerson' =>$contactPerson, 
					   'contactNumber' =>$contactNumber
			];
			return $stmt->execute($parms);
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		} 
	}

	# Delete the physical location entry with given Location ID
	public function deleteLocation($locationID) {
		if ($locationID == null) return false;
		try {
			$stmt = $this->db->prepare('DELETE FROM SN_ADMIN_ZFS_Location 
										WHERE location_id=:locationID');
			$parms = ['locationID' => $locationID ];
			return $stmt->execute($parms);
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		} 
	}
	
	# Get all the physical disks available with all details
	public function getAllPhysicalDisks() {
        try {
            $stmt = $this->db->prepare('SELECT * from SN_ADMIN_ZFS_Physical_Disk');
            $stmt->execute();
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Add new physical disk to database
	public function addNewPhysicalDisk($pdGptID, $pdDiskID, $pdSize, $pdMake, $pdModel, $pdType, $pdPurchaseDate, $pdStatus,$vdevid) {
		if ($pdGptID == null) return false;
		if ($pdDiskID == null) return false;
		if ($pdSize == null) return false;
		if ($pdMake == null) return false;
		if ($pdModel == null) return false;
		if ($pdType == null) return false;
		if ($pdPurchaseDate == null) return false;
		if ($pdStatus == null) return false;
		
		try {
			$stmt = $this->db->prepare('INSERT INTO SN_ADMIN_ZFS_Physical_Disk (pd_gpt_id, pd_disk_id, pd_size, pd_make, pd_model, pd_type, pd_purchase_date, pd_status, vd_id)
										VALUES (:pdGptID, :pdDiskID, :pdSize, :pdMake, :pdModel, :pdType, :pdPurchaseDate, :pdStatus, :vdevid)');
			$parms = [ 'pdGptID'    	=>$pdGptID,
					   'pdDiskID'  		=>$pdDiskID, 
					   'pdSize'    		=>$pdSize, 
					   'pdMake'    		=>$pdMake, 
					   'pdModel' 		=>$pdModel, 
					   'pdType' 		=>$pdType,
					   'pdPurchaseDate' =>$pdPurchaseDate, 
					   'pdStatus' 		=>$pdStatus,
					   'vdevid'			=>$vdevid
			];
			return $stmt->execute($parms);
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		} 
	}

	# Delete a physical disk entry with given Disk GPT ID
	public function deletePhysicalDisk($pdGptID) {
		if ($pdGptID == null) return false;
		try {
			$stmt = $this->db->prepare('DELETE FROM SN_ADMIN_ZFS_Physical_Disk 
										WHERE pd_gpt_id=:pdGptID');
			$parms = ['pdGptID' => $pdGptID ];
			return $stmt->execute($parms);
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		} 
	}

	# Get details of all Zpools with their JBOD details
	public function listallZpoolJBOD() {
		try {
			$stmt = $this->db->prepare('SELECT zp_name, jb.jb_id, location_id 
										FROM SN_ADMIN_ZFS_JBOD_ZPool jbzp, SN_ADMIN_ZFS_JBOD jb 
										WHERE jbzp.jb_id = jb.jb_id ORDER BY zp_name');
			$stmt->execute();
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		} 
	}

	# Get JBOD and loaction details of a given Zpool
	public function getJBODandLocation($zpoolName) {
		if ($zpoolName ==null) return false;
		try {
			$stmt = $this->db->prepare('SELECT jb.jb_id, jb.location_id, building_name, room_number, rack_number, contact_person, contact_number 
										 FROM SN_ADMIN_ZFS_JBOD jb, SN_ADMIN_ZFS_Location lc 
										 WHERE jb.location_id = lc.location_id 
										 AND jb.jb_id IN (SELECT jb_id FROM SN_ADMIN_ZFS_JBOD_ZPool 
										 				  WHERE zp_name =:zpoolName)');
			$parms = ['zpoolName' => $zpoolName ];
			$stmt->execute($parms);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Get all properties of a given Zpool
	public function getZpoolDetails($zpoolName) {
		if ($zpoolName ==null) return false;
		try {
			$stmt = $this->db->prepare('SELECT * FROM SN_ADMIN_ZFS_ZPool
										 WHERE zp_name = :zpoolName');
			$parms = ['zpoolName' => $zpoolName ];
			$stmt->execute($parms);
			return $stmt->fetch();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Get all the ZFS Datasets for a given Zpool
	public function getZfsDataset($zpoolName) {
		if ($zpoolName ==null) return false;
		try {
			$stmt = $this->db->prepare('SELECT * FROM SN_ADMIN_ZFS_DataSet
										 WHERE zp_name = :zpoolName');
			$parms = ['zpoolName' => $zpoolName ];
			$stmt->execute($parms);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Get the Vdevs and Physical Disks of a given Zpool
	public function getZpoolPhysicalDisk($zpoolName) {
		if ($zpoolName ==null) return false;
		try {
			$stmt = $this->db->prepare('SELECT  vd_name, pd_gpt_id 
										 FROM SN_ADMIN_ZFS_Physical_Disk pd, SN_ADMIN_ZFS_VDev vd 
										 WHERE pd.vd_id = vd.vd_id 
										 AND vd.vd_id IN (SELECT vd_id FROM SN_ADMIN_ZFS_VDev 
										 				  WHERE zp_name =:zpoolName) 
										 ORDER BY vd.vd_id, pd_gpt_id');
			$parms = ['zpoolName' => $zpoolName ];
			$stmt->execute($parms);
			return $stmt->fetchAll();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}

	# Get complete details of a given Physical Disk 
	public function getPhysicalDiskDetails($gptid) {
		if ($gptid ==null) return false;
		try {
			$stmt = $this->db->prepare('SELECT  * FROM SN_ADMIN_ZFS_Physical_Disk 
										 WHERE pd_gpt_id = :gptid');
			$parms = ['gptid' => $gptid ];
			$stmt->execute($parms);
			return $stmt->fetch();
		}
		catch (PDOException $e) {
			die(err_fce("ERROR CODE : " . $e->getMessage()));
		}
	}
	
}
?>