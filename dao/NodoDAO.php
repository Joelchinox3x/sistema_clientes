<?php
include_once 'config/database.php';
include_once 'dto/NodoDTO.php';

class NodoDAO {
    private $conn;
    private $table_name = "nodos";
    private static $instance = null;

    private function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new NodoDAO();
        }
        return self::$instance;
    }

    public function createNodo(NodoDTO $nodo) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, latitud, longitud, username) VALUES (:nombre, :latitud, :longitud, :username)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nodo->getNombre());
        $stmt->bindParam(':latitud', $nodo->getLatitud());
        $stmt->bindParam(':longitud', $nodo->getLongitud());
        $stmt->bindParam(':username', $nodo->getUsername());  // Asignar el username del nodo
    
        return $stmt->execute();
    }
    

     // Actualizar un nodo existente
     public function updateNodo(NodoDTO $nodo) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, latitud = :latitud, longitud = :longitud WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nodo->getNombre());
        $stmt->bindParam(':latitud', $nodo->getLatitud());
        $stmt->bindParam(':longitud', $nodo->getLongitud());
        $stmt->bindParam(':id', $nodo->getId());
    
        return $stmt->execute();
    }

    // Eliminar un nodo por su ID
    public function deleteNodo($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function getNodosByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener todos los nodos
    public function getAllNodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un nodo por su ID
    public function getNodoById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
