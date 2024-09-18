<?php include('partials/header.php'); ?>
<?php include('partials/navbar.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Agregar Cliente</h2>
            <form action="index.php?action=create" method="POST">
                <div class="form-group">
                    <label for="cedula">DNI:</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" required>
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
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="form-group">
                    <label for="latitud">Latitud:</label>
                    <input type="text" class="form-control" id="latitud" name="latitud" readonly>
                </div>
                <div class="form-group">
                    <label for="longitud">Longitud:</label>
                    <input type="text" class="form-control" id="longitud" name="longitud" readonly>
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

    // Capa de Mapbox Streets (necesitarás una clave de API de Mapbox para esto)
    var mapboxStreets = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=YOUR_MAPBOX_ACCESS_TOKEN', {
        maxZoom: 19,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://www.mapbox.com/">Mapbox</a>'
    });

        // Capa de Google Maps Satellite (necesitarás una clave de API de Google)
        var googleSat = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}&apikey=YOUR_GOOGLE_API_KEY', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.google.com/maps">Google</a>'
    });

    // Capa de Bing Maps (necesitarás una clave de API de Bing)
    var bingMaps = L.tileLayer('https://dev.virtualearth.net/REST/V1/Imagery/Metadata/Aerial?output=json&key=YOUR_BING_API_KEY', {
        maxZoom: 22,
        attribution: 'Map data &copy; <a href="https://www.bing.com/maps">Bing</a>'
    });

    // Añadir OpenStreetMap como la capa por defecto
    googleSat.addTo(map);

    // Añadir una capa de control para alternar entre capas
    var baseMaps = {
        "OpenStreetMap": osm,
        "Mapbox Streets": mapboxStreets,
        "Google Satellite": googleSat,
        "Bing Maps Aerial": bingMaps
    };

    // Control de capas
    L.control.layers(baseMaps).addTo(map);

    var marker0 = L.marker([-13.068470533518973, -76.38100661337376], {draggable: false}).addTo(map);
    var marker1 = L.marker([-13.068735726614573, -76.38142235577106], {draggable: false}).addTo(map);
    var marker2 = L.marker([-13.06861031513689, -76.38141833245754], {draggable: false}).addTo(map);

    // Actualizar los campos de latitud y longitud cuando se mueva el marcador
    marker0.on('dragend', function(e) {
        var latlng = marker0.getLatLng();
        document.getElementById('latitud').value = latlng.lat;
        document.getElementById('longitud').value = latlng.lng;
    });

    // Permitir que el usuario agregue un nuevo marcador haciendo clic en el mapa
    map.on('click', function(e) {
        marker1.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });

 

</script>

<?php include('partials/footer.php'); ?>
