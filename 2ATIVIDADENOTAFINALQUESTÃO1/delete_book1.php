<?php
$db = new SQLite3('livraria.db');

if (isset($_POST['excluir_livro'])) {
    $stmt = $db->prepare('DELETE FROM livros WHERE id = :id');
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();
}

$livros = $db->query('SELECT * FROM livros');
?>
