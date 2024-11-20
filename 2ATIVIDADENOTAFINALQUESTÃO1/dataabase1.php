<?php
$db = new SQLite3('config.db');

$db->exec('CREATE TABLE IF NOT EXISTS config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL, 
    valor TEXT NOT NULL
)');

if (isset($_POST['configurar'])) {
    $stmt = $db->prepare('INSERT INTO config (nome, valor) VALUES (:nome, :valor)');
    $stmt->bindValue(':nome', $_POST['nome']);
    $stmt->bindValue(':valor', $_POST['valor']);
    $stmt->execute();
}

$configuracoes = $db->query('SELECT * FROM config');
?>
