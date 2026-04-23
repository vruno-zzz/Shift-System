<?php
session_start();

require_once "../config/shiftsys.php";
require_once "../models/shifts.php";

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../controller/profileController.php");
    exit;
}

$shiftModel = new Shift($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_shift = $_POST['id_shift'] ?? null;
    $action   = $_POST['action'] ?? null;

    if (!$id_shift || !$action) {
        exit("Datos incompletos.");
    }

    if ($action === "accept") {
        $shiftModel->updateStatus($id_shift, "Aceptado");
    }

    if ($action === "reject") {
        $shiftModel->updateStatus($id_shift, "Rechazado");
    }
    header("Location: ../controller/profileController.php");
    exit;
}