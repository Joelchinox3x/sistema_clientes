<?php
include_once 'dao/ClienteNodoDAO.php';
include_once 'dto/ClienteNodoDTO.php';

class ClienteNodoController {
    private $clienteNodoDAO;

    public function __construct() {
        $this->clienteNodoDAO = ClienteNodoDAO::getInstance();
    }

    public function createCliente($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, $nodo_id) {
        $cliente = new ClienteNodoDTO($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, $nodo_id);
        return $this->clienteNodoDAO->createCliente($cliente);
    }

    public function getClientesByNodoId($nodo_id) {
        return $this->clienteNodoDAO->getClientesByNodoId($nodo_id);
    }
}
?>
