<?php
session_start();
require 'conexion.php';

if (isset($_POST['salvar_conta'])) {
    $iban = filter_input(INPUT_POST, 'iban', FILTER_SANITIZE_STRING);
    $banco = filter_input(INPUT_POST, 'banco', FILTER_SANITIZE_STRING);
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    if ($iban && $banco && $usuario_id) {
        // Verifica se a conta já existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM contas WHERE iban = ? AND usuario_id = ?")) {
            $sql->bind_param('si', $iban, $usuario_id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 0) {
                // Insere o nova conta na tabela contas da base de dados
                if ($sql = $mysqli2->prepare("INSERT INTO contas (iban, banco, usuario_id) VALUES (?, ?, ?)")) {
                    $sql->bind_param('ssi', $iban, $banco, $usuario_id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Conta adicionada com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao inserir conta: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de inserção: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "Conta já existe.";
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
        }
    } else {
        $_SESSION['status'] = "Dados inválidos. Por favor, verifique os campos.";
    }

    header('Location: contas.php');
    exit;
}
?>
