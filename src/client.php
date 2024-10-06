<?php
header("Content-Type: application/javascript");
?>

var price = 0;
var exchangeRate = 1;
var serverUrl = 'http://localhost/amasty/serverPoint.php';
var bankUrl = 'https://www.nbrb.by/api/exrates/rates/USD?parammode=2';

function getData()
{
	$.ajax(
	{
        url: serverUrl,
        type: 'GET',
        data: 
		{ 
			request: 'menu' 
		},
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
			
			$('#pizza, #size, #sauce, #currency').change(function() 
			{
                updatePrice(response);
            });
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
	
function updatePrice(data) 
{
    var pizzaId = $('#pizza').val();
    var sizeId = $('#size').val();
    var sauceId = $('#sauce').val();
	var currency = $('#currency').val();
    $.ajax(
	{
        url: serverUrl,
        type: 'GET',
        data: 
		{
            request: 'calccost',
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
        url: bankUrl,
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
        url: serverUrl,
        type: 'GET',
        data: 
		{
            request: 'checkorder',
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