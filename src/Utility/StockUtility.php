<?php

namespace App\Utility;

use App\Utility\Utility;

/**
 *
 */
class StockUtility
{
    public function __construct()
    {
        $this->Utility = new Utility();
    }

    /**
     * Finds the best stock with buy and sell date
     */
    public function findBestStock($uploadedFile, $stockNames, $fromDate, $toDate)
    {
        $stockCsvHandle = fopen($uploadedFile, 'r');
        $stocksArray = explode(',', $stockNames);

        $applicableStocks = $this->getApplicableStocks($stocksArray, $stockCsvHandle, $fromDate, $toDate);

        $stockResults = [];
        foreach ($applicableStocks as $stockName => $trend) {
            $stockResults[$stockName]['profit'] = 0;
            $stockResults[$stockName]['total_price'] = 0;

            for ($x = 0; $x < count($trend)-1; $x++) {
                for ($y = ($x+1); $y < count($trend); $y++) {
                    $diff = $trend[$y]['price'] - $trend[$x]['price'];
                    if ($diff > $stockResults[$stockName]['profit']) {
                        $stockResults[$stockName]['name'] = $stockName;
                        $stockResults[$stockName]['profit'] = $diff;
                        $stockResults[$stockName]['buy_date'] = $trend[$x]['date'];
                        $stockResults[$stockName]['sell_date'] = $trend[$y]['date'];
                    }
                }
                $stockResults[$stockName]['total_price'] += $trend[$x]['price'];
            }
            $stockResults[$stockName]['total_stocks'] = count($trend);
        }

        usort($stockResults, function ($stockResult1, $stockResult2) {
            return $stockResult1['profit'] < $stockResult2['profit'];
        });

        return $stockResults;
    }

    /**
     * Fetches the eligible stocks in the given conditions
     */
    private function getApplicableStocks($stocksArray, $stockCsvHandle, $fromDate, $toDate)
    {
        $allHeaders = array_flip(fgetcsv($stockCsvHandle));

        $applicableStocks = [];
        while (($csvRow = fgetcsv($stockCsvHandle)) != false) {
            if (in_array($csvRow[$allHeaders['stock_name']], $stocksArray)
                && $this->Utility->isDateInRange($fromDate, $toDate, $csvRow[$allHeaders['date']])
            ) {
                $stock = [
                    'date' => $csvRow[$allHeaders['date']],
                    'price' => $csvRow[$allHeaders['price']]
                ];

                $applicableStocks[$csvRow[$allHeaders['stock_name']]][] = $stock;
            }
        }

        return $applicableStocks;
    }
}
