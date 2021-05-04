<?php


namespace app\models;


class CustomerDB
{
    public $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function add(Customer $customer)
    {
        $sql = "INSERT INTO my_mvc.customers (name, email, address) VALUES (?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $customer->name);
        $statement->bindValue(2, $customer->email);
        $statement->bindValue(3, $customer->address);
        return $statement->execute();
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM my_mvc.customers";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $customers = [];
        foreach ($result as $row) {
            $customer = new Customer($row['name'], $row['email'], $row['address']);
            $customer->id = $row['id'];
            $customers[] = $customer;
        }
        return $customers;
    }
    
    public function get($id)
    {
        $sql = "SELECT * FROM my_mvc.customers WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $row = $statement->fetch();
        $customer = new Customer($row['name'], $row['email'], $row['address']);
        $customer->id = $row['id'];
        return $customer;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM my_mvc.customers WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }
    
    public function update($id, $customer)
    {
        $sql = "UPDATE my_mvc.customers SET name = ?, email = ?, address = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $customer->name);
        $statement->bindParam(2, $customer->email);
        $statement->bindParam(3, $customer->address);
        $statement->bindParam(4, $id);
        return $statement->execute();
    }
}