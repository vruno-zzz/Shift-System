<?php
session_start();

require_once "../config/shiftsys.php";
require_once "../models/shifts.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $day = $_POST['day'] ?? null;
    $hour = $_POST['hour'] ?? null;

    if (!$day || !$hour) {
        echo "Datos incompletos";
        exit;
    }

    try {

        $shift = new Shift($conn);
        $created = $shift->createShift($day, $hour);

        if ($created) {
            echo "Turno guardado correctamente";
        } else {
            echo "Error al guardar turno";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}