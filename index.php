<?php

class ItemController
{
    protected $sql = 'SELECT * FROM items WHERE id = :id';
    protected $dbh;
    private $query = false;
    private $response = ['status', 'message'];

    public function __construct ($dsn, $user, $password)
    {
        //Database Connection
        try {
            $this->dbh = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function showItem($id)
    {
        switch($id){
            case 1:
            case 2:
                //Execution of the request
                $this->query = $this->getItem($this->sql, $id);

                $this->response = [
                    'status' => 200,
                    'message' => 'Succes Query' . "\n",
                ];

                break;
            case 3:
                $this->response =  [
                    'status' => 403,
                    'message' => 'Access Denied' . "\n",
                ];
                break;
            case 42:
                $this->response =  [
                    'status' => 200,
                    'message' => 'You have the job !' . "\n",
                ];
                break;
            default:
                $this->response =  [
                    'status' => 404,
                    'message' => 'Not Found' . "\n",
                ];
        }

        //Set Status Code
        http_response_code($this->response['status']);
        echo $this->response['message'];
        return $this->query;
    }

    public function getItem($sql, $id)
    {
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch();
    }
}

$test = new ItemController('mysql:dbname=test;host=127.0.0.1', 'root', '');
$test->showItem(2);