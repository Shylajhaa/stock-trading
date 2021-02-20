<!DOCTYPE html>
<html>
<head>
    <title>Know Your Stocks</title>
</head>
<body>
    <form method="POST" id="form" enctype="multipart/form-data">
        <input id="stock-names" type="text" name="stock-names">
        <br>
        <input id="date-range-from" type="date" name="date-range">
        <br>
        <input id="date-range-to" type="date" name="date-range">
        <br>
        <input id="input-csv" type="file" name="input-csv"/>
        <a href="localhost/stock-trading/Files/sample_stock_prices.csv">View Sample File</a>
        <br>
        <p id="result">Result</p>
        <br>
        <button type="submit" role="button">Find my deal</button>
    </form>
</body>
<script type="text/javascript" src="Views/interface.js"></script>
</html>
