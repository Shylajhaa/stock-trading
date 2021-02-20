<?php

namespace App\Controller;

use App\Utility\StockUtility;
use App\Utility\Utility;

/**
 *
 */
class StocksController
{
    public function findMyDeal()
    {
        $stockNames = $_POST['stock_names'];
        $dateRangeFrom = $_POST['date_range_from'];
        $dateRangeTo = $_POST['date_range_to'];

        $utility = new Utility();
        $stockUtility = new StockUtility();

        $uploadedFile = $utility->uploadFile($_FILES["input_csv"]["tmp_name"]);
        if (!$uploadedFile) {
            throw new \Exception('Unable to upload file');
        }

        $result = $stockUtility->findBestStock($uploadedFile, $stockNames, $dateRangeFrom, $dateRangeTo);

        echo "Your best choice is to buy the stock on " . $result['buy_date'] . " and sell on " . $result['sell_date'] . " mean: " . ($result['total_price'] / $result['total_stocks']) . " profit: " . (200 * $result['max_diff']);
    }
}
