<?php

class CRM_Civialerts_Page_CiviAlertsPage extends CRM_Core_Page {

  public function run() {
	civicrm_api3('CiviAlerts', 'delete', array(	
		'id' => $_GET['id']
	));
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/civicrm/civi-alerts-form?deleted=1';
    header('Location: ' . $home_url);
    parent::run();
  }

}
