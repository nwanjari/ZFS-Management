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

}
?>