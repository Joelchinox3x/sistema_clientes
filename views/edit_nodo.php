<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<?php
if (isset($_GET['id'])) {
    $controller = new NodoController();
    $nodo = $controller->getNodoById($_GET['id']);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center">Editar Nodo</h2>
            <form action="index.php?action=update_nodo&id=<?php echo $nodo['id']; ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Nodo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nodo['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="latitud">Latitud:</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" value="<?php echo $nodo['latitud']; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud:</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" value="<?php echo $nodo['longitud']; ?>" readonly required>
                </div>
                <!-- Mapa interactivo -->
                <div id="map" style="height: 400px; width: 100%;"></div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Actualizar Nodo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluir la biblioteca de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Inicializar el mapa con la ubicación del nodo actual
    var map = L.map('map').setView([<?php echo $nodo['latitud']; ?>, <?php echo $nodo['longitud']; ?>], 13);

    // Agregar la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Agregar un marcador en la ubicación del nodo, con capacidad de arrastrar
    var marker = L.marker([<?php echo $nodo['latitud']; ?>, <?php echo $nodo['longitud']; ?>], {draggable: true}).addTo(map);

    // Actualizar los campos de latitud y longitud cuando el marcador se mueva
    marker.on('dragend', function(e) {
        var latlng = marker.getLatLng();
        document.getElementById('latitud').value = latlng.lat;
        document.getElementById('longitud').value = latlng.lng;
    });

    // Permitir que el usuario haga clic en el mapa para mover el marcador
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });
</script>

<?php include('partials/footer.php'); ?>
