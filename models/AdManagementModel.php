<?php

namespace app\models;

use app\core\DatabaseConnection;
use app\core\Model;

class AdManagementModel extends Model {

    public $name;
    public $description;
    public $image;
    public $brand_id;
    public $expires_at;
    public $price;

    public function rules(): array {
        return [
            "name" => [self::RULE_REQUIRED],
            "description" => [self::RULE_REQUIRED],
            "brand_id" => [self::RULE_REQUIRED],
            "price" => [self::RULE_REQUIRED],
            "image" => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string {
        return "ad";
    }

    public function attributes(): array {
        return [
            "image",
            "created_at",
            "updated_at",
            "user_created_id",
            "user_updated_id",
            "active",
            "expires_at",
            "brand_id",
            "price",
            "description",
            "name"
        ];
    }

    public function attributesForUpdate(): array {
        return [
            "image",
            "updated_at",
            "user_updated_id",
            "active",
            "price",
            "description",
            "expires_at"
        ];
    }

    public function createAd(AdManagementModel &$model) {
        $model->expires_at = date('Y-m-d H-i-s', strtotime("+30 Days"));
        if ($model->insert()) {
            $id = DatabaseConnection::getConnection()->lastInsertId();
            $target_file = "images/" . $id . "." . strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
            $moved = move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../public/" . $target_file);
            if (!$moved) {
                return false;
            }
            $model->image = $target_file;
            $model->update("id = $id");
            return true;
        }
        return false;
    }
}