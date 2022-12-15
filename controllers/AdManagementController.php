<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Model;
use app\models\AdManagementModel;

class AdManagementController extends Controller {

    public function home() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function single() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function create() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function createProcess() {
        $model = new AdManagementModel();
        $model->loadData($this->request->getAll());
        $this->validateImage($model);
        $model->validate();
        if (isset($model->errors)) {
            Application::getApp()->getSession()->setFlash("error", "Ad creation failed!");
            return $this->router->view("AdManagement/create", "main", $model);
        }
        if (!$model->createAd($model)) {
            Application::getApp()->getSession()->setFlash("error", "Ad creation failed!");
            return $this->router->view("AdManagement/create", "main", $model);
        }

        Application::getApp()->getSession()->setFlash("success", "Ad created!");
        return $this->router->view("AdManagement/create", "main", null);
    }

    public function edit() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function editProcess() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function delete() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function deleteProcess() {
        return $this->router->view($this->getPathToView(), "main");
    }

    public function authorize(): array{
        return [
            "user",
            "admin"
        ];
    }

    private function validateImage(AdManagementModel &$model) {
        if (isset($_FILES)) {
            $model->image = "tempImageName";
            $file_name = basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check == false) {
                    $model->errors["image"][] = "File is not an image.";
                }
            }
            // Check file size
            if ($_FILES["image"]["size"] > 500000) {
                $model->errors["image"][] = "Sorry, your file is too large.";
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $model->errors["image"][] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        }
    }
}
