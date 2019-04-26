<?php
class Noctuce_CRM_Person
{
    private $_id;
    private $_name;
    private $_personEmailList;
    private $_personAddressList;

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
    public function getEmailList()
    {
        return $this->_personEmailList;
    }
    public function getAddressList()
    {
        return $this->_personAddressList;
    }
}