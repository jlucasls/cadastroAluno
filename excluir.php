<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM tbAlunos WHERE id = ?");
    $stmt->execute([$id]);

    echo "<div class='alert alert-success'>Paciente excluído com sucesso!</div>";
    header("Location: tab.php");
    exit;
} else {
    echo "<div class='alert alert-danger'>Erro: ID não fornecido.</div>";
}
?>