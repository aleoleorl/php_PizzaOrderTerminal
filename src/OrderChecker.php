<?php
require_once 'SQLSpecialHandleClass.php';

class OrderChecker extends SQLSpecialHandleClass 
{
	private const EXCHANGE_RATE_URL = 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2';
	
    public function getData($pizzaId = null, $sizeId = null, $sauceId = null, $priceVal = null, $currencyVal = null)
	{
		$args = [$pizzaId, $sizeId, $sauceId, $priceVal, $currencyVal];
		if (!$this->validateArgs($args)) 
		{
            return json_encode(['message' => 'Invalid item IDs']);
        }
		
        $pizza = $this->getItem('good_pizza', $pizzaId, 'price');
        $size = $this->getItem('good_size', $sizeId, 'coefficient');				
        $sauce = $this->getItem('good_sauces', $sauceId, 'price');
		$prePrice = $priceVal;
		$currency = $currencyVal;
		
        if (!$pizza || !$size || !$sauce) 
		{
			return json_encode(['status' => $calculatedPrice]);
		}
		$calculatedPrice = ($pizza['price'] * $size['coefficient']) + $sauce['price'];
		if ($currency == 'BYN')
		{
			$exchangeRate = $this->getExchangeRate();
            $calculatedPrice = $calculatedPrice * $exchangeRate;
		}
        if (abs($calculatedPrice - $prePrice) < 0.01) 
		{
            return json_encode(['status' => 'OK']);
        }
        return json_encode(['status' => 'NOK']);
    }
	
	private function getExchangeRate() 
    {
        $response = file_get_contents(self::EXCHANGE_RATE_URL);
        $data = json_decode($response, true);
        return $data['Cur_OfficialRate'];
    }
}
?>