<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/EmployeeRole/Noctuce_CRM_EmployeeRole.php");

class Noctuce_CRM_EmployeeRoleManager
{
    private $_table_name;

    private $_list;

    function __construct()
    {
        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getEmployeeRoleList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_employee_role";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_employee_role_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option($this->_table_name . "_version") != $noctuce_crm_employee_role_version) {
            $this->updateTable();
        }
    }

    public function createTable()
    {
        global $wpdb;
        global $noctuce_crm_path;

        $sql = "
        CREATE TABLE " . $this->_table_name . " (
            id      INT PRIMARY KEY AUTO_INCREMENT,
            name    VARCHAR(256) NOT NULL
        ) " . $wpdb->get_charset_collate() . ";";
    
        require_once( $_SERVER['DOCUMENT_ROOT'] . 'wp-includes/wp-db.php' );
        $wpdb->get_results($sql);

        add_option($this->_table_name . "_version", "0.1");
    }

    public function updateTable()
    {
    }

    private function updateList()
    {
        global $wpdb;

        $employeeRoleRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];
    
        foreach($employeeRoleRows as $employeeRoleRow)
        {
            $employeeRole = new Noctuce_CRM_EmployeeRole();

            $employeeRole->initFromRow($employeeRoleRow);

            array_push($this->_list, $employeeRole);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_EmployeeRoleManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentEmployeeRole)
        {
            if($currentEmployeeRole->getId() == $id)
            {
                return $currentEmployeeRole;
            }
        }

        return null;
    }
}