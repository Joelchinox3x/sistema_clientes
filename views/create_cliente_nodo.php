<?php
// Obtener el nodo_id de la URL si está presente
if (isset($_GET['nodo_id'])) {
    $nodo_id = $_GET['nodo_id'];
} else {
    echo "Error: nodo_id no proporcionado.";
    exit();
}
?>
<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Agregar Cliente al Nodo</h2>
            <form action="index.php?action=create_cliente_nodo&nodo_id=<?= $nodo_id; ?>" method="POST">
                <!-- Campo oculto para nodo_id -->
                <input type="hidden" name="nodo_id" value="<?= $nodo_id; ?>">    
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="form-group">
                    <label for="ip_cliente">IP Cliente:</label>
                    <input type="text" class="form-control" id="ip_cliente" name="ip_cliente">
                </div>
                <div class="form-group">
                    <label for="latitud">Latitud:</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" readonly>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud:</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" readonly>
                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                </div>
                
                <div id="map" style="height: 400px; width: 100%;"></div><br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluir la biblioteca de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Inicializar el mapa y centrarlo en una ubicación predeterminada
    var map = L.map('map').setView([-13.0692638462217, -76.3799947500229], 17);

    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    // Capa de Google Maps Satellite (requiere una clave de API de Google)
    var googleSat = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}&apikey=YOUR_GOOGLE_API_KEY', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.google.com/maps">Google</a>'
    });

    // Añadir OpenStreetMap como la capa por defecto
    osm.addTo(map);

    // Control de capas
    var baseMaps = {
        "OpenStreetMap": osm,
        "Google Satellite": googleSat
    };
    L.control.layers(baseMaps).addTo(map);

    // Agregar un marcador en una posición predeterminada
    var marker = L.marker([-13.0692638462217, -76.3799947500229], {draggable: true}).addTo(map);

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

    // Inicializar los campos de latitud y longitud con la posición predeterminada del marcador
    document.getElementById('latitud').value = marker.getLatLng().lat;
    document.getElementById('longitud').value = marker.getLatLng().lng;
</script>


<?php include('partials/footer.php'); ?>
