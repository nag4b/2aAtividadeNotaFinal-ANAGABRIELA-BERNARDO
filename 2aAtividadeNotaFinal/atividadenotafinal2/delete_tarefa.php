<?php
if (isset($_POST['excluir_tarefa'])) {
    $db->exec('DELETE FROM tarefas WHERE id = ' . $_POST['id']);
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="excluir_tarefa" value="Excluir Tarefa">
</form>
