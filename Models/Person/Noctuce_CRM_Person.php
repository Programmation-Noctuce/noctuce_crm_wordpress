<?php
class Noctuce_CRM_Person
{
    private $_id;
    private $_name;
    private $_personType;
    private $_personEmailList;
    private $_personAddressList;

    function __construct()
    {
    }

    public function init()
    {        
    }

    public function initFromRow($row, $personType)
    {
        if(gettype($personType) != "object" ||
            get_class($personType) != "Noctuce_CRM_PersonType")
        die("Noctuce_CRM_Entreprise initFromRow require Noctuce_CRM_PersonType");        

        $this->_id = $row["id"];
        $this->_name = $row["name"];
        $this->_personType = $personType;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getName()
    {
        return $this->_name;
    }
    public function getPersonType()
    {
        return $this->_personType;
    }
    public function getEmailList()
    {
        return $this->_personEmailList;
    }
    public function getAddressList()
    {
        return $this->_personAddressList;
    }
}