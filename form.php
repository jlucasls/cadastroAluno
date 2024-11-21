<?php
require 'config.php';  // Incluindo a configuração do banco de dados

// Consulta todos os alunos cadastrados
$sql = "SELECT nome, cpf, endereco, dataNasc, plano, sexo FROM tbAluno";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Recupera todos os resultados
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Lista de Alunos Cadastrados</h1>

<!-- Verifica se há alunos para exibir -->
<?php if (count($alunos) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Data de Nascimento</th>
                <th>Plano</th>
                <th>Sexo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                    <td><?php echo htmlspecialchars($aluno['cpf']); ?></td>
                    <td><?php echo htmlspecialchars($aluno['endereco']); ?></td>
                    <td><?php echo htmlspecialchars($aluno['dataNasc']); ?></td>
                    <td><?php echo htmlspecialchars($aluno['plano']); ?></td>
                    <td><?php echo htmlspecialchars($aluno['sexo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum aluno cadastrado.</p>
<?php endif; ?>

</body>
</html>
