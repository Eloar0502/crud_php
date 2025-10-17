<?php
require 'conexao.php';
$erro = '';
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();
if (!$usuario) die('Usuário não encontrado');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idade = (int)($_POST['idade'] ?? 0);

    if ($nome === '' || $email === '' || $idade <= 0) {
        $erro = 'Preencha todos os campos corretamente.';
    } else {
        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, idade = :idade 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'idade' => $idade,
                'id' => $id
            ]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $erro = 'Já existe um usuário com esses dados.';
            } else {
                $erro = 'Erro ao atualizar: ' . $e->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Editar</title>
<style>
  body { font-family: Arial; padding: 20px; }
  input, button { padding: 8px; width: 300px; margin-bottom: 10px; }
  .erro { color: red; }
</style>
</head>
<body>
  <h2>Editar usuário</h2>
  <?php if ($erro) echo "<p class='erro'>".htmlspecialchars($erro)."</p>"; ?>
  <form method="post">
    Nome: <br><input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? $usuario['nome']) ?>" required><br>
    Email: <br><input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? $usuario['email']) ?>" required><br>
    Idade: <br><input type="number" name="idade" min="1" value="<?= htmlspecialchars($_POST['idade'] ?? $usuario['idade']) ?>" required><br>
    <button type="submit">Atualizar</button>
    <a href="index.php">Cancelar</a>
  </form>
</body>
</html>
