<?php

class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getPdoConnection();
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM `product`;";
        $stmt = $this->conn->query($query);

        $data = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $row['is_available'] = (bool) $row['is_available'];
            $data[] = $row;
        }

        return $data;
    }
}