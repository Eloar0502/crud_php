<?php
require 'conexao.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idade = (int)($_POST['idade'] ?? 0);

    if ($nome === '' || $email === '' || $idade <= 0) {
        $erro = 'Preencha todos os campos corretamente.';
    } else {
        try {
            $sql = "INSERT INTO usuarios (nome, email, idade) VALUES (:nome, :email, :idade)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['nome' => $nome, 'email' => $email, 'idade' => $idade]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $erro = 'Usuário com os mesmos dados já existe.';
            } else {
                $erro = 'Erro ao salvar: ' . $e->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Criar</title>
<style>
  body { font-family: Arial; padding: 20px; }
  input, button { padding: 8px; width: 300px; margin-bottom: 10px; }
  .erro { color: red; }
</style>
</head>
<body>
  <h2>Adicionar usuário</h2>
  <?php if ($erro) echo "<p class='erro'>".htmlspecialchars($erro)."</p>"; ?>
  <form method="post">
    Nome: <br><input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required><br>
    Email: <br><input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required><br>
    Idade: <br><input type="number" name="idade" min="1" value="<?= htmlspecialchars($_POST['idade'] ?? '') ?>" required><br>
    <button type="submit">Salvar</button>
    <a href="index.php">Cancelar</a>
  </form>
</body>
</html>
