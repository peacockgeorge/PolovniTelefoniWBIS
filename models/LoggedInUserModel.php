<?php

namespace app\models;

use app\core\Model;
use app\core\DatabaseConnection;
use \PDO;

class LoggedInUserModel extends Model {

    public $email;
    public $forename;
    public $surname;
    public $phone_number;
    public array $roles = [];

    public function getUser($email) {
        $query = "SELECT u.id, u.forename, u.surname, u.phone_number, u.email, r.name
                  FROM user u
                  INNER JOIN users_roles ur on u.id = ur.user_id
                  INNER JOIN `role` r on ur.role_id = r.id
                  WHERE u.email = '$email';";

        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $prepare->execute();
        while ($row = $prepare->fetch(PDO::FETCH_ASSOC)) {
            if ($this->email === null) {
                $this->loadData($row);
            }
            array_push($this->roles, $row["name"]);
        }

        return $this;
    }

    public function rules(): array{
        return [];
    }

    public function tableName(): string {
        return "users";
    }

    public function attributes(): array{
        return [];
    }

    public function attributesForUpdate(): array{
        return [];
    }
}