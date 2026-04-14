<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <?php require 'views/templates/header.php'; ?>
    <div class="container text-center mt-5">
        <h1 class="text-danger">Hubo un error en la solicitud</h1>
        <p><?php echo isset($this->mensaje) ? $this->mensaje : "Página no encontrada o método inexistente."; ?></p>
    </div>
    <?php require 'views/templates/footer.php'; ?>
</body>
</html>