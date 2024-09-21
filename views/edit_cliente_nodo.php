<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<?php
// Obtener el cliente por ID
$clienteNodoController = new ClienteNodoController(); 
$cliente = $clienteNodoController->getClienteById($_GET['id']);
$nombreCliente = $cliente['nombres'] . ' ' . $cliente['apellidos'];

// Obtener el nodo al que pertenece el cliente
$nodoController = new NodoController();
$nodo = $nodoController->getNodoById($cliente['nodo_id']);
$nombreNodo = $nodo['nombre'];
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Título con el nombre del cliente y el nombre del nodo -->
            <h2 class="mb-4 text-center">Editar Cliente (<?= $nombreCliente; ?>) del Nodo (<?= $nombreNodo; ?>)</h2>
            
            <form action="index.php?action=update_cliente_nodo&id=<?= $cliente['id']; ?>" method="POST">
                <input type="hidden" name="nodo_id" value="<?= $cliente['nodo_id'] ?>">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?= $cliente['dni']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?= $cliente['nombres']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= $cliente['apellidos']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $cliente['telefono']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $cliente['direccion']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ip_cliente">IP del Cliente:</label>
                    <input type="text" class="form-control" id="ip_cliente" name="ip_cliente" value="<?= $cliente['ip_cliente']; ?>">
                </div>
                <div class="form-group">
                    <label for="latitud">Latitud:</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" value="<?= $cliente['latitud']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud:</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" value="<?= $cliente['longitud']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <input type="text" class="form-control" id="observaciones" name="observaciones" value="<?= $cliente['observaciones']; ?>">
                </div>
                <div id="map" style="height: 400px; width: 100%;"></div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluir la biblioteca de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Inicializar el mapa con la ubicación del cliente actual
    var map = L.map('map').setView([<?= $cliente['latitud']; ?>, <?= $cliente['longitud']; ?>], 13);

    // Agregar la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Generar el marcador del cliente y hacerlo arrastrable
    var marker = L.marker([<?= $cliente['latitud']; ?>, <?= $cliente['longitud']; ?>], {draggable: true}).addTo(map);
    marker.bindPopup("<b>Cliente: </b><?= $cliente['nombres'] . ' ' . $cliente['apellidos']; ?><br><b>Dirección: </b><?= $cliente['direccion']; ?>", {
        maxWidth: 200,
        closeButton: false,
        autoClose: false
    });

    // Actualizar los campos de latitud y longitud cuando el marcador se mueva
    marker.on('dragend', function(e) {
        var latlng = marker.getLatLng();
        document.getElementById('latitud').value = latlng.lat;
        document.getElementById('longitud').value = latlng.lng;
    });

    // Permitir mover el marcador con un clic en el mapa
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });
</script>

<?php include('partials/footer.php'); ?>
