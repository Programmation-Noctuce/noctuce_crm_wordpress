<?php
class Noctuce_CRM_Contact
{
    private $_id;
    
    private $_employee;

    function __construct()
    {
    }

    public function init()
    {        
    }

    public function initFromRow($row, $employee)
    {
        if(gettype($employee) != "object" ||
            get_class($employee) != "Noctuce_CRM_Employee")
        die("Noctuce_CRM_Contact initFromRow require Noctuce_CRM_Employee");        

        $this->_id = $row["id"];
        $this->_employee = $employee;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getEmployee()
    {
        return $this->_employee;
    }
}