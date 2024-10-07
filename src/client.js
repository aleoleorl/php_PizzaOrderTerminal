var price = 0;
var exchangeRate = 1;
var pizzaImages = {};
var apiServerMenu = 'http://localhost/amasty/api/menu/index.php';
var apiServerCalcCost = 'http://localhost/amasty/api/calccost/index.php';
var apiServerCheckOrder = 'http://localhost/amasty/api/checkorder/index.php';
var apiServerImage = 'http://localhost/amasty/api/image/index.php';
var apiBank = 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2';

function getData()
{
	$.ajax(
	{
        url: apiServerMenu,
        type: 'GET',
        success: function(response) 
		{
            if (typeof response === "string") 
			{				
                try 
				{
                    response = JSON.parse(response);
                } catch (e) 
				{
                    console.error("Failed to parse JSON:", e);
                    return;
                }
            }
            makeDropdown('pizza', response.good_pizza, 'name');
            makeDropdown('size', response.good_size, 'desc');
            makeDropdown('sauce', response.good_sauces, 'name');
			
			updatePrice(response);
			
			response.good_pizza.forEach(function(pizza) 
			{
                if (pizza.image) 
				{
                    loadImage(pizza.image, function() 
					{
						getFirstImage(response);                        
                    });
                }
            });
			
			eventner(response);	
        },
        error: function(xhr, status, error) 
		{
            console.error('Error: ' + error);
        }
    });
}

function makeDropdown(id, data, key) 
{
    var dropdown = $('#' + id);
    dropdown.empty();
    $.each(data, function(index, item) 
	{
        dropdown.append($('<option></option>').attr('value', item.id).text(item[key]));
    });
}

function getFirstImage(data)
{
	var firstPizzaImage = data.good_pizza[0].image;
    if (pizzaImages[firstPizzaImage]) 
	{
        $('#pizza-image').attr('src', pizzaImages[firstPizzaImage]).show();
    } 
}

function loadImage(imageName, callback) 
{
    if (pizzaImages[imageName]) 
	{
		return;
	}
    $.ajax(
	{
        url: apiServerImage,
        type: 'GET',
        data: 
		{ 
			image: imageName 
		},
        success: function(response) 
		{
            pizzaImages[imageName] = response.imageUrl;
			if (callback) 
			{
				callback();
			}
        },
        error: function(xhr, status, error) 
		{
            console.error('Error loading image: ' + error);
        }
    });
    
}

function eventner(data) 
{
	$('#pizza, #size, #sauce, #currency').change(function() 
	{
        updatePrice(data);
    });
			
	$('#pizza').change(function() 
	{
        var selectedPizzaId = $(this).val();
        var selectedPizza = data.good_pizza.find(pizza => pizza.id == selectedPizzaId);
        if (selectedPizza && selectedPizza.image) 
		{
             $('#pizza-image').attr('src', pizzaImages[selectedPizza.image]).show();
        } else 
		{
            $('#pizza-image').hide();
        }
    });
}
	
function updatePrice(data) 
{
    var pizzaId = $('#pizza').val();
    var sizeId = $('#size').val();
    var sauceId = $('#sauce').val();
	var currency = $('#currency').val();
    $.ajax(
	{
        url: apiServerCalcCost,
        type: 'GET',
        data: 
		{
            pizzaId: pizzaId,
            sizeId: sizeId,
            sauceId: sauceId
        },
        success: function(response) 
		{
			price = response.price;
				
            if (currency === 'BYN') 
			{
                price = price * exchangeRate;
            }
            $('#price').text(price.toFixed(2) + ' ' + currency);
        },
        error: function(xhr, status, error) 
		{
            console.error('Error calculating price: ' + error);
            $('#price').text('Error calculating price');
        }
    });
}

function getExchangeRate()
{
	$.ajax(
	{
        url: apiBank,
        type: 'GET',
        success: function(response) 
		{
			exchangeRate = response.Cur_OfficialRate;
            $('#exchangeRate').text(response.Cur_OfficialRate);
        },
        error: function(xhr, status, error) 
		{
            console.error('Error fetching exchange rate: ' + error);
            $('#exchangeRate').text('Error fetching exchange rate');
        }
    });
}

function resultOrder(res)
{
	$('#overlay').hide();
	
	if (res === 'OK') 
	{
		var summary = 'Order success';
    } else 
	{
		var summary = 'There were some changes and this order can\'t be handle. Please order again.';
    }
	
	$('#summary').html(summary);	
	$('#summaryOverlay').show();	
	
	
	$('#closeSummaryOverlay').click(function() 
	{
		getData();
		getExchangeRate();
        $('#summaryOverlay').hide();
    });
}

function checkOrder()
{
	var pizzaId = $('#pizza').val();
    var sizeId = $('#size').val();
    var sauceId = $('#sauce').val();
    var prePrice = price;
	var currency = $('#currency').val();

    $.ajax(
	{
        url: apiServerCheckOrder,
        type: 'GET',
        data: 
		{
            pizzaId: pizzaId,
            sizeId: sizeId,
            sauceId: sauceId,
            prePrice: prePrice,
			currency: currency
        },
        success: function(response) 
		{		
			resultOrder(response.status);                
        },
        error: function(xhr, status, error) 
		{
            console.error('Error: ' + error);
            alert('Some issue with the Order checking');
        }
    });
}

function showSummary()
{
	$('#showDetails').click(function() 
	{
        var pizza = $('#pizza option:selected').text();
        var size = $('#size option:selected').text();
        var sauce = $('#sauce option:selected').text();
        var price = $('#price').text();

        var details = `
			<p>Order:</p>
            <p>Pizza: ${pizza}</p>
            <p>Size: ${size}</p>
            <p>Sauce: ${sauce}</p>
            <p>Price: ${price}</p>
        `;
        $('#details').html(details);
        $('#overlay').show();
    });

    $('#closeOverlay').click(function() 
	{
        $('#overlay').hide();
    });
	$('#checkOrder').click(function() 
	{
		checkOrder();
	});	
}

$(document).ready(function() 
{	
    getData();
	getExchangeRate();
	showSummary();
});