<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: log-in.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../STYLES/adminProfile.css">
</head>
<body>

<div class="container">
    <h1>Panel Administrador</h1>

    <?php if ($pendingShifts): ?>
        <?php foreach ($pendingShifts as $shift): ?>
            <div class="shift-card">
                <p><strong>Cliente:</strong> <?= $shift['name'] ?></p>
                <p><strong>Fecha:</strong> <?= $shift['day'] ?></p>
                <p><strong>Hora:</strong> <?= $shift['hour'] ?></p>

                <form method="POST" action="../controller/adminController.php">
                    <input type="hidden" name="id_shift" value="<?= $shift['id_shifts'] ?>">
                    <button type="submit" name="action" value="accept">Aceptar</button>
                    <button type="submit" name="action" value="reject">Rechazar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay turnos pendientes.</p>
    <?php endif; ?>
</div>

</body>
</html>