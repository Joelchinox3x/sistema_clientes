<?php
include_once 'dao/ClienteNodoDAO.php';
include_once 'dto/ClienteNodoDTO.php';

class ClienteNodoController {
    private $clienteNodoDAO;

    public function __construct() {
        $this->clienteNodoDAO = ClienteNodoDAO::getInstance();
    }

    // Crear un nuevo cliente asociado a un nodo
    public function createClienteNodo($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, $nodo_id) {
        $clienteNodo = new ClienteNodoDTO($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, $nodo_id);
        return $this->clienteNodoDAO->createClienteNodo($clienteNodo);
    }

    // Actualizar un cliente existente
    public function updateClienteNodo($id, $dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones) {
        $clienteNodo = new ClienteNodoDTO($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, null);
        $clienteNodo->setId($id);  // Asignar el ID del cliente para actualizarlo
        return $this->clienteNodoDAO->updateClienteNodo($clienteNodo);
    }
    
    // Función que obtiene clientes si el nodo pertenece al usuario
    public function getClientesByNodoIdAndUsername($nodo_id, $username) {
        return $this->clienteNodoDAO->getClientesByNodoIdAndUsername($nodo_id, $username);
    }

    // Función para verificar la propiedad del nodo
    public function verifyNodoOwnership($nodo_id, $username) {
        return $this->clienteNodoDAO->verifyNodoOwnership($nodo_id, $username);
    }
    // Eliminar un cliente por su ID
    public function deleteClienteNodo($id) {
        return $this->clienteNodoDAO->deleteClienteNodo($id);
    }

    // Obtener todos los clientes asociados a un nodo
    public function getClientesByNodoId($nodo_id) {
        return $this->clienteNodoDAO->getClientesByNodoId($nodo_id);
    }

    // Obtener un cliente específico por su ID
    public function getClienteById($id) {
        $cliente = $this->clienteNodoDAO->getClienteById($id);
        return $cliente;  // Devolver el cliente sin restricción de usuario
    }
}
?>
