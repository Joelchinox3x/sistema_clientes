<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Saludo personalizado -->
            <h2 class="mb-4 text-center">Hola, <?= $_SESSION['username']; ?>, estos son tus nodos:</h2>
            <!-- Verificar si hay nodos asociados al usuario -->
            <?php if (empty($nodos)): ?>
                <div class="alert alert-warning text-center">
                    No tienes nodos creados aún. 
                    <a href="index.php?action=create_nodo" class="btn btn-primary">Crear Nodo</a>
                </div>
            <?php else: ?>
                <!-- Mapa -->
                <div id="map" style="height: 600px; width: 100%;" class="mb-4"></div>
                <!-- Tabla de nodos -->
                <h2 class="mb-4 text-center">Lista de Nodos</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Nodo</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nodos as $nodo): ?>
                            <tr>
                                <td>
                                    <a href="index.php?action=list_clientes_nodo&nodo_id=<?= $nodo['id']; ?>">
                                        <?= $nodo['nombre']; ?>
                                    </a>
                                </td>

                                <td><?= $nodo['latitud']; ?></td>
                                <td><?= $nodo['longitud']; ?></td>
                                <td>
                                    <a href="index.php?action=edit_nodo&id=<?= $nodo['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="index.php?action=delete_nodo&id=<?= $nodo['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<!-- Incluir Leaflet para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Mapa y marcadores para los nodos -->
<script>
    <?php if (!empty($nodos)): ?>
    var nodos = <?php echo json_encode($nodos); ?>;
    
    // Inicializar el mapa en una ubicación predeterminada
    var map = L.map('map').setView([nodos[0].latitud, nodos[0].longitud], 13);

    // Agregar capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Añadir marcadores para cada nodo
    nodos.forEach(function(nodo) {
        var marker = L.marker([nodo.latitud, nodo.longitud]).addTo(map);
        marker.bindPopup("<b>Nombre del Nodo:</b> " + nodo.nombre + "<br><b>Latitud:</b> " + nodo.latitud + "<br><b>Longitud:</b> " + nodo.longitud);
    });
    <?php endif; ?>
</script>

