<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    // private $username = 'root'; // e.g. 'your_db_user'
    // private $password = 'abcd'; // e.g. 'your_db_password'
    // private $dbName = 'job_db'; // e.g. 'your_db_name'
    // private $instanceUnixSocket = '/cloudsql/endpoint'; 

    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        //set DSN
        // $dsn = sprintf(
        //     'mysql:dbname=%s;unix_socket=%s',
        //     $this->dbName,
        //     $this->instanceUnixSocket
        // );
        $dsn = sprintf(
            'mysql:dbname=%s;unix_socket=%s',
            $this->dbname,
            $this->host
        );

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //PDO instance
        try {
            // $pdo = new PDO("mysql:host=$host; dbname=$dbname;", $user, $pass);
            // $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            $this->dbh = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                // $this->username,
                // $this->password,
                $options
            );
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);

        // try {
        //     $this->stmt = $this->dbh->prepare($query);
        // } catch (PDOException $e) {
        //     $this->error = $e->getMessage();
        //     // var_dump($e);
        // }
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}
