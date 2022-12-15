<?php

namespace app\controllers;

use app\core\Controller;
use app\models\ReportModel;

class ReportController  extends  Controller {

    public function numberOfAds() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function numberOfAdsProcess() {
        $model = new ReportModel();
        $model->loadData($this->request->getAll());

        echo json_encode($model->numberOfAds($model)); exit;
    }

    public function brands() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function brandsProcess() {
        $model = new ReportModel();
        $model->loadData($this->request->getAll());

        echo json_encode($model->brands($model)); exit;
    }

    public function adsPerBrand() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function adsPerBrandProcess() {
        $model = new ReportModel();
        $model->loadData($this->request->getAll());

        echo json_encode($model->adsPerBrand($model)); exit;
    }


    public function authorize(): array {
        return [
            "admin"
        ];
    }
}