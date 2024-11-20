<?php
$db = new SQLite3('livraria.db');

$db->exec('CREATE TABLE IF NOT EXISTS livros (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL, 
    autor TEXT NOT NULL,
    ano_publicacao INTEGER NOT NULL
)');

if (isset($_POST['adicionar_livro'])) {
    $stmt = $db->prepare('INSERT INTO livros (titulo, autor, ano_publicacao) VALUES (:titulo, :autor, :ano_publicacao)');
    $stmt->bindValue(':titulo', $_POST['titulo']);
    $stmt->bindValue(':autor', $_POST['autor']);
    $stmt->bindValue(':ano_publicacao', $_POST['ano_publicacao']);
    $stmt->execute();
}

$livros = $db->query('SELECT * FROM livros');
?>