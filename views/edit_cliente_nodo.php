<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<?php
if (isset($_GET['id'])) {
    $controller = new ClienteNodoController();
    $cliente = $controller->getClienteById($_GET['id']);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center">Editar Cliente del Nodo</h2>
            <form action="index.php?action=update_cliente_nodo&id=<?php echo $cliente['id']; ?>" method="POST">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $cliente['dni']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $cliente['nombres']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $cliente['apellidos']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ip_cliente">IP del Cliente:</label>
                    <input type="text" class="form-control" id="ip_cliente" name="ip_cliente" value="<?php echo $cliente['ip_cliente']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="latitud">Latitud:</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" value="<?php echo $cliente['latitud']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud:</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" value="<?php echo $cliente['longitud']; ?>" readonly>
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
    var map = L.map('map').setView([<?php echo $cliente['latitud']; ?>, <?php echo $cliente['longitud']; ?>], 13);

    // Agregar la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Generar el marcador del cliente y hacerlo arrastrable
    var marker = L.marker([<?php echo $cliente['latitud']; ?>, <?php echo $cliente['longitud']; ?>], {draggable: true}).addTo(map);
    marker.bindPopup("<b>Cliente: </b><?php echo $cliente['nombres'] . ' ' . $cliente['apellidos']; ?><br><b>Dirección: </b><?php echo $cliente['direccion']; ?>", {
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
