<?php 
/*
  Plugin Name: Noctuce - CRM
  Plugin URI: https://underconstructionpage.com/
  Description: 
  Author: Programmation Noctuce
  Version: 0.1
  Author URI: http://noctuce.ca/
  Text Domain: noctuce-crm
  Domain Path: lang

  Copyright 2017 - 2019  Programmation Noctuce  (email: info@noctuce.ca)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}

global $noctuce_crm_person_version;
global $noctuce_crm_path;
global $noctuce_crm_content;
global $noctuce_crm_slug;

$noctuce_crm_person_version = "0.1";
$noctuce_crm_path = plugin_dir_path( __FILE__ );
$noctuce_crm_slug = "noctuce-crm";

require_once($noctuce_crm_path . "Noctuce-crm-activation.php");
require_once($noctuce_crm_path . "Noctuce-crm-admin.php");

//register_activation_hook( __FILE__, 'noctuce_crm_activation' );

add_action("admin_menu", "noctuce_crm_setup_menu");