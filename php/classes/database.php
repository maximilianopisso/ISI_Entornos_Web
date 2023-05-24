<?php

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function disconnect() {
        $this->connection->close();
    }

    public function insertData($tableName, $data) {
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

        if ($this->connection->query($sql) === TRUE) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function getData($tableName, $condition = '') {
        $sql = "SELECT * FROM $tableName";

        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Manipulate the retrieved data as needed
                echo "ID: " . $row['id'] . ", Name: " . $row['nombre'] . ", Email: " . $row['email'] . "<br>";
            }
        } else {
            echo "No data found.";
        }
    }
}

// Crear una instancia de la clase Database
$database = new Database('localhost', 'usuario', 'contraseña', 'nombre_de_la_base_de_datos');

// Conectar a la base de datos
$database->connect();

// Ejemplo de inserción de datos
$data = [
    'nombre' => 'Juan',
    'email' => 'juan@example.com',
    'password' => '123456',
    // Agregar otros campos según la estructura de tu tabla
];
$database->insertData('nombre_de_la_tabla', $data);

// Ejemplo de obtención de datos
$database->getData('nombre_de_la_tabla', "nombre = 'Juan'");

// Desconectar de la base de datos
$database->disconnect();


class Database2
{
    private $host = "localhost";
    private $username = "tu_usuario";
    private $password = "tu_contraseña";
    private $database = "nombre_de_tu_base_de_datos";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function executeQuery($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error de preparación de consulta: " . $this->conn->error;
            return false;
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            return $stmt;
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }
    }

    // Ejemplo de inserción genérica
    public function insert($table, $data)
    {
        $keys = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $query = "INSERT INTO $table ($keys) VALUES ($values)";

        return $this->executeQuery($query, array_values($data));
    }

    // Ejemplo de actualización genérica
    public function update($table, $data, $condition)
    {
        $set = implode(" = ?, ", array_keys($data)) . " = ?";
        $query = "UPDATE $table SET $set WHERE $condition";

        return $this->executeQuery($query, array_values($data));
    }

    // Ejemplo de eliminación genérica
    public function delete($table, $condition)
    {
        $query = "DELETE FROM $table WHERE $condition";

        return $this->executeQuery($query);
    }

    // Ejemplo de consulta genérica
    public function select($table, $condition = "")
    {
        $query = "SELECT * FROM $table";

        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        return $this->executeQuery($query);
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}

?>


