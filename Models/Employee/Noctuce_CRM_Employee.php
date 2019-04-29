<?php
class Noctuce_CRM_Employee
{
    private $_id;
    
    private $_employeeRole;
    private $_entreprise;
    private $_person;

    function __construct()
    {
    }

    public function init()
    {        
    }

    public function initFromRow($row, $person, $entreprise, $employeeRole)
    {
        if(gettype($employeeRole) != "object" ||
            get_class($employeeRole) != "Noctuce_CRM_EmployeeRole")
        die("Noctuce_CRM_Employee initFromRow require Noctuce_CRM_EmployeeRole");

        if(gettype($entreprise) != "object" ||
            get_class($entreprise) != "Noctuce_CRM_Entreprise")
        die("Noctuce_CRM_Employee initFromRow require Noctuce_CRM_Entreprise");
        
        if(gettype($person) != "object" ||
            get_class($person) != "Noctuce_CRM_Person")
        die("Noctuce_CRM_Employee initFromRow require Noctuce_CRM_Person");
        
        $this->_id = $row["id"];
        $this->_employeeRole = $employeeRole;
        $this->_entreprise = $entreprise;
        $this->_person = $person;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getRole()
    {
        return $this->_employeeRole;
    }
    public function getEntreprise()
    {
        return $this->_entreprise;
    }
    public function getPerson()
    {
        return $this->_person;
    }
}