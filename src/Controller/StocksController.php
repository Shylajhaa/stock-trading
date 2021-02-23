<?php

namespace App\Controller;

use App\Utility\StockUtility;
use App\Utility\Utility;

/**
 *
 */
class StocksController
{
    /**
     * Initialises frequently used classes
     */
    public function __construct()
    {
        $this->Utility = new Utility();
        $this->StockUtility = new StockUtility();
    }

    /**
     * Finds the best deal from the given stocks
     * @return json response
     */
    public function findMyDeal()
    {
        $stockNames = $_POST['stock_names'];
        $dateRangeFrom = $_POST['date_range_from'];
        $dateRangeTo = $_POST['date_range_to'];
        $file = $_POST['file'];

        $result = $this->StockUtility->findBestStock($file, $stockNames, $dateRangeFrom, $dateRangeTo);

        echo json_encode($result);
    }

    /**
     * Uploads file to the server and returns the available list of stocks
     * @return json response
     */
    public function getAvailableStocks()
    {
        $uploadedFile = $this->Utility->uploadFile($_FILES["input_csv"]["tmp_name"]);
        if (!$uploadedFile) {
            echo "Failure";

            return;
        }

        $stockCsvHandle = fopen($uploadedFile, 'r');
        $allHeaders = array_flip(fgetcsv($stockCsvHandle));

        $applicableStocks = [];
        while (($csvRow = fgetcsv($stockCsvHandle)) != false) {
            $applicableStocks[$csvRow[$allHeaders['stock_name']]] = $csvRow[$allHeaders['stock_name']];
        }

        $response = [
            'applicable_stocks' => $applicableStocks,
            'uploaded_file' => $uploadedFile
        ];

        echo json_encode($response);
    }
}
