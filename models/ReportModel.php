<?php

namespace app\models;

use app\core\DatabaseConnection;
use app\core\Model;
use \PDO;

class ReportModel extends Model {

    public $date_from;
    public $date_to;

    public function numberOfAds(ReportModel $model): array {
        $resultArray = [];

        //kreiranje upita

        //ako korisnik nije uneo filtere za datum
        if ($model->date_from == '' or $model->date_to == '') {
            $query = "SELECT MONTHNAME(created_at) as 'month_name', count(id) as 'number_of_ads'
                      FROM ad 
                      WHERE created_at BETWEEN (NOW() - INTERVAL 7 MONTH) AND NOW() 
                      GROUP BY MONTHNAME(created_at);";
        }
        //ako je korisnik uneo filter za datum
        else {
            $query = "SELECT MONTHNAME(created_at) as 'month_name', count(id) as 'number_of_ads' 
                      FROM ad
                      WHERE created_at BETWEEN '$model->date_from' AND '$model->date_to' 
                      GROUP BY MONTHNAME(created_at);";
        }

        $prep = DatabaseConnection::getConnection()->prepare($query);
        $success = $prep->execute();

        if ($success) {
            $resultArray = $prep->fetchAll(PDO::FETCH_OBJ);
        }
        return $resultArray;
    }

    //pie chart
    public function brands(ReportModel $model): array {
        $resultArray = [];

        if ($model->date_from == '' or $model->date_to == '') {
            $query = "SELECT count(ad.id) as 'num_of_brands',  brand.name 
                      FROM ad
                      INNER JOIN brand on ad.brand_id = brand.id
                      WHERE ad.created_at BETWEEN (NOW() - INTERVAL 7 MONTH) AND NOW()
                      GROUP BY brand.name;";
        } else {
            $query = "SELECT count(ad.id) as 'num_of_brands',  brand.name 
                      FROM ad
                      INNER JOIN brand on ad.brand_id = brand.id
                      WHERE ad.created_at BETWEEN '$model->date_from' AND '$model->date_to'
                      GROUP BY brand.name;";
        }

        $prep = DatabaseConnection::getConnection()->prepare($query);
        $success = $prep->execute();
        if ($success) {
            $resultArray = $prep->fetchAll(PDO::FETCH_OBJ);
        }
        return $resultArray;
    }

    //grouped bar chart
    public function adsPerBrand(ReportModel $model): array {
        $apiArray = [];
        $apiArray['labels'] = [];
        $apiArray['datasets'] = [];

        //uzmi sve brendove i baze, trebace nam njihov ukupan broj i nazivi
        $brands = [];
        $query = "SELECT brand.name, brand.id
                  FROM brand;";
        $prep = DatabaseConnection::getConnection()->prepare($query);
        $success = $prep->execute();
        if ($success) {
            $brands = $prep->fetchAll(PDO::FETCH_ASSOC);
        }

        //ako korisnik nije koristio filter za datume, defalt je period od 3 meseca u nazad
        if ($model->date_from == '' || $model->date_to == '') {
            $model->date_to = date('F-Y');
            $model->date_from = date('F-Y', strtotime(date('F-Y') . "-3 Months"));
        }

        //racunamo razliku dva datuma
        //TODO: ako je razlika negativna da se ispise greska na view-u
        $ts1 = strtotime($model->date_from);
        $ts2 = strtotime($model->date_to);
        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);
        $month1 = date('n', $ts1);
        $month2 = date('n', $ts2);
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        //formira se deo upita koji ide u WHERE deo
        //vrsice se ispitvanje za svaki mesec u intervalu
        $sqlString = "(";
        for ($i = 1; $i <= $diff; $i++) {
            $sqlSubstring = "(MONTH(ad.created_at) = ";
            $sqlSubstring .= date('m', strtotime( $model->date_from . "+$i Months"));
            $sqlSubstring .= " AND YEAR(ad.created_at) = ";
            $sqlSubstring .= date('Y', strtotime( $model->date_from . "+$i Months"));
            $sqlSubstring .= ") OR ";
            $sqlString .= $sqlSubstring;
            array_push($apiArray['labels'], date('F-Y', strtotime( $model->date_from . "+$i Months")));
        }
        $sqlString = substr_replace($sqlString, ")", -4);

