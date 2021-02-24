// url where all requests hit
const url = "src/interface.php";
var uploadedFile;

// display selected stocks, after every select
const stockSelector = document.querySelector('#stock-multi-select');
stockSelector.addEventListener('change', function() {
    stockList = document.querySelector('#stock-selector-view');
    
    selectedStocks = [];
    for (var i = 0; i < this.options.length; i++) {
        if (this.options[i].selected) {
            selectedStocks.push(this.options[i].value);
        }
    }

    stockList.innerHTML = selectedStocks.join();
    stockList.style.display = "block";
    
});

// handle form submission and display status of stocks
const form = document.querySelector('#form');
form.addEventListener('submit', e => {

    e.preventDefault();

    var stocks = document.querySelector('#stock-selector-view');
    var dateRangeFrom = document.querySelector('#date-range-from').value;
    var dateRangeTo = document.querySelector('#date-range-to').value;

    this.validateFormInput(stocks.innerHTML, dateRangeFrom, dateRangeTo);
    
    var formData = new FormData();
    formData.append('file', uploadedFile);
    formData.append('stock_names', stocks.innerHTML);
    formData.append('date_range_from', dateRangeFrom);
    formData.append('date_range_to', dateRangeTo);
    formData.append('controller', 'stocks');
    formData.append('action', 'findMyDeal');

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(this.responseText);
            populateResult(result);
            stocks.innerHTML = "";
            form.reset();
        }
    };

    xhr.open('POST', url);
    xhr.send(formData);
});
 
// upload stock input file to server   
const fileInput = document.querySelector('#input-csv');
fileInput.addEventListener('change', e => {
    e.preventDefault();

    var files = fileInput.files;

    formData = new FormData();
    formData.append('input_csv', files[0]);
    formData.append('controller', 'stocks');
    formData.append('action', 'getAvailableStocks');

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(this.responseText);
            uploadedFile = result['uploaded_file'];

            stockChooser = document.querySelector('#stock-multi-select');
            var resultTableElement = document.querySelector('#result-table');
            for (var stockIndex in result['applicable_stocks']) {
                element = document.createElement('option');
                elementValue = document.createTextNode(result['applicable_stocks'][stockIndex]);
                element.value = result['applicable_stocks'][stockIndex]
                element.appendChild(elementValue);
                stockChooser.appendChild(element);
            }

            while(resultTableElement.hasChildNodes())
            {
               resultTableElement.removeChild(resultTableElement.firstChild);
            }

            mainForm = document.querySelector('#main-form');
            mainForm.style.display = "block";
        }
    };

    xhr.open('POST', url);
    xhr.send(formData);
});

// function to populate server response into a UI-friendly table
function populateResult(result) {
    var resultTable = document.querySelector('#result-table');
    var resultTableContainer = document.querySelector('#result-table-container');

    resultTableContainer.style.display = "block";
    if (result.length == 0) {
        this.appendElement('span', "You don't have any matching stocks in the given time period", resultTableContainer);

        return;
    }
    headerRow = document.createElement("tr");

    this.appendElement('th', "Name", headerRow);
    this.appendElement('th', "Profit", headerRow);
    this.appendElement('th', "Buying Date", headerRow);
    this.appendElement('th', "Selling Date", headerRow);
    this.appendElement('th', "Mean Stock Price", headerRow);

    resultTable.appendChild(headerRow);

    var isTopStock = true;
    for (var stockIndex in result) {
        var row = document.createElement("tr");
        if (isTopStock && result.length > 1) {
            row.classList.add('best-stock');
            isTopStock = false;
        }

        this.appendElement('td', result[stockIndex]['name'], row);
        this.appendElement('td', (result[stockIndex]['profit'] * 200), row);
        this.appendElement('td', result[stockIndex]['buy_date'], row);
        this.appendElement('td', result[stockIndex]['sell_date'], row);
        this.appendElement('td', Math.round(result[stockIndex]['total_price']/result[stockIndex]['total_stocks'], 2), row);

        resultTable.appendChild(row);
    }
}
    
// function to validate form input
function validateFormInput(stocks, dateRangeFrom, dateRangeTo)
{
    if (stocks == "") {
        alert("Choose atleast 1 stock to proceed");
    }

    if (dateRangeFrom == "" || dateRangeTo == "") {
        alert("Choose date range to proceed");   
    }

    fromDate = new Date(dateRangeFrom);
    toDate = new Date(dateRangeTo);
    if (fromDate > toDate) {
        alert("From date should be lesser than to date");
    }
}

// function to create and append a DOM element
function appendElement(element, value, parent)
{
    element = document.createElement(element);
    elementValue = document.createTextNode(value);
    element.appendChild(elementValue);

    parent.appendChild(element);
}