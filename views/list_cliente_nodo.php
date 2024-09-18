<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Saludo personalizado -->
            <h2 class="mb-4 text-center">Hola, <?= $_SESSION['username']; ?>, estos son los clientes de tu nodo:</h2>
             <!-- Verificar si hay clientes asociados al nodo -->
        
               <!-- Mapa -->
            <div id="map" style="height: 600px; width: 100%;" class="mb-4"></div>
             <!-- Mostrar la tabla de clientes si existen -->
            <h2 class="mb-4 text-center">Lista de Clientes del Nodo</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Dirección</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['dni']; ?></td>
                            <td><?= $cliente['nombres']; ?></td>
                            <td><?= $cliente['apellidos']; ?></td>
                            <td><?= $cliente['direccion']; ?></td>
                            <td><?= $cliente['latitud']; ?></td>
                            <td><?= $cliente['longitud']; ?></td>
                            <td>
                                <a href="index.php?action=edit_cliente_nodo&id=<?= $cliente['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?action=delete_cliente_nodo&id=<?= $cliente['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>