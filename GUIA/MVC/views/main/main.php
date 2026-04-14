<!DOCTYPE html>
<html lang="es">

<?php require "views/templates/header.php"; ?>
<?php require "views/templates/nav.php"; ?>

<style>
    /* Estilo exclusivo para exportar a PDF (oculta lo innecesario) */
    @media print {
        body { margin: 0; padding: 0; background-color: white; }
        #conten, .navbar, .btn, footer, hr, .ocultar-impresion { display: none !important; }
        .table { width: 100% !important; color: black !important; }
        .table-dark { background-color: transparent !important; }
        .table-dark th, .table-dark td { color: black !important; border: 1px solid #ccc !important; }
        h1 { color: black !important; }
    }

    /* Animación creativa para el mensaje de éxito */
    .alerta-animada {
        animation: deslizarYBrillar 0.8s ease-out forwards;
        border-left: 6px solid #198754;
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }
    
    @keyframes deslizarYBrillar {
        0% { transform: translateY(-30px); opacity: 0; }
        50% { transform: translateY(5px); opacity: 1; }
        100% { transform: translateY(0); opacity: 1; }
    }
</style>

<body>
    <br><br><br>
    <div class="container">
        
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show alerta-animada ocultar-impresion mt-3" role="alert">
                <h4>¡Operación Exitosa!</h4>
                <hr>
                <p class="mb-0"><?php echo $_SESSION['mensaje']; ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <h1 class="text-center mt-4">Gestion personas</h1>

        <div style="padding: 0;" id="conten">
            <form role="form" action="<?php echo constant('URL'); ?>Main/modificarPersona" method="POST" onsubmit="return confirm('¿Está seguro de realizar esta acción en la base de datos?');">
                <div class="col-md-12" id="conten">
                    <input type="hidden" name="id" id="idpersona">

                    <div class="form-group mb-3">
                        <label for="nombre">Ingrese el nombre de la persona:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nombre" id="nombre" 
                                   value="<?php echo isset($this->persona) ? $this->persona->getNombre() : ''; ?>" 
                                   oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                   title="Solo se permiten letras" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edad">Ingrese la edad de la persona:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="edad" name="edad" 
                                   value="<?php echo isset($this->persona) ? $this->persona->getEdad() : ''; ?>" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                   min="18" max="99" title="Debe tener entre 18 y 99 años" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono">Ingrese el telefono de la persona:</label>
                        <div class="input-group">
                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                   value="<?php echo isset($this->persona) ? $this->persona->getTelefono() : ''; ?>" 
                                   oninput="this.value = this.value.replace(/[^0-9\-]/g, '');"
                                   pattern="[267][0-9]{3}-[0-9]{4}" 
                                   title="Ingrese un teléfono válido iniciando con 2, 6 o 7 (formato: 0000-0000)" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="sexo">Ingrese el sexo de la persona:</label>
                        <div class="input-group">
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="ocupacion">Ingrese la ocupacion de la persona:</label>
                        <div class="input-group">
                            <select name="ocupacion" id="ocupacion" class="form-control" required>
                                <?php foreach ($this->listaOcupaciones as $lista): ?>
                                    <option value="<?php echo $lista->getIdOcupacion(); ?>">
                                        <?php echo $lista->getOcupacion(); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="fecha">Ingrese la fecha de nacimiento de la persona:</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="fecha" name="fecha" 
                                   value="<?php echo isset($this->persona) ? $this->persona->getFecha() : ''; ?>" 
                                   max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div style="margin-left: 30%;">
                        <input type="submit" class="btn btn-success col-md-6" value="Enviar">
                    </div>
                </div>
            </form>
        </div>

        <br>

        <div class="mb-3 text-end ocultar-impresion">
            <button class="btn btn-secondary" onclick="window.print()">
                Imprimir en formato PDF
            </button>
        </div>

        <div>
            <table class="table table-striped table-hover table-dark">
                <thead class="table-dark table-striped">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Ocupacion</th>
                        <th>Fecha nacimiento</th>
                        <th colspan="2" class="text-center ocultar-impresion">Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->listaPersonas as $lista): ?>
                        <tr>
                            <td><?php echo $lista->getIdPersona(); ?></td>
                            <td><?php echo $lista->getNombre(); ?></td>
                            <td><?php echo $lista->getEdad(); ?></td>
                            <td><?php echo $lista->getTelefono(); ?></td>
                            <td><?php echo $lista->getSexo(); ?></td>
                            <td><?php echo $lista->getOcupacion()->getOcupacion(); ?></td>
                            <td><?php echo $lista->getFecha(); ?></td>
                            
                            <td class="text-center ocultar-impresion">
                                <button onclick="alerta('<?php echo $lista->getIdPersona(); ?>')" 
                                        class="btn btn-danger">Eliminar</button>
                            </td>
                            
                            <td class="text-center ocultar-impresion">
                                <button onclick="modificar(
                                    '<?php echo $lista->getIdPersona(); ?>',
                                    '<?php echo $lista->getNombre(); ?>',
                                    '<?php echo $lista->getEdad(); ?>',
                                    '<?php echo $lista->getTelefono(); ?>',
                                    '<?php echo $lista->getSexo(); ?>',
                                    '<?php echo $lista->getOcupacion()->getIdOcupacion(); ?>',
                                    '<?php echo $lista->getFecha(); ?>'
                                )" class="btn btn-info">Modificar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require "views/templates/modal.php"; ?>
    <?php require "views/templates/footer.php"; ?>
</body>
</html>