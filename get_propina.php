<?php
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM propinas WHERE id = '$id'";
    $resultado = $mysqli2->query($sql);

    if ($resultado->num_rows > 0) {
        $propinas = $resultado->fetch_assoc();
        echo json_encode(array('success' => true, 'data' => $propinas));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Curso não encontrado'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'ID do curso não informado'));
}
?>