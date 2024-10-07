<?php
require_once 'SQLHandleClass.php';

class MenuPizza extends SQLHandleClass 
{
    public function getData($arg0 = null, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null) 
	{
        $tables = ["good_pizza", "good_sauces", "good_size"];
        $result = [];

        foreach ($tables as $table) 
		{
            $query = "SELECT * FROM " . $table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return json_encode($result);
    }
}
?>