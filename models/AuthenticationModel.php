<?php

namespace app\models;

use app\core\DatabaseConnection;
use app\core\Model;
use \PDO;

class AuthenticationModel extends Model {

    public string $email;
    public string $password;
    //public string $phone_number

    public function rules(): array {
        return [
            "email" => [self::RULE_EMAIL, self::RULE_EMAIL_UNIQUE],
            "password" => [self::RULE_REQUIRED],
           // "phone_number" => [self::RULE_REQUIRED]
        ];
    }

    public function registration(AuthenticationModel $model) {
        //hesiraj password pre upisa u bazu
        $model->password = password_hash($model->password, PASSWORD_DEFAULT);

        $date = date('Y-m-d H-i-s');
        //dodaj korisnika u bazu
        $model->insert();

        //uzmi id role user
        $query = "SELECT id FROM role WHERE name = 'user';";
        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $success = $prepare->execute();
        $role_id = 0;
        if ($success) {
            $role = $prepare->fetch(PDO::FETCH_ASSOC);
            $role_id = $role["id"];
        }

        //uzmi id usera za koga dodajemo role
        $query = "SELECT id FROM user WHERE email = '$model->email';";
        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $success = $prepare->execute();
        $user_id = 0;
        if ($success) {
            $user = $prepare->fetch(PDO::FETCH_ASSOC);
            $user_id = $user['id'];
        }

        //dodaj rolu user za novog usera
        $query = "INSERT INTO users_roles (user_id, role_id, active, created_at, updated_at, user_created_id, user_updated_id, valid_from, valid_to) 
                  VALUES ($user_id, $role_id, true, '$date', '$date', 1, 1, '$date', '2025-01-01 12-00-00');";
        $success = DatabaseConnection::getConnection()->prepare($query)->execute();
        return $success;
    }

    public function login(AuthenticationModel $model) {
        $modelFromDB = new AuthenticationModel();
        $modelFromDB->loadData($modelFromDB->getOne("email = '$model->email'"));
        if (isset($modelFromDB->email)) {
            if (password_verify($model->password, $modelFromDB->password)) {
                return true;
            }
        }
        return false;
    }

    public function tableName(): string {
        return 'user';
    }

    public function attributes(): array {
        return [
            "email",
            "password",
 //           "phone_number",
            "created_at",
            "updated_at",
            "user_created_id",
            "user_updated_id",
            "active"
        ];
    }

    public function attributesForUpdate(): array {
        return [
            "password",
 //           "phone_number", //??
            "updated_at",
            "user_updated_id",
            "active"
        ];
    }
}