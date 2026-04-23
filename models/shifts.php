<?php

class Shift {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createShift($day, $hour) {

        $sql = "INSERT INTO shifts (id_customer, day, hour, available, status)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $_SESSION['user_id'],
            $day,
            $hour,
            1,
            'Pendiente'
        ]);
    }
    public function getPendingShifts() {

    $stmt = $this->conn->prepare("
        SELECT shifts.*, customer.name 
        FROM shifts
        JOIN customer 
        ON shifts.id_customer = customer.id_customer
        WHERE shifts.status = 'Pendiente'
        ORDER BY shifts.day ASC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateStatus($id_shift, $status) {

    $stmt = $this->conn->prepare("
        UPDATE shifts
        SET status = ?
        WHERE id_shifts = ?
    ");

    return $stmt->execute([$status, $id_shift]);
}

public function getFutureShiftsByUser($id_customer) {

    $stmt = $this->conn->prepare("
        SELECT day, hour, status
        FROM shifts
        WHERE id_customer = ?
        AND status = 'Aceptado'
        AND day >= CURDATE()
        ORDER BY day ASC, hour ASC
    ");

    $stmt->execute([$id_customer]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getShiftsByUser($id_customer) {

    $stmt = $this->conn->prepare("
        SELECT day, hour, status
        FROM shifts
        WHERE id_customer = ?
        ORDER BY day ASC
    ");

    $stmt->execute([$id_customer]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}