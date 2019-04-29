<?php
class Noctuce_CRM_Entreprise
{
    private $_id;
    
    private $_person;

    function __construct()
    {
    }

    public function init()
    {        
    }

    public function initFromRow($row, $person)
    {
        if(gettype($person) != "object" ||
            get_class($person) != "Noctuce_CRM_Person")
        die("Noctuce_CRM_Entreprise initFromRow require Noctuce_CRM_Person");        

        $this->_id = $row["id"];
        $this->_person = $person;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getPerson()
    {
        return $this->_person;
    }
}