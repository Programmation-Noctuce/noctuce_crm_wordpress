<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Individual/Noctuce_CRM_Individual.php");

class Noctuce_CRM_IndividualManager
{
    private $_table_name;

    private $_noctuce_CRM_PersonManager;

    private $_list;

    function __construct($noctuce_CRM_PersonManager)
    {
        if(gettype($noctuce_CRM_PersonManager) != "object" ||
            get_class($noctuce_CRM_PersonManager) != "Noctuce_CRM_PersonManager")
        die("Noctuce_CRM_IndividualManager __construct require Noctuce_CRM_PersonManager");

        $this->_noctuce_CRM_PersonManager = $noctuce_CRM_PersonManager;

        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getIndividualList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_individual";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_individual_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option("noctuce_crm_individual_version") != $noctuce_crm_individual_version) {
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
            FOREIGN KEY (person_id) REFERENCES " . 
            $this->_noctuce_CRM_PersonManager->getTableName() . "(id)
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

        $individualRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];

        foreach($individualRows as $individualRow)
        {
            $individual = new Noctuce_CRM_Individual();
            
            $individual->initFromRow($individualRow,
                $this->_noctuce_CRM_PersonManager->getFromId($individualRow["person_id"]));

            array_push($this->_list, $individual);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_IndividualManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentIndividual)
        {
            if($currentIndividual->getId() == $id)
            {
                return $currentIndividual;
            }
        }

        return null;
    }
}