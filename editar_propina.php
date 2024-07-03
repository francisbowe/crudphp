<?php
session_start();
require 'conexion.php';

if (isset($_POST['atualiza_propina'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_STRING);
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    // Verifica se os campos estão preenchidos e válidos
    if ($id === false) {
        $_SESSION['status'] = "ID inválido.";
    } elseif (empty($ano)) {
        $_SESSION['status'] = "Ano inválido.";
    } elseif (empty($preco)) {
        $_SESSION['status'] = "Preço inválido.";
    } elseif ($usuario_id === false) {
        $_SESSION['status'] = "ID do usuário inválido.";
    } else {
        // Verifica se a propina existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM propinas WHERE id = ?")) {
            $sql->bind_param('i', $id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 1) {
                // Atualiza a propina na tabela propinas da base de dados
                if ($sql = $mysqli2->prepare("UPDATE propinas SET ano = ?, preco = ?, usuario_id = ? WHERE id = ?")) {
                    $sql->bind_param('ssii', $ano, $preco, $usuario_id, $id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Propina atualizada com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao atualizar a propina: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de atualização: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "Propina não encontrada.";
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
        }
    }

    header('Location: propina.php');
    exit;
}
?>

