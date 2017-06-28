<?php

class CRM_Civialerts_Form_CiviAlertsForm extends CRM_Core_Form {
  public function buildQuickForm() {
if(isset($_GET['success']))
    CRM_Core_Session::setStatus(ts('Alert added successfully'));	  
if(isset($_GET['deleted']))
    CRM_Core_Session::setStatus(ts('Alert deleted successfully'));	  
$this->add(
      'text', // field type
      'alert_heading', // field name
      'Alert Heading' // field label
    );
    $this->add(
      'textarea', // field type
      'alert_body', // field name
      'Alert Body', // field label
	  '',
	  TRUE
    );
    $this->add(
      'text', // field type
      'alert_url', // field name
      'Alert URL', // field label
	  '',
	  TRUE
    );
    $this->add(
      'text', // field type
      'alert_user', // field name
      'User name (Leave empty if you want to show this to all)' // field label
    );

	  $this->addYesNo('alert_repeat', ts('Repeat alert?'));	
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
	
	$query = "SELECT * FROM civicrm_civialerts";
	$result = CRM_Core_DAO::executeQuery($query);

$customContent="<div style='font-weight:bold;font-size:25px;'>Previous Alerts:</div>";
	while($result->fetch()){
		$customContent .="
		<b>Id : </b>$result->id <br><b>Heading : </b>$result->alert_heading <br><b>Body : </b> $result->alert_body <br><b>URL : </b> $result->alert_url <br><b>User : </b> $result->alert_user <br><b>Repeat : </b> $result->alert_repeat <br><b>Added On : </b> ".date('M j Y g:i A', strtotime($result->join_date))."<br>
		<a href='index.php?q=civicrm/civi-alerts-page&id=$result->id'>DELETE</a>
		<hr>";
	}
	$this->assign('customContent', $customContent);		
}

  public function postProcess() {
    $values = $this->exportValues();

$params = array(
    0 => array($values['alert_heading'], 'Text'),
    1 => array($values['alert_body'], 'Text'),
    2 => array($values['alert_url'], 'Text'),
    3 => array($values['alert_user'], 'Text'),
    4 => array($values['alert_repeat'], 'Text'),
  );

civicrm_api3('CiviAlerts', 'create', $params);
    parent::postProcess();
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/civicrm/civi-alerts-form?success=1';
    header('Location: ' . $home_url);		
}


  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
