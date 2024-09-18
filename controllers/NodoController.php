<?php
include_once 'dao/NodoDAO.php';
include_once 'dto/NodoDTO.php';

class NodoController {
    private $nodoDAO;
    

    public function __construct() {
        $this->nodoDAO = NodoDAO::getInstance();       
    }

    public function createNodo($nombre, $latitud, $longitud, $username) {
        $nodo = new NodoDTO($nombre, $latitud, $longitud);
        $nodo->setUsername($username);  // Asignar el username al nodo
        return $this->nodoDAO->createNodo($nodo);
    }

     // Actualizar un nodo existente
     public function updateNodo($id, $nombre, $latitud, $longitud) {
        $nodo = new NodoDTO($nombre, $latitud, $longitud, $id);
        return $this->nodoDAO->updateNodo($nodo);
    }

    // Eliminar un nodo por su ID
    public function deleteNodo($id) {
        return $this->nodoDAO->deleteNodo($id);
    }

    // Obtener todos los nodos
    public function getAllNodos() {
        return $this->nodoDAO->getAllNodos();
    }

    public function getNodoById($id) {
        $nodo = $this->nodoDAO->getNodoById($id);
        // Verificar que el nodo pertenece al usuario logueado
        if ($nodo && $nodo['username'] === $_SESSION['username']) {
            return $nodo;  // Devolver el nodo si pertenece al usuario logueado
        } else {
            return null;  // Devolver null si el nodo no pertenece al usuario
        }
    }
    
    public function getNodosByUser($username) {
        return $this->nodoDAO->getNodosByUsername($username);
    }
}
?>
