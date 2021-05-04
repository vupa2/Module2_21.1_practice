<?php


namespace app\controllers;


use app\models\Customer;
use app\models\CustomerDB;
use app\models\DBConnection;

class CustomerController
{
    public $customerDB;
    
    public function __construct()
    {
        $connection = new DBConnection();
        $this->customerDB = new CustomerDB($connection->connect());
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            
            $customer = new Customer($name, $email, $address);
            
            if ($this->customerDB->add($customer)) {
                $message = 'Customer added';
            }
        }
        
        include_once __DIR__ . '/../views/add.php';
    }
    
    public function index()
    {
        $customers = $this->customerDB->getAll();
        include_once __DIR__ . '/../views/list.php';
    }
    
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $customer = $this->customerDB->get($id);
            include_once __DIR__ . '/../views/delete.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->customerDB->delete($id);
            header('Location: index.php');
            exit;
        }
    }
    
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $customer = $this->customerDB->get($id);
            include_once __DIR__ . '/../views/edit.php';
        } else {
            $id = $_POST['id'];
            $customer = new Customer($_POST['name'], $_POST['email'], $_POST['address']);
            $this->customerDB->update($id, $customer);
            header('Location: index.php');
            exit;
        }
    }
}