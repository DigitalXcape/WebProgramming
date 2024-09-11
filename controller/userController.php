<?php
require_once '../model/database.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = Database::getInstance();
    }

    public function showData() {
        return $this->model->getData();
    }
}
?>