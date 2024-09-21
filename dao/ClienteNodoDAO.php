<?php
include_once 'config/database.php';
include_once 'dto/ClienteNodoDTO.php';

class ClienteNodoDAO {
    private $conn;
    private $table_name = "clientes_nodo";
    private static $instance = null;

    private function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new ClienteNodoDAO();
        }
        return self::$instance;
    }

    //CRUD

    public function createClienteNodo(ClienteNodoDTO $cliente) {
        $query = "INSERT INTO " . $this->table_name . " (dni, nombres, apellidos, telefono, direccion, ip_cliente, latitud, longitud, observaciones, nodo_id) 
                  VALUES (:dni, :nombres, :apellidos, :telefono, :direccion, :ip_cliente, :latitud, :longitud, :observaciones, :nodo_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $cliente->getDni());
        $stmt->bindParam(':nombres', $cliente->getNombres());
        $stmt->bindParam(':apellidos', $cliente->getApellidos());
        $stmt->bindParam(':telefono', $cliente->getTelefono());
        $stmt->bindParam(':direccion', $cliente->getDireccion());
        $stmt->bindParam(':ip_cliente', $cliente->getIpCliente());
        $stmt->bindParam(':latitud', $cliente->getLatitud());
        $stmt->bindParam(':longitud', $cliente->getLongitud());
        $stmt->bindParam(':observaciones', $cliente->getObservaciones());
        $stmt->bindParam(':nodo_id', $cliente->getNodoId());

        return $stmt->execute();
    }

    // Eliminar un cliente por su ID
    public function deleteClienteNodo($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

     // Actualizar un cliente existente
     public function updateClienteNodo(ClienteNodoDTO $cliente) {
        $query = "UPDATE " . $this->table_name . " 
                  SET dni = :dni, nombres = :nombres, apellidos = :apellidos, telefono = :telefono, direccion = :direccion, ip_cliente = :ip_cliente, latitud = :latitud, longitud = :longitud, observaciones = :observaciones 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $cliente->getDni());
        $stmt->bindParam(':nombres', $cliente->getNombres());
        $stmt->bindParam(':apellidos', $cliente->getApellidos());
        $stmt->bindParam(':telefono', $cliente->getTelefono());
        $stmt->bindParam(':direccion', $cliente->getDireccion());
        $stmt->bindParam(':ip_cliente', $cliente->getIpCliente());
        $stmt->bindParam(':latitud', $cliente->getLatitud());
        $stmt->bindParam(':longitud', $cliente->getLongitud());
        $stmt->bindParam(':observaciones', $cliente->getObservaciones());
        $stmt->bindParam(':id', $cliente->getId());

        return $stmt->execute();
    }
    
    public function getClientesByNodoId($nodo_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nodo_id = :nodo_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nodo_id', $nodo_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un cliente por su ID
    public function getClienteById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);  
    }
}
?>
