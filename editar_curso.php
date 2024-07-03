<?php
session_start();
require 'conexion.php';

if (isset($_POST['atualiza_curso'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome_curso = filter_input(INPUT_POST, 'nome_curso', FILTER_SANITIZE_STRING);
    $duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_STRING); // Mudança aqui para aceitar string
    $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);

    if ($id && $nome_curso && $duracao && $usuario_id) {
        // Verifica se o curso existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM cursos WHERE id = ?")) {
            $sql->bind_param('i', $id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 1) {
                // Atualiza o curso na tabela cursos da base de dados
                if ($sql = $mysqli2->prepare("UPDATE cursos SET nome_curso = ?, duracao = ?, usuario_id = ? WHERE id = ?")) {
                    $sql->bind_param('ssii', $nome_curso, $duracao, $usuario_id, $id); // Mudança aqui para bind_param aceitar string em duracao
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Curso atualizado com sucesso!";
                    } else {
                        $_SESSION['status'] = "Erro ao atualizar o curso: " . $sql->error;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de atualização: " . $mysqli2->error;
                }
            } else {
                $_SESSION['status'] = "Curso não encontrado.";
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
