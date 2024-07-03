<?php
session_start();
require 'conexion.php';

if (isset($_POST['salvar_propina'])) {
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_STRING);
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    if ($ano && $preco && $usuario_id) {
        // Verifica se a propina já existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM propinas WHERE ano = ? AND usuario_id = ?")) {
            $sql->bind_param('si', $ano, $usuario_id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 0) {
                // Insere o nova propina na tabela propina da base de dados
                if ($sql = $mysqli2->prepare("INSERT INTO propinas (ano, preco, usuario_id) VALUES (?, ?, ?)")) {
                    $sql->bind_param('ssi', $ano, $preco, $usuario_id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Propina adicionado com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao inserir o propina: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de inserção: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "Propina já existe.";
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
        }
    } else {
        $_SESSION['status'] = "Dados inválidos. Por favor, verifique os campos.";
    }

    header('Location: propina.php');
    exit;
}
?>
