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

    public function findBestStock($uploadedFile, $stockNames, $fromDate, $toDate)
    {
        $stockCsvHandle = fopen($uploadedFile, 'r');

        $applicableStocks = $this->getApplicableStocks($stockNames, $stockCsvHandle, $fromDate, $toDate);

        $stockResults = [];
        foreach ($applicableStocks as $stockName => $trend) {
            $stockResults[$stockName]['max_diff'] = 0;

            for ($x = 0; $x < count($trend)-1; $x++) {
                for ($y = ($x+1); $y < count($trend); $y++) {
                    $diff = $trend[$y]['price'] - $trend[$x]['price'];
                    if ($diff > $stockResults[$stockName]['max_diff']) {
                        $stockResults[$stockName]['max_diff'] = $diff;
                        $stockResults[$stockName]['buy_date'] = $trend[$x]['date'];
                        $stockResults[$stockName]['sell_date'] = $trend[$y]['date'];
                    }
                }
                $stockResults[$stockName]['total_price'] += $trend[$x]['price'];
            }
            $stockResults[$stockName]['total_stocks'] = count($trend);
            // $stockResults[$stockName]['standard_deviation'] = stats_standard_deviation(array_column($trend, 'price'));
        }

        return $stockResults['AAPL'];
    }

    private function getApplicableStocks($stockNames, $stockCsvHandle, $fromDate, $toDate)
    {
        $allHeaders = array_flip(fgetcsv($stockCsvHandle));

        $stocksArray = explode(',', $stockNames);
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
