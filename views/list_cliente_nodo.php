<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-center">Clientes del Nodo</h2>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center">
                    <?= $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Verificar si hay clientes asociados al nodo -->
            <?php if (empty($clientes)): ?>
                <div class="alert alert-warning text-center">
                    No hay clientes asociados a este nodo aún.
                    <a href="index.php?action=create_cliente_nodo&nodo_id=<?= $nodo_id; ?>" class="btn btn-primary mt-3">Crear Cliente</a>
                </div>
            <?php else: ?>
                <!-- Mostrar la tabla de clientes si existen -->
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
                                    <a href="index.php?action=delete_cliente_nodo&id=<?= $cliente['id']; ?>&nodo_id=<?= $nodo_id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Incluir Leaflet para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Mapa y marcadores para los nodos -->
<script>
    var map = L.map('map').setView([-13.0692, -76.3799], 17);

     // Capa de Google Maps Satellite (necesitarás una clave de API de Google)
     L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}&apikey=YOUR_GOOGLE_API_KEY', {maxZoom: 20,attribution: 'Map data &copy; <a href="https://www.google.com/maps">Google</a>'}).addTo(map);

    <?php foreach ($clientes as $cliente): ?>
        var marker = L.marker([<?= $cliente['latitud']; ?>, <?= $cliente['longitud']; ?>]).addTo(map);
        marker.bindPopup("<b><?= $cliente['nombres'] . ' ' . $cliente['apellidos']; ?></b><br>Dirección: <?= $cliente['direccion']; ?>");
    <?php endforeach; ?>
</script>

<?php include('partials/footer.php'); ?>