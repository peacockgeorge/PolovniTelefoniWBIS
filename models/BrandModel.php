<?php

namespace app\models;

use app\core\Model;

class BrandModel extends Model
{

    public function rules(): array {
        return [];
    }

    public function tableName() : string {
        return "brand";
    }

    public function attributes(): array {
        return [];
    }

    public function attributesForUpdate(): array {
        return [];
    }
}