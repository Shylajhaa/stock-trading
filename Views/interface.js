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

    var stocks = document.querySelector('#stock-selector-view').innerHTML;
    var dateRangeFrom = document.querySelector('#date-range-from').value;
    var dateRangeTo = document.querySelector('#date-range-to').value;
    
    var formData = new FormData();
    formData.append('stock_names', stocks);
    formData.append('date_range_from', dateRangeFrom);
    formData.append('date_range_to', dateRangeTo);
    formData.append('controller', 'stocks');
    formData.append('action', 'findMyDeal');

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(this.responseText);
            uploadedFile = result['uploaded_file'];
            populateResult(result['applicable_stocks']);
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
            var parsedResponse = JSON.parse(this.responseText);

            stockChooser = document.querySelector('#stock-multi-select');
            for (var stockIndex in parsedResponse) {
                element = document.createElement('option');
                elementValue = document.createTextNode(parsedResponse[stockIndex]);
                element.value = parsedResponse[stockIndex]
                element.appendChild(elementValue);
                stockChooser.appendChild(element);
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

    headerRow = document.createElement("tr");

    this.appendElement('th', "Name", headerRow);
    this.appendElement('th', "Profit", headerRow);
    this.appendElement('th', "Buying Date", headerRow);
    this.appendElement('th', "Selling Date", headerRow);

    resultTable.appendChild(headerRow);

    for (var stockIndex in result) {
        var row = document.createElement("tr");

        this.appendElement('td', result[stockIndex]['name'], row);
        this.appendElement('td', (result[stockIndex]['profit'] * 200), row);
        this.appendElement('td', result[stockIndex]['buy_date'], row);
        this.appendElement('td', result[stockIndex]['sell_date'], row);

        resultTable.appendChild(row);
    }

    resultTable.style.display = "block";
}

// function to create and append a DOM element
function appendElement(element, value, parent)
{
    element = document.createElement(element);
    elementValue = document.createTextNode(value);
    element.appendChild(elementValue);

    parent.appendChild(element);
}