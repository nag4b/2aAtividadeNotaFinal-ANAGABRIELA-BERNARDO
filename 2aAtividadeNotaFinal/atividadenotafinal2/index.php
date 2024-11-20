<?php
$db = new SQLite3('tarefas.db');

$db->exec('CREATE TABLE IF NOT EXISTS tarefas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    descricao TEXT NOT NULL, 
    data_vencimento DATE NOT NULL,
    concluida INTEGER DEFAULT 0
)');

if (isset($_POST['adicionar'])) {
    $stmt = $db->prepare('INSERT INTO tarefas (descricao, data_vencimento) VALUES (:descricao, :data_vencimento)');
    $stmt->bindValue(':descricao', $_POST['descricao']);
    $stmt->bindValue(':data_vencimento', $_POST['data_vencimento']);
    $stmt->execute();
}

if (isset($_GET['concluir'])) $db->exec("UPDATE tarefas SET concluida = 1 WHERE id = {$_GET['concluir']}");
if (isset($_GET['excluir'])) $db->exec("DELETE FROM tarefas WHERE id = {$_GET['excluir']}");

$tarefas = $db->query('SELECT * FROM tarefas ORDER BY data_vencimento');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Minhas Tarefas</title>
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: linear-gradient(135deg, #f5f0ff 0%, #e8e0ff 100%);
            min-height: 100vh;
        }
        h1 {
            color: #4a148c;
            text-align: center;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(74, 20, 140, 0.1);
            margin-bottom: 30px;
        }
        h2 {
            color: #6a1b9a;
            margin-top: 30px;
        }
        .tarefa { 
            margin: 20px 0;
            padding: 20px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.1);
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .tarefahover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 20, 140, 0.15);
        }
        .concluida { 
            background: linear-gradient(135deg, #e1bee7 0%, #f3e5f5 100%);
        }
        input[type=text], input[type=date] {
            padding: 12px;
            margin: 8px;
            border: 2px solid #9c27b0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background: white;
        }
        input[type=text]:focus, input[type=date]:focus {
            outline: none;
            border-color: #6a1b9a;
            box-shadow: 0 0 10px rgba(156, 39, 176, 0.2);
        }
        input[type=submit] {
            background: linear-gradient(45deg, #9c27b0 0%, #673ab7 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        input[type=submit]:hover {
            background: linear-gradient(45deg, #8e24aa 0%, #5e35b1 100%);
            box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3);
            transform: translateY(-2px);
        }
        a { 
            color: #6a1b9a;
            text-decoration: none;
            margin: 0 8px;
            padding: 5px 10px;
        border-radius: 5px;
            transition: all 0.3s;
            font-weight: 500;
        }
        a:hover {
            background-color: rgba(156, 39, 176, 0.1);
            color: #4a148c;
        }
        form {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.1);
        }
        p {
            color: #4a148c;
            margin: 10px 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Minhas Tarefas</h1>

    <form method="post">
        <input type="text" name="descricao" placeholder="Descrição da tarefa" required>
        <input type="date" name="data_vencimento" required>
        <input type="submit" name="adicionar" value="Adicionar Tarefa">
    </form>

    <h2>Minhas Tarefas</h2>
    <?php while ($tarefa = $tarefas->fetchArray()) { ?>
        <div class="tarefa <?= $tarefa['concluida'] ? 'concluida' : '' ?>">
            <p><strong>Descrição:</strong> <?= htmlspecialchars($tarefa['descricao']) ?></p>
            <p><strong>Data de Vencimento:</strong> <?= date('d/m/Y', strtotime($tarefa['data_vencimento'])) ?></p>
            <?php if (!$tarefa['concluida']) { ?>
                <a href="?concluir=<?= $tarefa['id'] ?>">Marcar como Concluída</a>
            <?php } ?>
            <a href="?excluir=<?= $tarefa['id'] ?>">Excluir</a>
        </div>
    <?php } ?>
</body>
</html>
