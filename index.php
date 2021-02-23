<!DOCTYPE html>
<html lang="en">
<head>
    <title>Know Your Stocks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="Views/main.css">
</head>
<body style="text-align: center;margin: auto;width: 50%;padding: 5%;">
    <div class="container">
        <form style="display: inline-block;" method="POST" id="form" enctype="multipart/form-data">
            <div class="container" style="border:3px solid #330c07;padding: 10%;border-radius: 10px">
                <div class="form-group">
                    <div class="row">
                        <label for="usr">Upload stock data:</label>
                    </div>
                    <div class="row">
                        <span>
                            <input id="input-csv" type="file" class="form-control-file" name="input-csv"/>
                        </span>
                    </div>
                    <br>
                    <div class="row">
                        <span>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <a href="Files/sample_stock_prices.csv">Download Sample File</a>
                            </button>
                        </span>
                    </div>
                </div>

                <div id="main-form" style="display: block;">
                    <div class="row">
                        <label>Select 1 or more stocks: </label>
                    </div>
                    <div class="row">
                        <span><p id="stock-selector-view" style="display: none;"></p></span>
                    </div>
                    <div class="row">
                        <span>
                            <select id="stock-multi-select" multiple="multiple">
                            </select>
                        </span>
                    </div>
                    <div class="row">
                        <label>Choose from date: </label>
                    </div>
                    <div class="row">
                        <span><input id="date-range-from" data-provide="datepicker" type="date" name="date-range"></span>
                    </div>
                    <div class="row">
                        <label>Choose to date: </label>
                    </div>
                    <div class="row">
                        <span><input id="date-range-to" type="date" name="date-range"></span>
                    </div>
                    <br>
                    <div class="row">
                        <span><button style="border-radius: 10px;" class="btn btn-primary" type="submit" role="button">Find my deal</button></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div>
        <table id="result-table" style="display: block;border: 3px solid #330c07;border-radius: 10px" class="table table-bordered">
        </table>
    </div>
</body>
<script type="text/javascript" src="Views/interface.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>