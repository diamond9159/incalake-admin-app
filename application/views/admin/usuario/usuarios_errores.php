<?= validation_errors()?'<div class="alert alert-danger"><b>Errores:</b> <br>'.validation_errors().'</div>':''; ?>
<button onclick="window.history.back();">Volver</button>