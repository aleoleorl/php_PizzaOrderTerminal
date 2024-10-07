<?php
require_once 'SQLSpecialHandleClass.php';

class MenuCalculator extends SQLSpecialHandleClass 
{	
    public function getData($pizzaId = null, $sizeId = null, $sauceId = null, $arg3 = null, $arg4 = null)
	{			
		$args = [$pizzaId, $sizeId, $sauceId];
		if (!$this->validateArgs($args)) 
		{
            return json_encode(['message' => 'Invalid item IDs']);
        }
	
        $pizza = $this->getItem('good_pizza', $pizzaId, 'price');
        $size = $this->getItem('good_size', $sizeId, 'coefficient');
        $sauce = $this->getItem('good_sauces', $sauceId, 'price');

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
?>