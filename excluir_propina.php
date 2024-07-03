<?php
session_start();
require 'conexion.php';

if (isset($_POST['excluir_propina'])) { // Verifica se a ação de exclusão foi solicitada
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); // Filtra o ID como um inteiro

    if ($id) { // Verifica se o ID é válido
        // Prepara uma consulta para verificar se a propina existe na base de dados
        if ($sql = $mysqli2->prepare("SELECT * FROM propinas WHERE id = ?")) {
            $sql->bind_param('i', $id); // Vincula o ID à consulta
            $sql->execute(); // Executa a consulta
            $result = $sql->get_result(); // Obtém o resultado da consulta

            if ($result->num_rows === 1) { // Verifica se a propina foi encontrada
                // Prepara uma consulta para excluir a propina
                if ($sql = $mysqli2->prepare("DELETE FROM propinas WHERE id = ?")) {
                    $sql->bind_param('i', $id); // Vincula o ID à consulta de exclusão
                    if ($sql->execute()) { // Executa a consulta de exclusão
                        $_SESSION['status'] = "Propina excluída com sucesso!";
                        echo json_encode(['success' => true]);
                        exit;
                    } else { // Erro ao executar a consulta de exclusão
                        $_SESSION['status'] = "Erro ao excluir a propina: " . $sql->error;
                        echo json_encode(['success' => false, 'message' => $sql->error]);
                        exit;
                    }
                } else { // Erro ao preparar a consulta de exclusão
                    $_SESSION['status'] = "Erro ao preparar a consulta de exclusão: " . $mysqli2->error;
                    echo json_encode(['success' => false, 'message' => $mysqli2->error]);
                    exit;
                }
            } else { // Propina não encontrada
                $_SESSION['status'] = "Propina não encontrada.";
                echo json_encode(['success' => false, 'message' => 'Propina não encontrada']);
                exit;
            }
        } else { // Erro ao preparar a consulta de verificação
            $_SESSION['status'] = "Erro ao preparar a consulta de verificação: " . $mysqli2->error;
            echo json_encode(['success' => false, 'message' => $mysqli2->error]);
            exit;
        }
    } else { // Dados inválidos
        $_SESSION['status'] = "Dados inválidos. Por favor, verifique os campos.";
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit;
    }
}
?>
