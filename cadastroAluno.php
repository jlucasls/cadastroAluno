<?php
require 'config.php';  // Incluindo a configuração do banco de dados

$sucesso = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $endereco = trim($_POST['endereco']);
    $data_nascimento = $_POST['dataNasc'];  // Corrigido para o nome correto do campo no formulário
    $plano = trim($_POST['plano']);
    $sexo = $_POST['sexo'];

    // Validação dos dados
    if (empty($nome)) {
        $erro = "O nome não pode estar vazio.";
    } elseif (!preg_match('/^\d{11}$/', $cpf)) {
        $erro = "O CPF deve conter 11 dígitos numéricos.";
    } elseif (empty($endereco)) {
        $erro = "O endereço não pode estar vazio.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $data_nascimento)) {
        $erro = "A data de nascimento deve ser válida.";
    } elseif (empty($plano)) {
        $erro = "O plano não pode estar vazio.";
    } elseif (empty($sexo)) {
        $erro = "O sexo não pode estar vazio.";
    } else {
        try {
            // Prepara a consulta SQL para inserir os dados
            $sql = "INSERT INTO tbAluno (nome, cpf, endereco, dataNasc, plano, sexo) 
                    VALUES (:nome, :cpf, :endereco, :dataNasc, :plano, :sexo)";
            $stmt = $pdo->prepare($sql);

            // Vincula os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':dataNasc', $data_nascimento);
            $stmt->bindParam(':plano', $plano);
            $stmt->bindParam(':sexo', $sexo);

            // Executa a consulta
            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar o aluno.";
            }
        } catch (PDOException $e) {
            // Captura qualquer erro de execução de SQL e exibe
            $erro = "Erro ao tentar inserir os dados: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <h1>Cadastro de Aluno</h1>
    
    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (!empty($sucesso)): ?>
        <p style="color: green;"><?php echo $sucesso; ?></p>
    <?php endif; ?>
    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <!-- Formulário para cadastro de aluno -->
    <form action="cadastroAluno.php" method="POST">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Nome completo" required>
        </div>
        
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="CPF (apenas números)" maxlength="11" required pattern="\d{11}">
        </div>
        
        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" placeholder="Endereço completo" required>
        </div>
        
        <div>
            <label for="dataNasc">Data de Nascimento:</label>
            <input type="date" name="dataNasc" id="dataNasc" required>
        </div>
        
        <div>
            <label for="plano">Plano:</label>
            <input type="text" name="plano" id="plano" placeholder="Plano do aluno" required>
        </div>
        
        <div>
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" required>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
        </div>
        
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</body>
</html>
