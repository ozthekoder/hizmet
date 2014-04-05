<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBManager
 *
 * @author osman
 */
class DBManager extends Module
{
    public $db;
    public function __construct() {
    }
    
    private function openConnection()
    {
        try { 
            $this->db = new PDO('mysql:host=' . DB_HOST. ';dbname=' . DB_NAME . '', DB_USER, DB_PASSWORD);
            $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return true;
        }  
        catch(PDOException $e) {  
            echo $e->getMessage();  
            return false;
        }  
    }
    
    private function closeConnection()
    {
        try { 
            $this->db = null; 
            return true;
        }  
        catch(PDOException $e) {  
            echo $e->getMessage();  
            return false;
        }  
    }
    
    public function load()
    {
        return $this->openConnection();
    }
    
    public function query($sql)
    {
        try { 
            $stmt = $this->db->query($sql);
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($result)
            {
                $rows = array();
                while($row = $stmt->fetch())
                {
                    $rows[] = $row;
                }
                
                return $rows;
            }
            return false;
        }  
        catch(PDOException $e) {  
            echo $e->getMessage();  
            return false;
        }  
        
    }
    
    public function createObjectClassFromTable($tableName)
    {
        
        $fileName = "./objects/$tableName.php";
        $handle = fopen($fileName, 'w') or die('Cannot open file:  '.$fileName); //implicitly creates file
        
        
        $tableInfo = $this->query('describe ' . $tableName);
        $vars = array();
        foreach($tableInfo as $field)
        {
            $vars[] = $field['Field'];
        }
        
        
        
        $class =
'<?php
    
class ' . $tableName . ' extends Object
{
    ';
foreach($vars as $var)
{
    $class .= "public $$var;
    ";
}
 $class .= '
}
?>
';
         
        fwrite($handle, $class);
        return $tableInfo;
    }
    
    public function select($tableName, $params)
    {
        $params = array_filter($params);
        $count = count($params);
        $i=0;
        $sql = "SELECT * FROM $tableName WHERE ";
        foreach ($params as $k => $v)
        {
            $i++;
            $sql .= "$k = $k";
            if($i < $count)
            {
                $sql .= ' AND ';
            }
        }
        $statement = $this->db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);  
        $statement->execute($params);
        
        if($result = $statement->fetch())
        {
            return new $tableName($result);
        }
        
        return false; 
    }
    
    public function selectAll($tableName, $params)
    {
        $params = array_filter($params);
        $count = count($params);
        $i=0;
        $sql = "SELECT * FROM $tableName";
        $statement = $this->db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);  
        $statement->execute($params);
        $all = array();
        while($result = $statement->fetch())
        {
            $obj =  new $tableName($result);
            $all[] = $obj;
        }
        
        return $all;
        
        return false; 
    }
    
    public function insert($tableName, $params)
    {
        $params = array_filter($params);
        $insertString = '';
        $valueString = '';
        foreach($params as $key=>$val)
        {
            $insertString .= " $key,";
            $valueString .= " :$key,";
        }
        $insertString = substr($insertString, 0, -1);
        $valueString = substr($valueString, 0, -1);
        $sql = "INSERT INTO $tableName ($insertString) VALUES($valueString)";

        $statement = $this->db->prepare($sql);
        $result = $statement->execute($params);
        if($result)
        {
            if($object = $this->select($tableName, array('id' => $this->db->lastInsertId())))
            {
                return $object;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    public function update($tableName, $params)
    {
        $params = array_filter($params);
        $count = count($params);
        $i=0;
        $sql = "UPDATE $tableName ";
        foreach ($params as $k => $v)
        {
            $i++;
            $sql .= "$k = :$k ";
            if($i < $count)
            {
                $sql .= ', ';
            }
        }
        $id = $params['id'];
        $sql .= "WHERE id = $id";
        $statement = $this->db->prepare($sql);
        if($statement->execute($params))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getModuleBlocks($moduleName)
    {
        $id = $this->getModuleId($moduleName);
        $sql = "";
        $blocks = $this->query($sql);
        
    }
    
    public function getModuleId($moduleName)
    {
        $params = array(':name' => $moduleName);
        $sql = "SELECT * FROM Module WHERE name=name";
        $statement = $this->db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);  
        $statement->execute($params);
        
        if($result = $statement->fetch())
        {
            return $result['id'];
        }
        
        return false; 
    }
    
    public function getUserById($id)
    {
        $params = array(':id' => $id);
        return $this->select('User', $params);
    }
    
    public function getChunk($tableName, $offset, $numOfRows)
    {
        $sql = "SELECT * FROM $tableName LIMIT $offset,$numOfRows";
        $statement = $this->db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);  
        $statement->execute();
        $chunk = array();
        while($result = $statement->fetch())
        {
            $chunk[] = new $tableName($result);
        }
        if(count($chunk) > 0)
            return $chunk;
        else
            return false;
    }
    
    public function authenticateUser($email, $pass)
    {
        $response = array();
        $params = array('email' => $email, 'password' => $pass);
        $result = $this->select('User', $params);
        if($result)
        {
            $response['status'] = true;
            $response['message'] = 'Successfully logged in!!';
            $_SESSION['user'] = new User($result);
            return $response;
        }
        else
        {
            $response['status'] = false;
            $response['message'] = 'Wrong e-mail or password. Please try again';
            return $response;
        }
    }
    
    public function signup($nvp)
    {
        $response = array();
        $params = array('email' => $nvp['email']);
        
        if($result = $this->select('User', $params))
        {
            $response['status'] = false;
            $response['message'] = 'This E-mail is already registered in the system.';
        }
        else
        {
            $nvp['password'] = sha1(md5($nvp['password'] . PASS_STRING));
            if($user = $this->insert('User', $nvp))
            {
                $response['status'] = true;
                $response['message'] = 'Registration is successfully completed.';
                $_SESSION['user'] = $user;
            }
        }
        
        return $response; 
        
    }
    
    public function getAllCategories()
    {
        $sql = 'select category.id as id, category.name as name, b.name as parent from category left outer join category as b on category.parent = b.id;';
        $cats =  $this->query($sql);
        $categories = array();
        foreach ($cats as $c)
        {
            $categories[] = new Category($c);
        }
        
        return $categories;
    }
}

?>
