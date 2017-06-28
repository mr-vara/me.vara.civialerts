<?php

class CRM_Civialerts_Upgrader extends CRM_Civialerts_Upgrader_Base {

  public function install() {
    $this->executeSqlFile('sql/install.sql');
  }
  
  public function uninstall() {
    $this->executeSqlFile('sql/uninstall.sql');
  }  
  
}
