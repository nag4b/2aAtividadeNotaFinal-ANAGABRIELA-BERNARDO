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

if (isset($_POST['excluir_livro'])) {
    $stmt = $db->prepare('DELETE FROM livros WHERE id = :id');
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();
}

$livros = $db->query('SELECT * FROM livros');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Livraria</title>
    <style>
        body {
            background-color: #f0f0f0; /* Cor de fundo */
            font-family: Arial, sans-serif; /* Fonte */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Margem superior */
        }
        th, td {
            border: 1px solid #ddd; /* Cor da borda */
            text-align: left;
            padding: 8px;
            font-size: 16px; /* Tamanho da fonte */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Cor de fundo das linhas pares */
        }
        .azul {
            color: blue; /* Cor do texto azul */
            font-weight: bold; /* Negrito */
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Cor da borda */
            border-radius: 4px; /* Arredondamento */
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff; /* Cor do botão */
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none; /* Sem borda */
            border-radius: 4px; /* Arredondamento */
            cursor: pointer; /* Cursor */
        }
    </style>
</head>
<body>
    <h1 class="azul">Adicionar Livro</h1>
    <form method="post">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="ano_publicacao" placeholder="Ano de Publicação (dd/mm/yyyy)" required>
        <input type="submit" name="adicionar_livro" value="Adicionar Livro">
    </form>
    <h1 class="azul">Lista de Livros</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Ano de Publicação</th>
            <th>Excluir</th>
        </tr>
        <?php while ($livro = $livros->fetchArray()): ?>
            <tr>
                <td><?php echo $livro['id']; ?></td>
                <td><?php echo $livro['titulo']; ?></td>
                <td><?php echo $livro['autor']; ?></td>
                <td><?php echo date('d/m/Y', $livro['ano_publicacao']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">
                        <input type="submit" name="excluir_livro" value="Excluir">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
