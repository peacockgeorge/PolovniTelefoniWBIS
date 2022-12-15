<?php

namespace app\models;

use app\core\DatabaseConnection;
use app\core\Model;
use \PDO;

class AdModel extends Model {

    public $number_of_rows;
    public $page_number;
    public $start_on;
    public $search;

    public function getAds() {
        $this->number_of_rows = 10;
        $this->start_on =  $this->page_number *  $this->number_of_rows;

        if ($this->search != null or $this->search != "") {
            $query = "
                SELECT  ad.name,
                        ad.description,
                        ad.price,
                        ad.image,
                        brand.name AS brand,
                        user.forename,
                        user.surname,
                        user.phone_number,
                        ad.expires_at
                FROM  ad
                INNER JOIN brand ON ad.brand_id = brand.id
                INNER JOIN user on ad.user_created_id = user.id              
                WHERE (ad.active = 1) AND (ad.name LIKE '%$this->search%' OR brand.name LIKE '%$this->search%');";
        }
        else {
            $query = "
               SELECT   ad.name,
                        ad.description,
                        ad.price,
                        ad.image,
                        brand.name AS brand,
                        user.forename,
                        user.surname,
                        user.phone_number,
                        ad.expires_at
                FROM  ad
                INNER JOIN brand on ad.brand_id = brand.id                
                INNER JOIN user on ad.user_created_id = user.id                 
                WHERE (ad.active = 1) AND (ad.name LIKE '%$this->search%' OR brand.name LIKE '%$this->search%')
                LIMIT $this->start_on, $this->number_of_rows;";
        }
        
        $prep = DatabaseConnection::getConnection()->prepare($query);
        $success = $prep->execute();
        if ($success) {
            $resultArray = [];
            while ($result = $prep->fetch(PDO::FETCH_ASSOC)) {
                array_push($resultArray, $result);
            }
        }
        return $resultArray;
    }

    public function rules(): array {
        return [];
    }

    public function tableName() : string {
        return "ad";
    }

    public function attributes(): array {
        return [];
    }

    public function attributesForUpdate(): array {
        return [];
    }
}
