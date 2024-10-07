<?php
require_once 'SQLHandleClass.php';

abstract class SQLSpecialHandleClass extends SQLHandleClass
{
	private const ALLOWED_STRINGS = ['USD', 'BYN'];
	
	private function isValidNumber($str) 
	{
        return preg_match('/^[0-9]+(\.[0-9]+)?$/', $str);
    }
	
	protected function validateArgs(array $args) 
	{
        foreach ($args as $arg) 
		{
            if (!is_string($arg) || 
			(!in_array($arg, self::ALLOWED_STRINGS) && !$this->isValidNumber($arg))) 
			{
                return false;
            }
        }
		return true;
	}
	
	protected function getItem($table, $id, $column) 
	{
        $query = "SELECT $column FROM " . $table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>