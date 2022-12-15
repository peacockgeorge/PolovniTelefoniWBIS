<?php

namespace app\core;
use app\controllers\AuthenticationController;
use app\controllers\AdManagementController;
use app\controllers\SettingsController;
use app\controllers\AdController;
use app\controllers\ReportController;

//Singleton klasa jer nam treba samo jedna instanca klase
final class Application {

    private Router $router;
    private Session $session;
    private static Application $app;

    private function  __construct() {
        $this->router = new Router();
        $this->session = new Session();
        $this->loadRoutes();
    }

    public function run() {
        $this->router->resolve();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }


    public function getSession(): Session
    {
        return $this->session;
    }

    public static function &getApp(): Application {
        if (!isset(self::$app)) {
            self::$app = new Application();
        }
        return self::$app;
    }

    //inicijalizacija ruta
    private function loadRoutes() {
        $this->router->get("home", [AdController::class, "home"]);
        $this->router->get("", [AdController::class, "home"]);
        $this->router->get("index", [AdController::class, "home"]);
        $this->router->get("accessDenied", [AuthenticationController::class, "accessDenied"]);
        $this->router->get("notFound", [AuthenticationController::class, "notFound"]);
        $this->router->get("registration", [AuthenticationController::class, "registration"]);
        $this->router->post("registrationProcess", [AuthenticationController::class, "registrationProcess"]);
        $this->router->get("login", [AuthenticationController::class, "login"]);
        $this->router->post("loginProcess", [AuthenticationController::class, "loginProcess"]);
        $this->router->get("logout", [AuthenticationController::class, "logout"]);
        $this->router->get("admanagement/create", [AdManagementController::class, "create"]);
        $this->router->post("admanagement/createProcess", [AdManagementController::class, "createProcess"]);
        $this->router->get("api/brand/getall", [SettingsController::class, "getAll"]);
        $this->router->get("ad/home", [AdController::class, "home"]);
        $this->router->get("ad/getads", [AdController::class, "getAds"]);
        $this->router->get("report/numberOfAds", [ReportController::class, "numberOfAds"]);
        $this->router->get("report/numberOfAdsProcess", [ReportController::class, "numberOfAdsProcess"]);
        $this->router->get("report/brands", [ReportController::class, "brands"]);
        $this->router->get("report/brandsProcess", [ReportController::class, "brandsProcess"]);
        $this->router->get("report/adsPerBrand", [ReportController::class, "adsPerBrand"]);
        $this->router->get("report/adsPerBrandProcess", [ReportController::class, "adsPerBrandProcess"]);
    }


}