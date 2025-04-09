<?php

class Marketplace {
    use Controller;

    public function index($a = '', $b = '', $c = '') {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id'])) {
            header("Location: " . URLROOT . "/unauthorized");
            exit();
        }

        // Create the SHarvest model object
        $harvestModel = new SHarvest();
        $harvests = $harvestModel->getAllHarvests(); // fetch harvest listings

        // Pass data to the view
        $this->view('marketplace', ['harvests' => $harvests]);
    }
}
