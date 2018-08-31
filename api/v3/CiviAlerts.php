<?php

function civicrm_api3_civi_alerts_get($params) {
  $sqlParams = array();

  //TODO this is currently Drupal specific; restructure to support all CMS's
  global $user;
  if (!empty($user->name)) {
    $sqlParams = array(
      1 => array($user->name, 'Text'),
    );
  }

  $query = "
    SELECT *
    FROM civicrm_civialerts 
    WHERE alert_user = '%1' 
      OR alert_user = ''
  ";
  $dao = CRM_Core_DAO::executeQuery($query, $sqlParams);
  
  $results = array();
  while ($dao->fetch()) {
    $results[] = array(
      'id' => $dao->id,
      'alert_heading' => $dao->alert_heading,
      'alert_body' => $dao->alert_body,
      'alert_url' => $dao->alert_url,
      'alert_repeat' => $dao->alert_repeat,
      'join_date' => $dao->join_date,
    );
  }
  
  return $results;
}

function civicrm_api3_civi_alerts_create($params) {
  $query = "
    INSERT INTO civicrm_civialerts (alert_heading, alert_body, alert_url, alert_user, alert_repeat, join_date)
    VALUES('%0', '%1', '%2', '%3', '%4', NOW())
  ";
  CRM_Core_DAO::executeQuery($query, $params);

  return civicrm_api3_create_success($params, $params, 'CiviAlerts', 'create');
}

function civicrm_api3_civi_alerts_delete($params) {
  $query = "
    DELETE FROM civicrm_civialerts 
    WHERE id = %1
  ";
  $param = array(
    1 => array($params['id'], 'Integer'),
  );

  CRM_Core_DAO::executeQuery($query, $param);
}
