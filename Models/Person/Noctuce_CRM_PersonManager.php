<?php
global $noctuce_crm_path;

require_once($noctuce_crm_path . "Models/Person/Noctuce_CRM_Person.php");

class Noctuce_CRM_PersonManager
{
    private $_table_name;

    private $_noctuce_CRM_PersonTypeManager;

    private $_list;

    function __construct($noctuce_CRM_PersonTypeManager)
    {
        if(gettype($noctuce_CRM_PersonTypeManager) != "object" ||
            get_class($noctuce_CRM_PersonTypeManager) != "Noctuce_CRM_PersonTypeManager")
        die("Noctuce_CRM_PersonManager __construct require Noctuce_CRM_PersonTypeManager");

        $this->_noctuce_CRM_PersonTypeManager = $noctuce_CRM_PersonTypeManager;

        $this->init();
    }

    function getTableName()
    {
        return $this->_table_name;
    }

    function getPersonList()
    {
        $this->updateList();

        return $this->_list;
    }

    public function init()
    {
        global $wpdb;
        
        $this->_table_name = $wpdb->prefix . "noctuce_crm_person";
    }

    public function validateTable()
    {
        global $wpdb;
        global $noctuce_crm_person_version;
        
        $charset_collate = $wpdb->get_charset_collate();

        if($wpdb->get_var("SHOW TABLES LIKE '" . $this->_table_name . "';") != $this->_table_name) {
            $this->createTable();
        }

        if(get_option($this->_table_name . "_version") != $noctuce_crm_person_version) {
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
            name    VARCHAR(256) NOT NULL, 
            person_type_id  INT NOT NULL, 
            FOREIGN KEY (person_type_id) REFERENCES " . 
            $this->_noctuce_CRM_PersonTypeManager->getTableName() . "(id)
        ) " . $wpdb->get_charset_collate() . ";";
    
        require_once( $_SERVER['DOCUMENT_ROOT'] . 'wp-includes/wp-db.php' );
        $wpdb->get_results($sql);

        /*$welcome_name = 'Mr. WordPress';
        $welcome_text = 'Congratulations, you just completed the installation!';

        $table_name = $wpdb->prefix . 'liveshoutbox';

        $wpdb->insert( 
            $table_name, 
            array( 
                'time' => current_time( 'mysql' ), 
                'name' => $welcome_name, 
                'text' => $welcome_text, 
            ) 
        );*/

        add_option($this->_table_name . "_version", "0.1");
    }

    public function updateTable()
    {
        /*$sql = "
        CREATE TABLE " . $table_name . " (
            id      INT PRIMARY KEY AUTO_INCREMENT,
            name    VARCHAR(256) NOT NULL
        ) " . $wpdb->get_charset_collate() . ";";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $welcome_name = 'Mr. WordPress';
        $welcome_text = 'Congratulations, you just completed the installation!';

        $table_name = $wpdb->prefix . 'liveshoutbox';

        $wpdb->insert( 
            $table_name, 
            array( 
                'time' => current_time( 'mysql' ), 
                'name' => $welcome_name, 
                'text' => $welcome_text, 
            ) 
        );

        update_option("noctuce_crm_person_version", $noctuce_crm_person_version);*/
    }

    private function updateList()
    {
        global $wpdb;

        $personRows = $wpdb->get_results("SELECT * FROM " . $this->_table_name, ARRAY_A);

        $this->_list = [];
    
        foreach($personRows as $personRow)
        {
            $person = new Noctuce_CRM_Person();

            $person->initFromRow($personRow, 
                $this->_noctuce_CRM_PersonTypeManager->getFromId($personRow["person_type_id"]));

            array_push($this->_list, $person);
        }
    }

    public function getFromId($id)
    {
        try {
            settype($id, "integer");
        }
        catch(Exception $e) {
            die("Noctuce_CRM_PersonManager getFromId require integer");
        }
        
        $this->updateList();

        foreach($this->_list as $currentPerson)
        {
            if($currentPerson->getId() == $id)
            {
                return $currentPerson;
            }
        }

        return null;
    }
}