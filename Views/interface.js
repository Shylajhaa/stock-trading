const url = "src/interface.php";
const form = document.querySelector('#form');

form.addEventListener('submit', e => {

    e.preventDefault();

    files = document.querySelector('#input-csv').files;
    stocks = document.querySelector('#stock-names').value;
    dateRangeFrom = document.querySelector('#date-range-from').value;
    dateRangeTo = document.querySelector('#date-range-to').value;
    
    formData = new FormData();
    formData.append('input_csv', files[0]);
    formData.append('stock_names', stocks);
    formData.append('date_range_from', dateRangeFrom);
    formData.append('date_range_to', dateRangeTo);
    formData.append('controller', 'stocks');
    formData.append('action', 'findMyDeal');

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
        }
    };

    xhr.open('POST', url);
    xhr.send(formData);
});