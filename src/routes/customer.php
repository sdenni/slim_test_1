<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET ALL COSTOMERS
$app->get('/api/customers', function(Request $request, Response $response){
    // echo "customers";
    $sql = "SELECT * FROM customers";
    try{
        // GET DB
        $db = new db();
        // CONNECT
        $db = $db->connect();

        $stmt = $db->query($sql);

        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($customers);
    } catch (PDOException $e) {
        echo '{"error": {"message": '.$e->getMessage().'}';
    }
});

// GET SINGLE COSTUMERS
$app->get('/api/customers/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    // echo "customers";
    $sql = "SELECT * FROM customers WHERE customers.id = $id";
    try{
        // GET DB
        $db = new db();
        // CONNECT
        $db = $db->connect();

        $stmt = $db->query($sql);

        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($customer);
    } catch (PDOException $e) {
        echo '{"error": {"message": '.$e->getMessage().'}}';
    }
});

$app->post('/api/customers/add', function(Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) 
    VALUES(:first_name,:last_name,:phone,:email,:address,:city,:state)";
    try{
        // GET DB
        $db = new db();
        // CONNECT
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"message": "Customer Added"}}';
    } catch (PDOException $e) {
        echo '{"error": {"message": '.$e->getMessage().'}';
    }
});

$app->put('/api/customers/update/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttributes('id');

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE customers SET 
    first_name = :first_name ,
    last_name = :last_name,
    phone = :phone, 
    email = :email,
    address = :address,
    city = :city, 
    state = :state 
    WHERE id = :id";
    try{
        // GET DB
        $db = new db();
        // CONNECT
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        echo '{"notice": {"message": "Customer Updated"}}';
    } catch (PDOException $e) {
        echo '{"error": {"message": '.$e->getMessage().'}';
    }
});

$app->get('/api/customers/delete/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    // echo "customers";
    $sql = "DELETE FROM customers WHERE customers.id = $id";
    try{
        // GET DB
        $db = new db();
        // CONNECT
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;

        echo '{"notice": {"message": "Customer DELETED"}}';
    } catch (PDOException $e) {
        echo '{"error": {"message": '.$e->getMessage().'}}';
    }
});