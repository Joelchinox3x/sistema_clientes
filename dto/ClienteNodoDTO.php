<?php
class ClienteNodoDTO {
    private $id;
    private $dni;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $direccion;
    private $ip_cliente;
    private $latitud;
    private $longitud;
    private $observaciones;
    private $nodo_id;

    public function __construct($dni, $nombres, $apellidos, $telefono, $direccion, $ip_cliente, $latitud, $longitud, $observaciones, $nodo_id, $id = null) {
        $this->id = $id;
        $this->dni = $dni;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->ip_cliente = $ip_cliente;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->observaciones = $observaciones;
        $this->nodo_id = $nodo_id;
    }

    // Getters y Setters para cada atributo
    public function getId() {
        return $this->id;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getIpCliente() {
        return $this->ip_cliente;
    }

    public function getLatitud() {
        return $this->latitud;
    }

    public function getLongitud() {
        return $this->longitud;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getNodoId() {
        return $this->nodo_id;
    }
    public function setId($id) {
        $this->id = $id;
    }
}
?>
