<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Contact/Noctuce_CRM_Contact.php");

class Noctuce_CRM_ContactManager
{
    private $_table_name;

    private $_noctuce_CRM_EmployeeManager;

    private $_list;

    function __construct($noctuce_CRM_EmployeeManager)
    {
        if(gettype($noctuce_CRM_EmployeeManager) != "object" ||
            get_class($noctuce_CRM_EmployeeManager) != "Noctuce_CRM_EmployeeManager")
        die("Noctuce_CRM_ContactManager __construct require Noctuce_CRM_EmployeeManager");

        $this->_noctuce_CRM_EmployeeManager = $noctuce_CRM_EmployeeManager;

        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getContactList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_contact";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_contact_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option("noctuce_crm_contact_version") != $noctuce_crm_contact_version) {
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
            employee_id  INT NOT NULL, 
            FOREIGN KEY (employee_id) REFERENCES " . 
            $this->_noctuce_CRM_EmployeeManager->getTableName() . "(id)
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

        $contactRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];

        foreach($contactRows as $contactRow)
        {
            $contact = new Noctuce_CRM_Contact();
            
            $contact->initFromRow($contactRow,
                $this->_noctuce_CRM_EmployeeManager->getFromId($contactRow["employee_id"]));

            array_push($this->_list, $contact);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_ContactManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentContact)
        {
            if($currentContact->getId() == $id)
            {
                return $currentContact;
            }
        }

        return null;
    }
}