        $resultArray = [];
        //za svaki brend cemo pozvati upit koji vraca broj oglasa tog brenda za svaki mesec iz intervala
        //TODO: verujem da se ovo moze uraditi mnogo bolje u samoj bazi? Napraviti view i funkciju koja vrti taj view u petlji
        foreach($brands as $brand) {
            $resultArrayEntry = [];
            $resultArrayEntry['name'] = $brand['name'];
            $query = "SELECT YEAR(ad.created_at) AS 'year', MONTH(ad.created_at) as 'month', COUNT(ad.id) as 'number_of_ads'
                      FROM brand
                      INNER JOIN ad on brand.id = ad.brand_id
                      WHERE ad.brand_id = " . $brand['id'] . " AND " . $sqlString .
                     " GROUP BY YEAR(ad.created_at), MONTH(ad.created_at)
                      ORDER BY YEAR(ad.created_at), MONTH(ad.created_at);";
            $prep = DatabaseConnection::getConnection()->prepare($query);
            $success = $prep->execute();
            if ($success) {
                $resultArrayEntry['dataset'] = $prep->fetchAll(PDO::FETCH_ASSOC);
                array_push( $resultArray, $resultArrayEntry );
            }
        }
        //na kraju ove petlje imamo niz koji se sastoji iz elemenata npr
        //{name: Samsung dataset: [{year:2021, month:November, number_of_ads: 2}, {year: 2021, month: December, number_of_ads: 1}],
        //{name: Motorola dataset: [{year:2021, month:November, number_of_ads: 10}, {year: 2021, month: December, number_of_ads: 30}],

        //sada taj niz moramo da formatiramo na nacin koji odgovara za prikaz u chartu
        //primer tog konacnog niza:
        //{"labels":["October-2021","November-2021","December-2021"],
        //"datasets":[{"label":"Motorola", "data":["0","1","0"],"backgroundColor":["#94549D","#94549D","#94549D"]},
        //            {"label":"Samsung","data":["0","2","0"],"backgroundColor":["#B140C4","#B140C4","#B140C4"]},
        //            {"label":"Sony","data":["1","1","0"],"backgroundColor":["#619820","#619820","#619820"]}
        //          ]}
        foreach($resultArray as $resultEntry) {
            $apiEntry = [];
            $apiEntry['label'] = [];
            $apiEntry['data'] = [];
            $apiEntry['backgroundColor'] = [];

            $apiEntry['label'] = $resultEntry['name'];

            //generici boju koji ce koristiti bar za taj brend
            for($i = 0; $i <= 1000; $i++) {
                $random_color = '#' . substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
            }

            //za svaki mesec u intervalu
            for ($i = 1; $i <= $diff; $i++) {
                //dodaj boju
                array_push($apiEntry['backgroundColor'], $random_color);
                //ako postoje podaci za taj mesec, unesi ih, ako ih nema, upisi 0
                if (!$this->foundMonthAndPushedData($resultEntry, $apiEntry, $model, $i )) {
                    array_push($apiEntry['data'], "0");
                }
            }
            array_push($apiArray['datasets'], $apiEntry);
        }

        return $apiArray;
    }

    private function foundMonthAndPushedData(&$resultEntry, &$apiEntry, &$model, $i): bool {
        foreach($resultEntry['dataset'] as $resultData) {
            $year1 = $resultData['year'];
            $month1 = $resultData['month'];
            $year2 = date('Y', strtotime( $model->date_from . "+$i Months"));
            $month2 = date('n', strtotime( $model->date_from . "+$i Months"));
            $diff2 = (($year2 - $year1) * 12) + ($month2 - $month1);
            if ($diff2 == 0) {
                array_push($apiEntry['data'] , $resultData['number_of_ads']);
                return true;
            }
        }
        return false;
    }

    public function rules(): array {
        return [];
    }

    public function tableName(): string {
        return "";
    }

    public function attributes(): array {
        return [];
    }

    public function attributesForUpdate(): array {
        return [];
    }

}
