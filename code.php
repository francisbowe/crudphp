<?php
session_start();
require 'conexion.php';

if (isset($_POST['salvar_curso'])) {
    $nome_curso = filter_input(INPUT_POST, 'nome_curso', FILTER_SANITIZE_STRING);
    $duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_STRING);
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    if ($nome_curso && $duracao && $usuario_id) {
        // Verifica se o curso já existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM cursos WHERE nome_curso = ? AND usuario_id = ?")) {
            $sql->bind_param('si', $nome_curso, $usuario_id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 0) {
                // Insere o novo curso na tabela cursos da base de dados
                if ($sql = $mysqli2->prepare("INSERT INTO cursos (nome_curso, duracao, usuario_id) VALUES (?, ?, ?)")) {
                    $sql->bind_param('ssi', $nome_curso, $duracao, $usuario_id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Curso adicionado com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao inserir o curso: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de inserção: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "O curso já existe.";
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
        }
    } else {
        $_SESSION['status'] = "Dados inválidos. Por favor, verifique os campos.";
    }

    header('Location: cursos.php');
    exit;
}
?>
