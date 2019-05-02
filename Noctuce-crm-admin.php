<?php
require_once($noctuce_crm_path . "Models/Client/Noctuce_CRM_ClientManager.php");
//require_once($noctuce_crm_path . "Models/Contact/Noctuce_CRM_ContactManager.php");
require_once($noctuce_crm_path . "Models/Employee/Noctuce_CRM_EmployeeManager.php");
require_once($noctuce_crm_path . "Models/EmployeeRole/Noctuce_CRM_EmployeeRoleManager.php");
//require_once($noctuce_crm_path . "Models/Entreprise/Noctuce_CRM_EntrepriseManager.php");
//require_once($noctuce_crm_path . "Models/Individual/Noctuce_CRM_IndividualManager.php");
require_once($noctuce_crm_path . "Models/Person/Noctuce_CRM_PersonManager.php");
require_once($noctuce_crm_path . "Models/PersonType/Noctuce_CRM_PersonTypeManager.php");

function noctuce_crm_setup_menu() {
  global $noctuce_crm_path;
  global $noctuce_crm_content;
  //global $noctuce_CRM_ContactManager;
  global $noctuce_CRM_ClientManager;
  global $noctuce_CRM_EmployeeManager;
  global $noctuce_CRM_EmployeeRoleManager;
  // global $noctuce_CRM_EntrepriseManager;
  // global $noctuce_CRM_IndividualManager;
  global $noctuce_CRM_PersonManager;
  global $noctuce_CRM_PersonTypeManager;
  global $noctuce_crm_slug;

  $noctuce_CRM_PersonTypeManager =
    new Noctuce_CRM_PersonTypeManager();
  $noctuce_CRM_PersonManager =
    new Noctuce_CRM_PersonManager(
      $noctuce_CRM_PersonTypeManager);
  $noctuce_CRM_ClientManager =
    new Noctuce_CRM_ClientManager(
      $noctuce_CRM_PersonManager);
  $noctuce_CRM_EmployeeRoleManager =
    new Noctuce_CRM_EmployeeRoleManager();
  // $noctuce_CRM_EntrepriseManager =
  //   new Noctuce_CRM_EntrepriseManager(
  //     $noctuce_CRM_PersonManager);
  // $noctuce_CRM_IndividualManager =
  //   new Noctuce_CRM_IndividualManager(
  //     $noctuce_CRM_PersonManager);
  $noctuce_CRM_EmployeeManager =
    new Noctuce_CRM_EmployeeManager(
      $noctuce_CRM_EmployeeRoleManager,
      $noctuce_CRM_PersonManager);
  /*$noctuce_CRM_ContactManager =
    new Noctuce_CRM_ContactManager(
      $noctuce_CRM_EmployeeManager);*/

  $noctuce_CRM_PersonTypeManager->validateTable();
  $noctuce_CRM_PersonManager->validateTable();
  $noctuce_CRM_ClientManager->validateTable();
  $noctuce_CRM_EmployeeRoleManager->validateTable();
  // $noctuce_CRM_EntrepriseManager->validateTable();
  // $noctuce_CRM_IndividualManager->validateTable();
  $noctuce_CRM_EmployeeManager->validateTable();
  // $noctuce_CRM_ContactManager->validateTable();

  //$noctuce_crm_content .= htmlentities(file_get_contents($noctuce_crm_path . "Views/Menu.php", "r"));

  add_menu_page(
    "Noctuce CRM - Main menu",
    "Noctuce CRM - Main menu",
    "manage_options",
    $noctuce_crm_slug,
    "noctuce_crm_init");

  /*add_submenu_page(
    "noctuce-crm",
    "Noctuce CRM Page",
    "Noctuce CRM",
    "manage_options",
    "noctuce-crm-options");*/

  /*add_submenu_page(
    $noctuce_crm_slug,
    "Noctuce CRM - Options page",
    "Options page",
    "manage_options",
    $noctuce_crm_slug . "-options",
    "noctuce_crm_options");*/

  //add_action( 'the_content', 'outputNoctuceCRMContent' );
}

function noctuce_crm_init() {
  global $noctuce_crm_path;

  wp_enqueue_style('Noctuce_crm_style', plugins_url() . "/Noctuce-CRM/assets/css/styles.css");
  wp_enqueue_script('Noctuce_crm_script', plugins_url() . "/Noctuce-CRM/assets/js/scripts.js");

  include($noctuce_crm_path . "Views/Menu.php");
}

function noctuce_crm_options() {
  global $noctuce_crm_path;

  wp_enqueue_style('Noctuce_crm_style', plugins_url() . "/Noctuce-CRM/assets/css/styles.css");
  wp_enqueue_script('Noctuce_crm_script', plugins_url() . "/Noctuce-CRM/assets/js/scripts.js");

  include($noctuce_crm_path . "Views/OptionsMenu.php");
}

wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

add_action('wp_ajax_ajax_noctuce_crm_get_client', 'ajax_noctuce_crm_get_client');

function ajax_noctuce_crm_get_client()
{
  noctuce_crm_setup_menu();

  global $noctuce_crm_path;
  global $noctuce_CRM_ClientManager;

  $client = $noctuce_CRM_ClientManager->getFromId($_GET["client_id"]);

  if(isset($client))
  {
    include($noctuce_crm_path . "Views/GetClient.php");
  }
  else
  {
    include($noctuce_crm_path . "Views/GetNewClient.php");
  }

  wp_die();
}

function ajax_noctuce_crm_update_Clientontact()
{
  $clientName = $_SERVER["clientName"];
  $clientName = $_SERVER["clientName"];
  $clientName = $_SERVER["clientName"];
}