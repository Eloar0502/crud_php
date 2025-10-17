<?php
require 'conexao.php';
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lista de Usuários</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f9f9f9; }
    h2 { margin-bottom: 10px; }
    table { border-collapse: collapse; width: 100%; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    a { text-decoration: none; color: #0066cc; }
    a:hover { text-decoration: underline; }
    .btn { padding: 6px 12px; background: #28a745; color: white; border: none; cursor: pointer; }
    .btn:hover { background: #218838; }
  </style>
</head>
<body>
  <h2>Usuários</h2>
  <a href="criar.php" class="btn">+ Novo usuário</a><br><br>

  <table>
    <tr>
      <th>ID</th><th>Nome</th><th>Email</th><th>Idade</th><th>Ações</th>
    </tr>
    <?php if (!$usuarios): ?>
      <tr><td colspan="5">Nenhum usuário cadastrado.</td></tr>
    <?php else: ?>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['id']) ?></td>
          <td><?= htmlspecialchars($u['nome']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['idade']) ?></td>
          <td>
            <a href="editar.php?id=<?= $u['id'] ?>">Editar</a> |
            <a href="excluir.php?id=<?= $u['id'] ?>" onclick="return confirm('Excluir esse usuário?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>
  <footer>
  <p>&copy; <?= date('Y') ?> Feito por Maria Eloar</p>
</footer>

<style>
  footer {
    margin-top: 40px;
    text-align: center;
    padding: 10px;
    color: #666;
    font-size: 14px;
    border-top: 1px solid #ddd;
  }
</style>

</body>
</html>
