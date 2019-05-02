<?php
class Noctuce_CRM_PersonType
{
    private $_id;
    private $_name;

    function __construct()
    {
    }

    public function init()
    {        
    }

    public function initFromRow($row)
    {
        $this->_id = $row["id"];
        $this->_name = $row["name"];
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getName()
    {
        return $this->_name;
    }
}