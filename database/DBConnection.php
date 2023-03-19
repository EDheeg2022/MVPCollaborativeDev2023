<?php

class DBConnection {
  
    private $_dbHostname = "localhost";
    private $_dbName = "test";
    private $_dbUsername = "root";
    private $_dbPassword = "";
    private $_con;
    public function __construct() {
    	try {
        	$this->_con = new PDO("mysql:host=$this->_dbHostname;dbname=$this->_dbName", $this->_dbUsername, $this->_dbPassword);    
        	$this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

    }
    public function returnConnection() {
        return $this->_con;
    }
}

class Cart 
{
    protected $db;
    private $_sku;

    public function setSKU($sku) {
        $this->_sku = $sku;
    }
	
    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }


    public function getAllProduct() {
    	try {
    		$sql = "SELECT * FROM products";
		    $stmt = $this->db->prepare($sql);

		    $stmt->execute();
		    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("Oh noes! There's an error in the query!");
		}
    }


    public function getProduct() {
    	try {
    		$sql = "SELECT * FROM products WHERE sku=:sku";
		    $stmt = $this->db->prepare($sql);
		    $data = [
		    	'sku' => $this->_sku
			];
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("Oh noes! There's an error in the query!");
		}
    }


}

$servername = "localhost";
$database = "test";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
	//die("Connection failed: " . mysqli_connect_error());
}
?>