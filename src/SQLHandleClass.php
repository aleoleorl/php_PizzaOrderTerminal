<?php
require_once 'DBHandle.php';

abstract class SQLHandleClass 
{
    protected $conn;

    public function __construct()
	{
		$database = new Database();
        $this->conn = $database->getConnection();
    }

    abstract public function getData($arg0 = null, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null);
}
?>