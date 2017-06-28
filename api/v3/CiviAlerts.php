<?php

function civicrm_api3_civi_alerts_get($params) {
	$query = "SELECT * FROM civicrm_civialerts 
			  WHERE alert_user = '%0' OR alert_user = ''
			 ";
	$result = CRM_Core_DAO::executeQuery($query, $params);
	$myarray = array();
	$i=0;
	while($result->fetch()){
				$myarray[$i][0] = $result->id;
				$myarray[$i][1] = $result->alert_heading;
				$myarray[$i][2] = $result->alert_body;
				$myarray[$i][3] = $result->alert_url;
				$myarray[$i][4] = $result->alert_repeat;
				$myarray[$i][5] = $result->join_date;
				$i++;
			}
			return $myarray;
}


function civicrm_api3_civi_alerts_create($params) {
	$query = "
		INSERT INTO civicrm_civialerts (alert_heading, alert_body, alert_url, alert_user, alert_repeat, join_date)
		VALUES('%0', '%1', '%2', '%3', '%4', NOW())
	";
  $dao = CRM_Core_DAO::executeQuery($query, $params);
  return civicrm_api3_create_success($params, $params, 'CiviAlerts', 'create');
  }



function civicrm_api3_civi_alerts_delete($params) {
	$id = $params['id'];
	$query = "
		DELETE FROM civicrm_civialerts 
		WHERE id=%0
	";
	$param = array(
    0 => array($id, 'Integer'),
    );

  $dao = CRM_Core_DAO::executeQuery($query, $param); 
}