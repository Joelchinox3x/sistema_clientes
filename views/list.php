    <?php include('partials/header.php'); ?>
    <?php include('partials/navbar.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Alerta de error -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                 <!-- Mapa -->
                 <div id="map" style="height: 600px; width: 100%;" class="mb-4"></div>
                <h2 class="mb-4 text-center">Lista de Clientes</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                            <th>Distancia (km)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($clientes)) {
                            foreach ($clientes as $cliente) {
                                echo "<tr>";
                                echo "<td>{$cliente['cedula']}</td>";
                                echo "<td>{$cliente['nombres']}</td>";
                                echo "<td>{$cliente['apellidos']}</td>";
                                echo "<td>{$cliente['direccion']}</td>";
                                echo "<td>{$cliente['latitud']}</td>";
                                echo "<td>{$cliente['longitud']}</td>";
                                if (isset($cliente['distance'])) {
                                    echo "<td>{$cliente['distance']}</td>";
                                } else {
                                    echo "<td>-</td>";
                                }
                                echo "<td>";
                                echo "<a href='index.php?action=edit&id={$cliente['id']}' class='btn btn-warning btn-sm'><i class='fas fa-pencil-alt'></i></a> ";
                                echo "<a href='index.php?action=delete&id={$cliente['id']}' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
    
            
                <!-- Formulario -->
                <form action="index.php?action=list_by_distance" method="POST" class="text-center">
                    <input type="hidden" id="latitud" name="latitud">
                    <input type="hidden" id="longitud" name="longitud">
                    <button type="submit" class="btn btn-primary">Consultar por Distancia</button>
                </form>
               
            </div>
        </div>
    </div>


    <?php include('partials/footer.php'); ?>

    <!-- Incluir la biblioteca de Leaflet para el mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="assets/css/leaflet.awesome-markers.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="assets/js/leaflet.awesome-markers.js"></script>
    
    <script>
         // Convertir el arreglo de clientes a formato JSON para pasarlo al script JavaScript
         var clientes = <?php echo json_encode($clientes); ?>;
      
        // Inicializar el mapa y centrarlo en una ubicación predeterminada
        var map = L.map('map').setView([-13.0692638462217, -76.3799947500229], 17);

        // Capa de Google Maps Satellite (necesitarás una clave de API de Google)
        L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}&apikey=YOUR_GOOGLE_API_KEY', {maxZoom: 20,attribution: 'Map data &copy; <a href="https://www.google.com/maps">Google</a>'}).addTo(map);

       
        var markerq = L.marker([-13.067926123370249, -76.37828886508943], {draggable: true}).addTo(map);
        markerq.bindPopup("<b>Cliente: </b><?php echo $cliente['nombres'] . ' ' . $cliente['apellidos']; ?><br><b>Dirección: </b><?php echo $cliente['direccion']; ?>", {
                    maxWidth: 200,
                    closeButton: false,
                    autoClose: false
                });
    
// Font-Awesome markers
var marker12 = L.marker([-13.06828,-76.38186], {icon: L.AwesomeMarkers.icon({icon: 'bookmark', markerColor: 'green', prefix: 'fa', iconColor: 'black', spin:false}),draggable: true }).addTo(map);
    marker12.bindPopup("<b>Cliente: </b><?php echo $cliente['nombres'] . ' ' . $cliente['apellidos']; ?><br><b>Dirección: </b><?php echo $cliente['direccion']; ?>", {
                    maxWidth: 200,
                    closeButton: false,
                    autoClose: false,
                    className: "custom-popup"
                });
        // Actualizar los campos de latitud y longitud cuando el marcador se mueva
        marker12.on('dragend', function(e) {
                    var latlng = marker12.getLatLng();
                    document.getElementById('latitud').value = latlng.lat;
                    document.getElementById('longitud').value = latlng.lng;
                });

                map.on('click', function(e) {
                    marker12.setLatLng(e.latlng);
                    document.getElementById('latitud').value = e.latlng.lat;
                    document.getElementById('longitud').value = e.latlng.lng;
                });

             //   var popup = L.popup().setLatLng([-13.06822,-76.38180]).setContent("Casa Chibolin popup.").openOn(map);
             //   var popup = L.popup([-13.06822,-76.38180], {content: '<p>Hello world!<br />This is a nice popup.</p>'}).openOn(map);
// create popup contents
var popupContent = "<b>Hello world!</b><br />I am a popup.";

// specify popup options
var popupOptions = {
  maxWidth: "500",
  className: "another-popup"
};
L.marker([-13.06822,-76.38080]).addTo(map).bindPopup(popupContent, popupOptions);
 

 // Definir el ícono personalizado fuera del foreach
var redMarker = L.AwesomeMarkers.icon({
    icon: "wifi", // Puedes cambiar este ícono por otro
    markerColor: 'red', // Color del marcador
    iconColor: 'white',  // Color del ícono
    prefix: 'fa'
});

// Agregar los marcadores de cada cliente
clientes.forEach(function(cliente) {
    if (cliente.latitud && cliente.longitud) {
        var marker = L.marker([cliente.latitud, cliente.longitud], {icon: redMarker, draggable: true}).addTo(map);
        marker.bindPopup(`
             <div>
                <b>Cliente: </b>${cliente.nombres} ${cliente.apellidos}<br>
                <b>Dirección: </b>${cliente.direccion}<br>
                <img src='URL_DE_LA_IMAGEN' alt='Foto del Cliente'><br>
                <a href='https://www.example.com' target='_blank'>Más información</a>
            </div>
        `, {
            maxWidth: 200,
            closeButton: false,
            autoClose: false,
            className: 'custom-popup' 
        });
    }
});
 
 
    </script>
