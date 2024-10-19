<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM platillos WHERE IdPlatillo = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $platillo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($platillo) {
        echo json_encode(['success' => true, 'platillo' => $platillo]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Platillo no encontrado']);
    }
}


