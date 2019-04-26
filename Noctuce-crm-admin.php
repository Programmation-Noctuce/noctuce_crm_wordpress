<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Person/Noctuce_CRM_PersonManager.php");

function noctuce_crm_setup_menu() {
  global $noctuce_crm_path;
  global $noctuce_crm_content;
  global $noctuce_CRM_PersonManager;

  $noctuce_CRM_PersonManager = new Noctuce_CRM_PersonManager();

  $noctuce_CRM_PersonManager->validateTable();

  $noctuce_crm_content .= htmlentities(file_get_contents($noctuce_crm_path . "Views/Menu.php", "r"));

  add_menu_page(
    "Noctuce CRM Page", 
    "Noctuce CRM", 
    "manage_options", 
    "noctuce-crm", 
    "noctuce_crm_init");

  add_action( 'the_content', 'outputNoctuceCRMContent' );
}

function noctuce_crm_init() {
  global $noctuce_crm_content;

  echo($noctuce_crm_content);
}