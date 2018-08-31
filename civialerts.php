<?php
require_once 'civialerts.civix.php';

function civialerts_civicrm_navigationMenu(&$params) {
  $params[200] = array(
    'attributes' => array(
      'label'      => 'Alerts',
      'name'       => 'Alerts',
      'url'        => 'civicrm/civi-alerts-form',
      'permission' => null,
      'operator'   => null,
      'separator'  => null,
      'parentID'   => null,
      'navID'      => 200,
      'active'     => 200
    ),
    'child' => NULL,
  );
}

function civialerts_civicrm_alterContent( &$content, $context, $tplName, &$object ) {
  try {
    $results = civicrm_api3('CiviAlerts', 'get', []);
    $alertCookie = unserialize(CRM_Utils_Array::value('civialert', $_COOKIE, ''));

    /*Civi::log()->debug('', [
      'results' => $results,
      '$_COOKIE' => $_COOKIE,
      '$alertCookie' => $alertCookie,
      '$_SERVER[REQUEST_URI]' => $_SERVER['REQUEST_URI'],
    ]);*/

    foreach ($results as $result) {
      //search for url string with strpos so we find partial matches too
      if (strpos($_SERVER['REQUEST_URI'], $result['alert_url']) !== FALSE){
        if (empty($alertCookie) ||
          (!empty($alertCookie) && !in_array($result['id'], $alertCookie)) ||
          $result['alert_repeat'] == 1
        ){
          $content .= _civialerts_buildContent($result);

          if (empty($result['alert_repeat'])) {
            $alertCookie[] = $result['id'];
            setcookie('civialert', serialize($alertCookie), time() + (86400 * 30), "/");
          }
        }
      }
    }
  }
  catch (CiviCRM_API3_Exception $e) {}
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function civialerts_civicrm_config(&$config) {
  _civialerts_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function civialerts_civicrm_xmlMenu(&$files) {
  _civialerts_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function civialerts_civicrm_install() {
  _civialerts_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function civialerts_civicrm_postInstall() {
  _civialerts_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function civialerts_civicrm_uninstall() {
  _civialerts_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function civialerts_civicrm_enable() {
  _civialerts_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function civialerts_civicrm_disable() {
  _civialerts_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function civialerts_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civialerts_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function civialerts_civicrm_managed(&$entities) {
  _civialerts_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civialerts_civicrm_caseTypes(&$caseTypes) {
  _civialerts_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function civialerts_civicrm_angularModules(&$angularModules) {
  _civialerts_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function civialerts_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _civialerts_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

function _civialerts_buildContent($result) {
  $html = "
    <link href=\"https://fonts.googleapis.com/css?family=Titillium+Web\" rel=\"stylesheet\" >
    <style>
      .main-content-window {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%;
        overflow: auto; 
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
      }
      .content-window {
        background-color: #F2F2F2;
        margin: 5% auto 15% auto; 
        max-width:600px;
        text-align:center;
        border-radius:3px;
        border:1px solid #C2C2C2;
      }
      .window-close {
        font-size: 20px;
        font-weight: bold;
        color:#43B7E2;
      }
      .window-close:hover,
      .window-close:focus {
        color: #FF0000;
        cursor: pointer;
      }
      .anim {
        -webkit-animation: animzoom 0.6s;
        animation: animzoom 0.6s
      }
      @-webkit-keyframes animzoom {
        from {-webkit-transform: scale(0)} 
        to {-webkit-transform: scale(1)}
      }
      @keyframes animzoom {
        from {transform: scale(0)} 
        to {transform: scale(1)}
      }
      .my-msg{
        padding:25px;
      }
      .my-msg p{
        font-family: 'Titillium Web', sans-serif;
        text-align:justify;
        max-width:550px;
        margin:auto;
        font-size:19px;
      }
      .my-msg a{
        text-decoration:none;
        color:#43B7E2;
      }
    </style>

    <div id='civi-alert-{$result['id']}' class=\"main-content-window\">
      <div class=\"content-window anim\">
        <div class=\"my-msg\">
          <h2>".htmlspecialchars_decode($result['alert_heading'])."</h2>
          <p>".htmlspecialchars_decode($result['alert_body'])." <br \>
          <span onclick=\"document.getElementById('civi-alert-{$result['id']}').style.display='none'\" id=\"window-closebtn\" class=\"window-close\">CLOSE</span>
          </p>
        </div>
      </div>
    </div>

    <script>
      window.onload = function(){
        document.getElementById('civi-alert-{$result['id']}').style.display='block';
      }
      var mainContentWindow = document.getElementById('civi-alert-{$result['id']}');
      window.onclick = function(event) {
        if (event.target == mainContentWindow) {
          mainContentWindow.style.display = \"none\";
        }
      }
    </script>
  ";

  return $html;
}
