
<?php
	//include connection file 
	include_once("db.php");
	
	//$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Employee($connString);

	switch($action) {
	 case 'edit':
	$empCls->updateEmployee($params);
	 break;
	 default:
	 $empCls->getEmployees($params);
	 return;
	}
	
	class Employee {
	protected $con;
	protected $data = array();
	function __construct($connString) {
		$this->con = $connString;
	}
	
	public function getEmployees($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" (facilities_type LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR Dist_Name LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR Block_Name LIKE'".$params['searchPhrase']."%' ";
			$where .=" OR fac_name LIKE'".$params['searchPhrase']."%' ";
			$where .=" OR marks LIKE'".$params['searchPhrase']."%' ";
			$where .=" OR obt LIKE'".$params['searchPhrase']."%' )";	
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT fac_name FROM state_dash_view;";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->con, $sqlTot) or die("error to fetch Patient data");
		$queryRecords = mysqli_query($this->con, $sqlRec) or die("error to fetch Patient data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data   // total data array
			);
		
		return $json_data;
	}
	function updateEmployee($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update ass_reg set status = '" . $params["edit_Status"] ."' WHERE id='".$_POST["edit_id"]."'";
		
		echo $result = mysqli_query($this->con, $sql)or die("error to update Patient accept/Reject status");
	}
	
	
}
?>
	