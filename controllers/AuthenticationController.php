<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\AuthenticationModel;
use app\models\LoggedInUserModel;

class AuthenticationController extends Controller {

    //dozvoljava neulogovanim korisnicima da pristupe stranicama za login i regisrtraciju
    public function authorize(): array {
        return ["guest"];
    }

    //posalji korisnika na view sa 403 access denied porukom
    public function accessDenied() {
        // return $this->router->view("accessDenied", "error");
        return $this->router->view("Authentication/login", "error");
    }

    //posalji korisnika na view sa 404 not found porukom
    public function notFound() {
        http_response_code(404);
        return $this->router->view("notFound", "error");
    }

    //metoda za generisanje view-a sa login formom
    public function login() {
        if (Application::getApp()->getSession()->get("logged_in_user")) {
            $this->router->redirect("home");
        }
        return $this->router->view("Authentication/login", "auth");
    }

    //metoda za obradu login forme
    public function loginProcess() {
            $model = new AuthenticationModel();
            $model->loadData($this->request->getAll());
            $model->validate();
            if (isset($model->errors)) {
                Application::getApp()->getSession()->setFlash("error", "Login failed!");
                return $this->router->view("Authentication/login", "auth", $model);
            }
            if (!$model->login($model)) {
                Application::getApp()->getSession()->setFlash("error", "Login failed!");
                return $this->router->view("Authentication/login", "auth", $model);
            }
            $logedInUserModel = new LoggedInUserModel();
            Application::getApp()->getSession()->set("logged_in_user", $logedInUserModel->getUser($model->email));
            $this->router->redirect("home");
    }


    //metoda za generisanje view-a sa formom za registraciju
    public function registration() {
        return $this->router->view($this->getPathToView(), "auth");
    }

    //metoda za obradu registracione forme i kreiranje novog usera
    public function registrationProcess() {
       $model = new AuthenticationModel();
       //inicijalizuj atribute modela usera sa podacima sa forme
       $model->loadData($this->request->getAll());

       //proveriti ovde da li user sa tim email-om vec postoji
        //da baza ne vraca gresku i ispisi poruku na viewu
       $model->validate();

       //ako nije prosla validacija
       if(isset($model->errors)) {
           Application::getApp()->getSession()->setFlash("error", "Registration failed!");
           return $this->router->view("Authentication/registration", "auth", $model);
       }

       //upis usera u bazu
       $model->registration($model);
       Application::getApp()->getSession()->setFlash("success", "Registration completed!");
       //ovde bi trebalo da stoji redirect na home screen
       return $this->router->view("Authentication/registration", "auth", $model);
    }

    public function logout() {
        if (Application::getApp()->getSession()->get("logged_in_user")) {
            Application::getApp()->getSession()->remove("logged_in_user");
        }
        $this->router->redirect("login");
    }

}