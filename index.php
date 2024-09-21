<!-- para los iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php

session_start();   

include_once 'controllers/ClienteController.php';
include_once 'controllers/AuthController.php';
include_once 'controllers/NodoController.php';
include_once 'controllers/ClienteNodoController.php';
include_once 'includes/helpers.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Verificar si el usuario está logueado, excepto para las acciones de login y registro
if (!isset($_SESSION['user_id']) && $action !== 'login' && $action !== 'register') {
    header("Location: index.php?action=login");
    exit();
}

switch ($action) {
    case 'home':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        include 'views/home.php';
        break;

    case 'list':
        $controller = new ClienteController();
        $clientes = $controller->readAll();
        include 'views/list.php';
        break;
    
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new ClienteController();
            if ($controller->create($_POST['cedula'], $_POST['nombres'], $_POST['apellidos'], $_POST['direccion'], $_POST['latitud'], $_POST['longitud'])) {
                header("Location: index.php?action=list");
                exit;
            } else {
                echo "Error al guardar el cliente";
            }
        } else {
            include 'views/create.php';
        }
        break;
    
    case 'edit':
        if (isset($_GET['id'])) {
            include 'views/edit.php';
        } else {
            echo "Cliente no encontrado.";
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new ClienteController();
            if ($controller->update($_GET['id'], $_POST['cedula'], $_POST['nombres'], $_POST['apellidos'], $_POST['direccion'], $_POST['latitud'], $_POST['longitud'])) {
                header("Location: index.php?action=list");
                exit;
            } else {
                echo "Error al actualizar el cliente";
            }
        } else {
            echo "Método no permitido.";
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $controller = new ClienteController();
            if ($controller->delete($_GET['id'])) {
                header("Location: index.php?action=list");
                exit;
            } else {
                echo "Error al eliminar el cliente";
            }
        }
            break;

    case 'list_nodos':
        $nodoController = new NodoController();
        $nodos = $nodoController->getNodosByUser($_SESSION['username']);  // Obtener nodos del usuario logueado
        include 'views/list_nodos.php';
        break;

    case 'create_nodo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nodoController = new NodoController();
            $username = $_SESSION['username']; // Obtener el nombre de usuario desde la sesión
            if ($nodoController->createNodo(
                $_POST['nombre'], 
                $_POST['latitud'], 
                $_POST['longitud'], 
                $username
            )) {
                header("Location: index.php?action=list_nodos");
                exit();
            } else {
                echo "Error al crear el nodo.";
            }
        } else {
            include 'views/create_nodo.php';
        }
        break;
  
    case 'edit_nodo':
        if (isset($_GET['id'])) {
            $nodoController = new NodoController();
            $nodo = $nodoController->getNodoById($_GET['id']);
            
            // Verificar si el nodo pertenece al usuario logueado
            if ($nodo && $nodo['username'] === $_SESSION['username']) {
                include 'views/edit_nodo.php'; // Permitir editar si el nodo pertenece al usuario
            } else {
                echo "No tienes permiso para ver este nodo."; // Mostrar mensaje si no le pertenece
            }
        } else {
            echo "Nodo no encontrado.";
        }
        break;
    
    case 'update_nodo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nodoController = new NodoController();
            $nodo = $nodoController->getNodoById($_GET['id']);
    
            if ($nodo && $nodo['username'] === $_SESSION['username']) { // Verificar que el nodo pertenece al usuario logueado
                if ($nodoController->updateNodo($_GET['id'], $_POST['nombre'], $_POST['latitud'], $_POST['longitud'])) {
                    header("Location: index.php?action=list_nodos");
                    exit();
                } else {
                    echo "Error al actualizar el nodo.";
                }
            } else {
                echo "No tienes permiso para actualizar este nodo.";
            }
        } else {
            echo "Método no permitido.";
        }
        break;
    
    case 'delete_nodo':
        if (isset($_GET['id'])) {
            $nodoController = new NodoController();
            if ($nodoController->deleteNodo($_GET['id'])) {
                header("Location: index.php?action=list_nodos");
                exit();
            } else {
                echo "Error al eliminar el nodo.";
            }
        }
        break;

    case 'list_clientes_nodo':
        if (isset($_GET['nodo_id'])) {
            $nodo_id = $_GET['nodo_id'];
            $nodoController = new NodoController();
            
            // Obtener el nodo asociado y verificar que pertenece al usuario logueado
            $nodo = $nodoController->getNodoById($nodo_id);
    
            if (!$nodo || $nodo['username'] !== $_SESSION['username']) {
                // Si el nodo no existe o no pertenece al usuario logueado, mostrar mensaje de error
                echo "No tienes permiso para acceder a este nodo.";
                exit();
            }
    
            // Si el nodo pertenece al usuario, obtener los clientes asociados
            $clienteNodoController = new ClienteNodoController();
            $clientes = $clienteNodoController->getClientesByNodoId($nodo_id);  // Obtener clientes por nodo
    
            // Incluir la vista de lista de clientes
            include 'views/list_cliente_nodo.php';
        } else {
            echo "Error: nodo_id no proporcionado.";
            exit();
        }
        break;

    case 'create_cliente_nodo':
        // Verificar si el nodo_id está presente en la URL
        if (isset($_GET['nodo_id'])) {
            $nodo_id = $_GET['nodo_id']; // Obtener nodo_id de la URL
            $nodoController = new NodoController(); // Instancia para verificar propiedad del nodo
            
            // Obtener el nodo asociado y verificar que pertenece al usuario logueado
            $nodo = $nodoController->getNodoById($nodo_id);
    
            if (!$nodo || $nodo['username'] !== $_SESSION['username']) {
                // Si el nodo no existe o no pertenece al usuario logueado, mostrar mensaje de error
                echo "No tienes permiso para acceder a este nodo.";
                exit();
            }
        } else {
            echo "Error: nodo_id no proporcionado.";
            exit();
        }
    
        // Procesar la creación del cliente si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clienteNodoController = new ClienteNodoController();
    
            // Crear cliente y asociarlo al nodo
            if ($clienteNodoController->createClienteNodo(
                $_POST['dni'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['telefono'],
                $_POST['direccion'],
                $_POST['ip_cliente'],
                $_POST['latitud'],
                $_POST['longitud'],
                $_POST['observaciones'],
                $nodo_id  // Pasar el nodo_id desde la URL
            )) {
                // Redirigir a la lista de clientes del nodo
                header("Location: index.php?action=list_clientes_nodo&nodo_id=$nodo_id");
                exit();
            } else {
                echo "Error al crear el cliente.";
            }
        } else {
            // Cargar la vista de creación de cliente, pasando nodo_id a la vista
            include 'views/create_cliente_nodo.php';
        }
        break;

    case 'edit_cliente_nodo':
        // Lógica para editar un cliente
        if (isset($_GET['id'])) {
            $clienteNodoController = new ClienteNodoController();
            $nodoController = new NodoController(); // Para verificar la propiedad del nodo
            
            // Obtener los datos del cliente
            $cliente = $clienteNodoController->getClienteById($_GET['id']);
            
            if ($cliente) {
                // Obtener el nodo asociado al cliente
                $nodo = $nodoController->getNodoById($cliente['nodo_id']);
    
                // Verificar si el nodo pertenece al usuario logueado
                if ($nodo && $nodo['username'] === $_SESSION['username']) {
                    // Mostrar el formulario de edición si el nodo pertenece al usuario
                    include 'views/edit_cliente_nodo.php';
                } else {
                    // Mostrar mensaje de acceso denegado si el nodo no pertenece al usuario
                    echo "No tienes permiso para editar este cliente.";
                }
            } else {
                echo "Cliente no encontrado.";
            }
        } else {
            echo "ID de cliente no proporcionado.";
        }
        break;

    case 'update_cliente_nodo':
        // Actualizar un cliente existente (esto puede combinarse con edit_cliente_nodo)
        $clienteNodoController = new ClienteNodoController();
        $clienteNodoController->updateClienteNodo(
            $_GET['id'],
            $_POST['dni'],
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['telefono'],
            $_POST['direccion'],
            $_POST['ip_cliente'],
            $_POST['latitud'],
            $_POST['longitud'],
            $_POST['observaciones']
        );
        header('Location: index.php?action=list_clientes_nodo&nodo_id=' . $_POST['nodo_id']);
        break;

    case 'delete_cliente_nodo':
        // Lógica para eliminar un cliente
        if (isset($_GET['id']) && isset($_GET['nodo_id'])) {
            $clienteNodoController = new ClienteNodoController();
            $clienteNodoController->deleteClienteNodo($_GET['id']);
            header('Location: index.php?action=list_clientes_nodo&nodo_id=' . $_GET['nodo_id']);
        } else {
            echo "Error: id o nodo_id no proporcionado.";
        }
        break;
        

    case 'list_by_distance': //Listar clientes por distancia
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lat = $_POST['latitud'];
            $lon = $_POST['longitud'];
            if (!empty($lat) && !empty($lon)) {
                $controller = new ClienteController();
                $clientes = $controller->listByDistance($lat, $lon);
                include 'views/list.php';
            } else {
                // Mostrar una alerta si la latitud o longitud están vacías
                $error_message = "Por favor seleccione una ubicación en el mapa para calcular las distancias. Haga clic en el mapa para seleccionar un punto.";
                include 'views/list.php';
            }
        } else {
            header("Location: index.php?action=list");
            exit;
        }
        break;

    case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController = new AuthController();
                if ($authController->login($_POST['username'], $_POST['password'])) {
                    header("Location: index.php?action=home");
                    exit();
                } else {
                    $error_message = "Nombre de usuario o contraseña incorrectos.";
                    include 'views/login.php';
                }
            } else {
                include 'views/login.php';
            }
            break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController = new AuthController();
            if ($authController->register($_POST['username'], $_POST['password'])) {
                header("Location: index.php?action=login");
                exit();
            } else {
                $error_message = "El usuario ya existe o hubo un error.";
                include 'views/register.php';
            }
        } else {
            include 'views/register.php';
        }
        break;

    case 'logout':
        // Cerrar sesión
        session_destroy();
        header("Location: index.php?action=login");
        exit();
        break;
    
    default:
        include 'views/home.php';
        break;
}
?>
