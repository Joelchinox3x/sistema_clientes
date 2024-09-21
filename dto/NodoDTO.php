<?php
class NodoDTO {
    private $id;
    private $nombre;
    private $latitud;
    private $longitud;
    private $username;  // Agregamos el atributo username

    public function __construct($nombre, $latitud, $longitud, $id = null, $username = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->username = $username; // Inicializamos el username si es proporcionado
    }

    // Getters y Setters para cada atributo
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getLatitud() {
        return $this->latitud;
    }

    public function getLongitud() {
        return $this->longitud;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

  
}
?>

