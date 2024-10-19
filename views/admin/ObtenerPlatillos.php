<?php
header('Content-Type: application/json');

include_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $platilloId = isset($_GET['id']) ? $_GET['id'] : null;

    try {
        if ($platilloId) {
            $stmt = $pdo->prepare('SELECT * FROM platillos WHERE IdPlatillo = ?');
            $stmt->execute([$platilloId]);
            $platillo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($platillo) {
                echo json_encode($platillo);
            } else {
                echo json_encode(['error' => 'Platillo no encontrado']);
            }
        } else {
            $stmt = $pdo->query('SELECT * FROM platillos');
            $platillos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($platillos);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombrePlatillo = $_POST['NombrePlatillo'] ?? null;
    $descripcionPlatillo = $_POST['DescripcionPlatillo'] ?? null;
    $precioPlatillo = $_POST['PrecioPlatillo'] ?? null;
    $disponibilidad = $_POST['Disponibilidad'] ?? null;
    $categoriaId = $_POST['IdCategoria'] ?? null;

    if (!$nombrePlatillo || !$descripcionPlatillo || !$precioPlatillo || !$disponibilidad || !$categoriaId) {
        echo json_encode(['error' => 'Todos los campos son obligatorios']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO platillos (NombrePlatillo, DescripcionPlatillo, PrecioPlatillo, Disponibilidad, IdCategoria) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nombrePlatillo, $descripcionPlatillo, $precioPlatillo, $disponibilidad, $categoriaId]);

        echo json_encode(['success' => 'Platillo agregado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
