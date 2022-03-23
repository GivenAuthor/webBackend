<?php 
include '../controllers/connect.php';

class user {

    private $email;
    private $password;
    private $fname;
    private $lname;

    private $sqlServer;

    public function getEmail() {return $this->email;}
    public function getPassword() {return $this->password;}
    public function getFName() {return $this->fName;}
    public function getLName() {return $this->lname;}

    public function setEmail($email) {$this->email = $email;}
    public function setPassword($password) {$this->password = $password;}
    public function setFName($fname) {$this->fname = $fname;}
    public function setLName($lname) {$this->lname = $lname;}
    
    public function authenticateUser() {
        $db = dbConnect();
        $sql = 'SELECT clientId FROM clients
                    WHERE clientEmail = :clientEmail
                    AND clientPassword = :clientPassword;';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientEmaile', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':clientPassword', $this->password, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch();
        $stmt->closeCursor();
        if isset($id) {
            $_SESSION['email'] = $this->email;
            return true;
        } else {
            return false;
        }
    }

    public function registerUser() {
        $db = dbConnect();
        $sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
            VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientFirstname', $this->fName, PDO::PARAM_STR);
        $stmt->bindValue(':clientLastname', $this->lName, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmail', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':clientPassword', $this->password, PDO::PARAM_STR);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $rowsChanged;
       }
    }
}

?>