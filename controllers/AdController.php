<?php

namespace app\controllers;

use app\core\Controller;
use app\models\AdModel;

class AdController extends Controller {

    public function home() {
        return $this->router->view("ad/home", "main");
    }

    public function getAds() {
        $model = new AdModel();
        $model->loadData($this->request->getAll());
        echo json_encode($model->getAds()); exit;
    }

    public function single() {
        return $this->router->view("ad/single", "main");
    }

    public function create() {
        return $this->router->view("ad/create", "main");
    }

    public function createProcess() {
        return $this->router->view("ad/create", "main");
    }

    public function edit() {
        return $this->router->view("ad/edit", "main");
    }

    public function editProcess() {
        return $this->router->view("ad/edit", "main");
    }

    public function delete() {
        return $this->router->view("ad/delete", "main");
    }

    public function deleteProcess() {
        return $this->router->view("ad/delete", "main");
    }

    public function authorize(): array {
        return [
            "guest"
        ];
    }
}