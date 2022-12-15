<?php

namespace app\core;

use \PDO;

abstract class Model {

    //niz u kome cuvamo sve greske tokom validacije
    //kljucevi su nazivi atributa nasledjenog modela
    public array $errors;

    //zajednicki atributi za sve modele
    public int $id;
    public string $created_at;
    public string $updated_at;
    public int $user_created_id;
    public int $user_updated_id;
    public bool $active;

    //konstante koje cemo koristiti za validaciju podataka koje korisnik salje preko forme
    //u sustini pravila validacije
    public const RULE_EMAIL = "email";
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL_UNIQUE = "unique_email";

    public abstract function rules(): array;
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function attributesForUpdate(): array;

    //za inicijaliciju atributa modela preko podataka iz forme
    final public function loadData($data) {
        if ($data !== null && $data !== false) {
            foreach($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    final public function validate() {
        //cita asoc. niz gde su kljucevi string nazivi atributa za koje vrsimo validaciju
        //a vrednosti tih kljuceva su nizovi konstanti za pravila validacije definisane u Model
        //niz je definisan u nasledjenoj klasi a vraca ga funkcija rules()
        //mozda je bolje nazvati getRules()?
        foreach($this->rules() as $attribute => $rules) {
            //u $valueForAttribute ubacuje vrednost atributa pod nazivom koje je vrednot $attribute
            //npr korosnik unese email primer@primer.com
            //email = primer@primer.com
            //$attribute = email
            //$valueForAttribute = $this->email
            //$valueForAttribute = primer@primer.com
            $valueForAttribute = $this->{$attribute};
            //posto atribut moze imati vise pravila za validaciju prolazimo kroz sva pravila
            foreach($rules as $rule) {
                //ako atribut ima pravilo da je obavezan da bude zadat u formi
                //a nije upisan u formi,tj nema vrednost
                if ($rule === self::RULE_REQUIRED && !$valueForAttribute) {
                    //u niz gresaka pod kljucem naziva atributa upisi poruku o gresci
                    //atrubute sa malim slovima i _ menjamo da izgledaju normalno za lepsi prikaz
                    //phone_number -> Phone Number
                    $attributeParts = explode("_", $attribute);
                    $message = "";
                    foreach($attributeParts as $attributePart) $message .= ucwords($attributePart) . " ";
                    $message .= " is required!";
                    $this->errors[$attribute][] = $message;
                }
                //ako atribut ima pravilo da je ispravan email
                //a nije ispravno napisan na osnovu funkcije iz php-a
                if ($rule === self::RULE_EMAIL && !filter_var($valueForAttribute, FILTER_VALIDATE_EMAIL)) {
                    //u niz gresaka pod kljucem naziva atributa upisi poruku o gresci
                    $this->errors[$attribute][] = ucwords($attribute) . " must be written in valid email format!";
                }
                //provera da li vec imamo user sa emailom. Potrebno za registraciju
                if (debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'] != 'loginProcess' &&
                    $rule === self::RULE_EMAIL_UNIQUE
                    && $this->isEmailRegistered($valueForAttribute)) {
                    $this->errors[$attribute][] = "User with that  $attribute is already registered!";
                }
            }
        }
    }

    //provera da li imamo usera u bazi sa zadatim emailom
    public function isEmailRegistered(string $email): bool {
        $query= "SELECT * FROM user WHERE email = '$email'";
        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $prepare->execute();
        if ($prepare->rowCount()>0) {
            return true;
        }
        return false;
    }

    //upis atributa u bazu. Svaki model ce imati svoji implementaciju table_name i svoj set atributa
    //ova funkcija vrsi uopstavanje svih tih razlicitih upita
    public function insert(): bool {
        //u koju tabelu upisujemo
        $table_name = $this->tableName();

        //atributi specificni za konkrektni model
        $attributes = $this->attributes();
        //u deo upita VALUES nazive atributa pretvaramo u verziju sa :
        //npr email -> :email
        //da bi kasnija funkcija zamene delova stringova razlikovala te nazive
        //od naziva kolona
        $values = array_map(fn($attr) => ":$attr", $attributes);

        //inicijalizacija atributa koji su zajednicki za sve modele
        $this->created_at = date('Y-m-d H-i-s');
        $this->updated_at = date('Y-m-d H-i-s');
        $this->user_created_id = Application::getApp()->getSession()->get("logged_in_user")->id ?? 1;
        $this->user_updated_id = Application::getApp()->getSession()->get("logged_in_user")->id ?? 1;
        $this->active = true;

        //formira se uopsten upit koji svi modeli mogu izvrsiti
        //implode funkcija vraca string gde su svi $attributes razdvojeni znakom ,
        //npr za AuthenticationModel
        //INSERT INTO user (email, forename, surname...) VALUES (:email, :forename, :surname);
        $query = "INSERT INTO $table_name (" . implode(',', $attributes) . ") VALUES (" . implode(',', $values) . ")";
        //kao sto je gore receno ovde cemo delove stringova sa :$attribut zameniti konkretnim vrednostima
        //ako su u pitanju brojevi ili bool necemo stavljati navodnike oko njih
        //ako je string stavljamo navodnike
        foreach ($attributes as $attribute) {
            $query = str_replace(":$attribute", (is_numeric($this->{$attribute}) or is_bool($this->{$attribute})) ? $this->{$attribute} : '"' . $this->{$attribute} . '"', $query);
        }
        //izvrsi upit i vrati da li je uspesan
        //var_dump($query); exit;
        $success = DatabaseConnection::getConnection()->prepare($query)->execute();
        return $success;

    }

    public function update(string $condition = ""): bool {
        if (!isset(Application::getApp()->getSession()->get("logged_in_user")->id)) {
            return false;
        }
        $table_name = $this->tableName();
        $attributes = $this->attributesForUpdate();

        $this->updated_at = date('Y-m-d H-i-s');
        $this->user_updated_id = Application::getApp()->getSession()->get("logged_in_user")->id;

        $query = "UPDATE $table_name SET ";
        foreach ($attributes as $attribute) {
            $query .=  $attribute;
            $query .= " = ";
            $query .= (is_numeric($this->{$attribute}) or is_bool($this->{$attribute})) ?  $this->{$attribute} : '"' . $this->{$attribute} . '"';
            $query .= ", ";
        }
        $query = substr_replace($query, "", -2);

        if ($condition != "") $query .= " WHERE $condition";
        $query .= ";";
        return DatabaseConnection::getConnection()->prepare($query)->execute();
    }

    public function delete(string $condition): bool {
        $table_name = $this->tableName();
        $query = "DELETE FROM $table_name WHERE $condition";
        return DatabaseConnection::getConnection()->prepare($query)->execute();

    }

    public function getOne(string $condition) {
        $table_name = $this->tableName();
        $query = "SELECT * FROM $table_name WHERE $condition";
        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $success = $prepare->execute();
        $result = null;
        if ($success) {
            $result =  $prepare->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function getAll(string $condition = ""): array {
        if ($condition != "") $condition = " WHERE " . $condition;
        $table_name = $this->tableName();
        $query = "SELECT * FROM $table_name" . $condition;
        $prepare = DatabaseConnection::getConnection()->prepare($query);
        $result = [];
        if ($prepare->execute()) {
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}