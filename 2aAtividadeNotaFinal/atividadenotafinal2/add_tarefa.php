<?php
if (isset($_POST['adicionar_tarefa'])) {
    $stmt = $db->prepare('INSERT INTO tarefas (descricao, data_limite) VALUES (:descricao, :data_limite)');
    $stmt->bindValue(':descricao', $_POST['descricao']);
    $stmt->bindValue(':data_limite', $_POST['data_limite']);
    $stmt->execute();
}
?>
<form method="post">
    <label for="descricao">Descrição da tarefa:</label>
    <input type="text" id="descricao" name="descricao">
    <label for="data_limite">Data limite:</label>
    <input type="date" id="data_limite" name="data_limite">
    <input type="submit" name="adicionar_tarefa" value="Adicionar Tarefa">
</form>
