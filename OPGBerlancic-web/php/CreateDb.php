<?php

class CreateDb {
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con;


    public function __construct(
        $dbname="Newdb",
        $tablename="Productdb",
        $servername="localhost",
        $username="root",
        $password=""
    )
    {
        $this->dbname=$dbname;
        $this->tablename=$tablename;
        $this->servername=$servername;
        $this->username=$username;
        $this->password=$password;

        $this->con=mysqli_connect($servername, $username, $password);

        if(!$this->con){
            die("Connection failed: ".mysqli_connect_error());
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        if(mysqli_query($this->con, $sql)){
            $this->con = mysqli_connect($servername, $username, $password, $dbname);

            $sql = " CREATE TABLE IF NOT EXISTS $tablename
                    (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                     product_name VARCHAR(20) NOT NULL,
                     product_price FLOAT,
                     product_image VARCHAR(100),
                     product_description VARCHAR(200)
                    );";

            if(!mysqli_query($this->con, $sql)){
                echo "Error creating table : " . mysqli_error($this->con);
            }
        }else{
            return false;
        }
    }
    public function getData(){
        $sql = "SELECT * FROM $this->tablename";

        $result = mysqli_query($this->con, $sql);

        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }
    public function getProductsData() {
        $sql = "SELECT * FROM $this->tablename";
        $result = mysqli_query($this->con, $sql);

        $productsData = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = [
                    'id' => $row['id'],
                    'name' => $row['product_name'],
                    'price' => $row['product_price'],
                    'desc' => $row['product_description'],
                    'img' => $row['product_image'],
                ];

                $productsData[] = $product;
            }
        }

        return $productsData;
    }
}