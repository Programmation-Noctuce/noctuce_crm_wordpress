<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Entreprise/Noctuce_CRM_Entreprise.php");

class Noctuce_CRM_EntrepriseManager
{
    private $_table_name;

    private $_noctuce_CRM_PersonManager;

    private $_list;

    function __construct($noctuce_CRM_PersonManager)
    {
        if(gettype($noctuce_CRM_PersonManager) != "object" ||
            get_class($noctuce_CRM_PersonManager) != "Noctuce_CRM_PersonManager")
        die("Noctuce_CRM_EntrepriseManager __construct require Noctuce_CRM_PersonManager");

        $this->_noctuce_CRM_PersonManager = $noctuce_CRM_PersonManager;

        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getEntrepriseList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_entreprise";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_entreprise_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option("noctuce_crm_entreprise_version") != $noctuce_crm_entreprise_version) {
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

        $entrepriseRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];

        foreach($entrepriseRows as $entrepriseRow)
        {
            $entreprise = new Noctuce_CRM_Entreprise();
            
            $entreprise->initFromRow($entrepriseRow,
                $this->_noctuce_CRM_PersonManager->getFromId($entrepriseRow["person_id"]));

            array_push($this->_list, $entreprise);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_EntrepriseManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentEntreprise)
        {
            if($currentEntreprise->getId() == $id)
            {
                return $currentEntreprise;
            }
        }

        return null;
    }
}