<?php
if (isset($_POST['concluir_tarefa'])) {
    $stmt = $db->prepare('UPDATE tarefas SET concluida = 1 WHERE id = :id');
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">
    <input type="submit" name="concluir_tarefa" value="Concluir Tarefa">
</form>
