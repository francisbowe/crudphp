<?php
session_start();
require 'conexion.php';

if (isset($_POST['atualiza_conta'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $iban = filter_input(INPUT_POST, 'iban', FILTER_SANITIZE_STRING);
    $banco = filter_input(INPUT_POST, 'banco', FILTER_SANITIZE_STRING);
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    // Verifica se os campos estão preenchidos e válidos
    if ($id === false) {
        $_SESSION['status'] = "ID inválido.";
    } elseif (empty($iban)) {
        $_SESSION['status'] = "IBAN inválido.";
    } elseif (empty($banco)) {
        $_SESSION['status'] = "Banco inválido.";
    } elseif ($usuario_id === false) {
        $_SESSION['status'] = "ID do usuário inválido.";
    } else {
        // Verifica se a conta existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM contas WHERE id = ?")) {
            $sql->bind_param('i', $id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 1) {
                // Atualiza a conta na tabela contas da base de dados
                if ($sql = $mysqli2->prepare("UPDATE contas SET iban = ?, banco = ?, usuario_id = ? WHERE id = ?")) {
                    $sql->bind_param('ssii', $iban, $banco, $usuario_id, $id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Conta atualizada com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao atualizar a conta: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de atualização: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "Conta não encontrada.";
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
        }
    }

    header('Location: contas.php');
    exit;
}
?>
