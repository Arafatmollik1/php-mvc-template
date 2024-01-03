<?php
namespace Src\Utility;
use Src\Helper\Connection;
class SqlBuilder {
    private $query = '';
    private $type = '';
    private $data = [];
    private $condition = '';
    private $tableName = '';
    private $selectColumns = '*'; // Define selectColumns here with a default value

    public function create($data) {
        $this->type = 'INSERT';
        $this->data = $data;
        return $this;
    }

    public function read($columns) {
        $this->type = 'SELECT';
        $this->selectColumns = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }

    public function update($data) {
        $this->type = 'UPDATE';
        $this->data = $data;
        return $this;
    }

    public function delete() {
        $this->type = 'DELETE';
        return $this;
    }

    public function where($condition) {
        $this->condition = $condition;
        return $this;
    }

    public function from($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function execute() {
        $connection = Connection::getInstance();
        $database = $connection->getDatabase();
    
        // Prepare the statement
        $stmt = $database->prepare($this->getSQL());
    
        if ($stmt === false) {
            // Handle any query preparation errors here
            $errorMessage = $database->error;
            throw new \Exception("Query preparation error: $errorMessage");
        }
    
        // Check if it's not a DELETE or SELECT query before binding parameters
        if ($this->type !== 'DELETE' && $this->type !== 'SELECT') {
            // Bind the parameters to the statement with appropriate types
            $params = [];
            $types = '';
            foreach ($this->data as $key => $value) {
                // Determine the appropriate type based on the data type of the value
                if (is_int($value)) {
                    $types .= 'i'; // Integer
                } elseif (is_float($value)) {
                    $types .= 'd'; // Double
                } else {
                    $types .= 's'; // String (default)
                }
                $params[] = &$this->data[$key]; // Create a reference to the value
            }
    
            array_unshift($params, $types);
            call_user_func_array([$stmt, 'bind_param'], $params);
        }
    
        // Execute the statement
        $result = $stmt->execute();
    
        if ($result === false) {
            // Handle any query execution errors here
            $errorMessage = $stmt->error;
            throw new \Exception("Query execution error: $errorMessage");
        }
    
        // Get the result set (if applicable)
        $resultSet = $stmt->get_result();
    
        if ($resultSet === false) {
            // Handle cases where there is no result set (e.g., for INSERT, UPDATE queries)
            // You can return a success message or handle it as needed.
            return true;
        }
    
        // Fetch all rows from the result set as associative arrays
        $data = [];
        while ($row = $resultSet->fetch_assoc()) {
            $data[] = $row;
        }
    
        $stmt->close(); // Close the prepared statement
    
        return $data;
    }
    
    
    

    public function getSQL()
    {
        switch ($this->type) {
            case 'INSERT':
                // Build INSERT query with prepared statement
                if (empty($this->data)) {
                    throw new \Exception('No data provided for INSERT query');
                }
                $columns = implode(', ', array_keys($this->data));
                $placeholders = implode(', ', array_map(function ($key) {
                    return "?"; // Use question mark as a placeholder
                }, array_keys($this->data)));
                $this->query = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";
                break;
            case 'SELECT':
                // Build SELECT query with prepared statement
                if (empty($this->selectColumns)) {
                    throw new \Exception('No columns specified for SELECT query');
                }
                $columns = is_array($this->selectColumns) ? implode(', ', $this->selectColumns) : $this->selectColumns;
                $this->query = "SELECT {$columns} FROM {$this->tableName}";
                if (!empty($this->condition)) {
                    $this->query .= " WHERE {$this->condition}";
                }
                break;
            case 'UPDATE':
                // Build UPDATE query with prepared statement
                if (empty($this->data)) {
                    throw new \Exception('No data provided for UPDATE query');
                }
                $setClause = implode(', ', array_map(function ($key) {
                    return "$key = ?"; // Use question mark as a placeholder
                }, array_keys($this->data)));
                $this->query = "UPDATE {$this->tableName} SET {$setClause}";
                if (!empty($this->condition)) {
                    $this->query .= " WHERE {$this->condition}";
                }
                break;
            case 'DELETE':
                // Build DELETE query with prepared statement
                $this->query = "DELETE FROM {$this->tableName}";
                if (!empty($this->condition)) {
                    $this->query .= " WHERE {$this->condition}";
                }
                break;
            default:
                throw new \Exception('Invalid query type');
        }
    
        return $this->query;
    }
    
}
//example
/*     $crudify = new SqlBuilder();
    $insert = [
      'id' => '02',
      'userId' => 'sadasda',
      'email' => 'mollik@mollik.com',
      'name' => 'mollik'
    ];
    $update = [
      'id' => '03',
    ]; */
    // $result = $crudify->create($insert)->from('users')->execute();
    // $result = $crudify->read('*')->from('users')->where("id='02'")->execute();
    // $result = $crudify->update($update)->from('users')->where("id='02'")->execute();
    // $result = $crudify->read('*')->from('users')->execute();
    // $result = $crudify->delete()->from('users')->where("id = '03'")->execute();
    // $result = $crudify->read('*')->from('users')->execute(); 
/*     echo "<pre>";
    var_dump($result);
    echo "</pre>"; */
