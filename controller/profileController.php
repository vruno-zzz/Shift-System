<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/log-in.php");
    exit;
}

require_once "../config/shiftsys.php";
require_once "../models/shifts.php";

$shiftModel = new Shift($conn);

// ADMIN
if ($_SESSION['user_role'] === 'admin') {
    $pendingShifts = $shiftModel->getPendingShifts();
    require_once "../views/adminProfile.php";
    exit;
}

// USER
$futureShifts = $shiftModel->getFutureShiftsByUser($_SESSION['user_id']);
$allShifts = $shiftModel->getShiftsByUser($_SESSION['user_id']);

require_once "../views/profile.php";