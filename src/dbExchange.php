<?php
abstract class SQLHandleClass 
{
    protected $conn;

    public function __construct($db) 
	{
        $this->conn = $db;
    }

    abstract public function getData(...$args);
}

abstract class SQLSpecialHandleClass extends SQLHandleClass
{
	private const ALLOWED_STRINGS = ['USD', 'BYN'];
	
	private function isValidNumber($str) 
	{
        return preg_match('/^[0-9]+(\.[0-9]+)?$/', $str);
    }
	
	protected function validateArgs(...$args) 
	{
        foreach ($args as $arg) 
		{
            if (is_int($arg) || is_float($arg)) 
			{
                continue;
            } elseif (is_string($arg)) 
			{
                if (!in_array($arg, self::ALLOWED_STRINGS) && !$this->isValidNumber($arg)) 
				{
                    return false;
                }
            } else 
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

class MenuPizza extends SQLHandleClass 
{
    public function getData(...$args) 
	{
        $tables = ["good_pizza", "good_sauces", "good_size"];
        $result = [];

        foreach ($tables as $table) {
            $query = "SELECT * FROM " . $table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return json_encode($result);
    }
}

class MenuCalculator extends SQLSpecialHandleClass 
{		
    public function getData(...$args)
	{			
		if (!$this->validateArgs(...$args)) 
		{
            return json_encode(['message' => 'Invalid item IDs']);
        }
	
        $pizza = $this->getItem('good_pizza', $args[0], 'price');
        $size = $this->getItem('good_size', $args[1], 'coefficient');
        $sauce = $this->getItem('good_sauces', $args[2], 'price');

        if ($pizza && $size && $sauce) 
		{
            $price = ($pizza['price'] * $size['coefficient']) + $sauce['price'];
            return json_encode(['price' => $price]);
        } else 
		{
            return json_encode(['message' => 'Invalid item IDs']);
        }
    }    
}

class OrderChecker extends SQLSpecialHandleClass 
{
	private const EXCHANGE_RATE_URL = 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2';
	
    public function getData(...$args)
	{
		if (!$this->validateArgs(...$args)) 
		{
            return json_encode(['message' => 'Invalid item IDs']);
        }
		
        $pizza = $this->getItem('good_pizza', $args[0], 'price');
        $size = $this->getItem('good_size', $args[1], 'coefficient');				
        $sauce = $this->getItem('good_sauces', $args[2], 'price');
		$prePrice = $args[3];
		$currency = $args[4];
		
        if ($pizza && $size && $sauce) 
		{
			$calculatedPrice = ($pizza['price'] * $size['coefficient']) + $sauce['price'];
			if ($currency == 'BYN')
			{
				$exchangeRate = $this->getExchangeRate();
                $calculatedPrice = $calculatedPrice * $exchangeRate;
			}
            if (abs($calculatedPrice - $prePrice) < 0.01) 
			{
                return json_encode(['status' => 'OK']);
            } else 
			{
                return json_encode(['status' => $calculatedPrice]);
            }
        } else 
		{
            return json_encode(['status' => $calculatedPrice]);
        }
    }
	
	private function getExchangeRate() 
    {
        $response = file_get_contents(self::EXCHANGE_RATE_URL);
        $data = json_decode($response, true);
        return $data['Cur_OfficialRate'];
    }
}

?>