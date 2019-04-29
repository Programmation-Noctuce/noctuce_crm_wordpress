<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Employee/Noctuce_CRM_Employee.php");

class Noctuce_CRM_EmployeeManager
{
    private $_table_name;

    private $_noctuce_CRM_EmployeeRoleManager;
    private $_noctuce_CRM_EntrepriseManager;
    private $_noctuce_CRM_PersonManager;

    private $_list;

    function __construct(
        $noctuce_CRM_EmployeeRoleManager, 
        $noctuce_CRM_EntrepriseManager, 
        $noctuce_CRM_PersonManager)
    {
        if(gettype($noctuce_CRM_EmployeeRoleManager) != "object" ||
            get_class($noctuce_CRM_EmployeeRoleManager) != "Noctuce_CRM_EmployeeRoleManager")
        die("Noctuce_CRM_EmployeeManager __construct require Noctuce_CRM_EmployeeRoleManager");

        if(gettype($noctuce_CRM_EntrepriseManager) != "object" ||
            get_class($noctuce_CRM_EntrepriseManager) != "Noctuce_CRM_EntrepriseManager")
        die("Noctuce_CRM_EmployeeManager __construct require Noctuce_CRM_EntrepriseManager");

        if(gettype($noctuce_CRM_PersonManager) != "object" ||
            get_class($noctuce_CRM_PersonManager) != "Noctuce_CRM_PersonManager")
        die("Noctuce_CRM_EmployeeManager __construct require Noctuce_CRM_PersonManager");

        $this->_noctuce_CRM_EmployeeRoleManager = $noctuce_CRM_EmployeeRoleManager;
        $this->_noctuce_CRM_EntrepriseManager = $noctuce_CRM_EntrepriseManager;
        $this->_noctuce_CRM_PersonManager = $noctuce_CRM_PersonManager;

        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getEmployeeList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_employee";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_employee_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option("noctuce_crm_employee_version") != $noctuce_crm_employee_version) {
            $this->updateTable();
        }
    }

    public function createTable()
    {
        global $wpdb;
        global $noctuce_crm_path;

        $sql = "
        CREATE TABLE " . $this->_table_name . " (
            id        INT PRIMARY KEY AUTO_INCREMENT,
            person_id  INT NOT NULL, 
            entreprise_id  INT NOT NULL, 
            employee_role_id  INT NOT NULL, 
            FOREIGN KEY (person_id) REFERENCES " . 
            $this->_noctuce_CRM_PersonManager->getTableName() . "(id), 
            FOREIGN KEY (entreprise_id) REFERENCES " . 
            $this->_noctuce_CRM_EntrepriseManager->getTableName() . "(id), 
            FOREIGN KEY (employee_role_id) REFERENCES " . 
            $this->_noctuce_CRM_EmployeeRoleManager->getTableName() . "(id)
        ) " . $wpdb->get_charset_collate() . ";";

        require_once( $_SERVER['DOCUMENT_ROOT'] . 'wp-includes/wp-db.php' );
        $yolo = $wpdb->get_results($sql);
    }

    public function updateTable()
    {
    }

    private function updateList()
    {
        global $wpdb;

        $employeeRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];

        foreach($employeeRows as $employeeRow)
        {
            $employee = new Noctuce_CRM_Employee();

            $employee->initFromRow($employeeRow,
                $this->_noctuce_CRM_PersonManager->getFromId($employeeRow["person_id"]),
                $this->_noctuce_CRM_EntrepriseManager->getFromId($employeeRow["entreprise_id"]),
                $this->_noctuce_CRM_EmployeeRoleManager->getFromId($employeeRow["employee_role_id"]));

            array_push($this->_list, $employee);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_EmployeeManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentEmployee)
        {
            if($currentEmployee->getId() == $id)
            {
                return $currentEmployee;
            }
        }

        return null;
    }
}