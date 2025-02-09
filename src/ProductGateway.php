<?php

class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getPdoConnection();
    }

    /**
     * @return array
     */
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

    /**
     * @param array $data
     * @return bool|string
     */
    public function create(array $data): bool|string
    {
        $name = empty($data["name"]) ? 0 : $data["name"];
        $size = empty($data["size"]) ? 0 : $data["size"];
        $is_available = empty($data["is_available"]) ? 0 : $data["is_available"];

        $query = "INSERT INTO product (name, size, is_available)
                    VALUES (:name, :size, :is_available);";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":size", $size, PDO::PARAM_INT);
        $stmt->bindValue(":is_available", $is_available, PDO::PARAM_BOOL);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    /**
     * @param string $id
     * @return array|bool
     */
    public function getProductWithId(string $id): array|bool
    {
        $query = "SELECT * FROM product WHERE id = :id;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data !== false) {
            $data['is_available'] = (bool) $data['is_available'];
        }

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $name = $new["name"] ?? $current["name"];
        $size = $new["size"] ?? $current["size"];
        $is_available = $new["is_available"] ?? $current["is_available"];

        $query = "UPDATE product 
                    SET name = :name, size = :size, is_available = :is_available
                    WHERE id = :id;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $name , PDO::PARAM_STR);
        $stmt->bindValue(":size", $size, PDO::PARAM_INT);
        $stmt->bindValue(":is_available", $is_available, PDO::PARAM_BOOL);
        $stmt->bindValue(":id", $current['id'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param string $id
     * @return int
     */
    public function delete(string $id): int
    {
        $query = "DELETE FROM product WHERE id = :id;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}