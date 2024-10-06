<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amasty</title>
	<link rel="stylesheet" href="styles/styles.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="src/client.php"></script>
</head>
<body>
	<div class="form-wrapper">
        <div class="form-container">
            <div class="top-right">
                <div>
                    <label for="exchangeRate">USD/BYN:</label>
                    <label id="exchangeRate"></label>
                </div>
                <div>
                    <label for="currency">Currency:</label>
                    <select id="currency">
                        <option value="USD">USD</option>
                        <option value="BYN">BYN</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="center">
                <label>Menu:</label>
            </div>
            <hr>
            <div>
                <label for="pizza">Pizza:</label>
                <select id="pizza"></select>
            </div>
            <div>
                <label for="size">Size:</label>
                <select id="size"></select>
            </div>
            <div>
                <label for="sauce">Sauce:</label>
                <select id="sauce"></select>
            </div>
            <hr>
            <div class="right">
                <label for="price">Price:</label>
                <label id="price"></label>
            </div>
            <hr>
            <button id="showDetails">order</button>
        </div>
    </div>	
    <div id="overlay">
        <div id="details"></div>
		<button id="checkOrder">Confirm Order</button>
        <button id="closeOverlay">Back</button>
    </div>
	<div id="summaryOverlay">
        <div id="summary"></div>
        <button id="closeSummaryOverlay">Done</button>
    </div>
</body>
</html>