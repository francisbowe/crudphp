<?php
session_start();
require 'conexion.php';

if (isset($_POST['excluir_curso'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        // Verifica se o curso existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM cursos WHERE id = ?")) {
            $sql->bind_param('i', $id);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows === 1) {
                // Exclui o curso na tabela cursos da base de dados
                if ($sql = $mysqli2->prepare("DELETE FROM cursos WHERE id = ?")) {
                    $sql->bind_param('i', $id);
                    if ($sql->execute()) {
                        $_SESSION['status'] = "Curso excluído com sucesso!";
                        echo json_encode(['success' => true]);
                        exit;
                    } else {
                        $_SESSION['status'] = "Erro ao excluir o curso: " . $sql->error;
                        echo json_encode(['success' => false, 'message' => $sql->error]);
                        exit;
                    }
                } else {
                    $_SESSION['status'] = "Erro ao preparar a consulta de exclusão: " . $mysqli2->error;
                    echo json_encode(['success' => false, 'message' => $mysqli2->error]);
                    exit;
                }
            } else {
                $_SESSION['status'] = "Curso não encontrado.";
                echo json_encode(['success' => false, 'message' => 'Curso não encontrado']);
                exit;
            }
        } else {
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
            echo json_encode(['success' => false, 'message' => $mysqli2->error]);
            exit;
        }
    } else {
        $_SESSION['status'] = "Dados inválidos. Por favor, verifique os campos.";
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit;
    }
}
?>
