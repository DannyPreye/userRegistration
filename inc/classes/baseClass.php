<?Php
         // this class controls everything that concern db connections, insertion and retrieval of details
 class db {
        //Db variables 
        private $server;
        private $username;
        private $password;
        private $db_name;
        public $con;
        public $table_name;

        function __construct($server,$username,$password,$db_name,$table_name)
        {
            $this->server = $server;
            $this->username = $username;
            $this->password = $password;
            $this->db_name = $db_name;
            $this->table_name = $table_name;
        }


        public function dbConnect(){
            try {
                $con = new PDO("mysql:host=$this->server;dbname=$this->db_name;", $this->username,$this->password);
                $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $con;
            }
            catch(PDOException $e){
                echo 'connection failed: '.$e->getMessage();
            }
        }

        

        // :::::::::::::::::::: Create Table ::::::::::::::::::::::
        public function create_db_table(){
           try {
                $sql = "CREATE TABLE IF NOT EXISTS $this->table_name(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY  KEY, fullName VARCHAR(255),phoneNumber VARCHAR(20),email VARCHAR(200) UNIQUE,
                    username VARCHAR(100) UNIQUE, password VARCHAR(200),verified_user INT(1) DEFAULT '0' )";
                    $this->dbConnect()->exec($sql);
                    return "Table Created";
            }
           catch (PDOException $e){
                echo   "Table Creation Error: " . $e->getMessage();           }
        }
     
        // ::::::::::::::::::: Register Users ::::::::::::::::::::::::
        public function insert_user_to_db($fullname,$phone, $email, $username, $psw){   
            try{
                $sql ="INSERT INTO $this->table_name(fullName, phoneNumber, email, username,password) VALUES(?, ?, ?, ?, ?);";
                $stmt= $this->dbConnect()->prepare($sql) or die("failed to prepare statement"); 
                //Prepared statement
                $result = $stmt->execute([
                    $fullname,
                    $phone,
                    $email,
                    $username,
                    $psw
                ]);       
                if($result==true){
                    return true;
                }

            } 
            catch(PDOException $e){
                echo "User Registraion Error: ".$e->getMessage();
            }               
        }

   
        // Login user with email
        public function get_user_data($email,$psw){
          try {
                $sql = "SELECT fullName,email FROM $this->table_name WHERE email='$email' && 
                password = '$psw';";
                $stmt = $this->dbConnect()->prepare($sql);
                $stmt->execute();

                return $stmt->fetch();
          }
          catch (PDOException $e){
            echo "Login Error:".$e->getMessage();
          }
           
        }


        // login user with username
        public function login_with_username($username,$psw){
            try {
                  $sql = "SELECT fullName,email FROM $this->table_name WHERE username='$username' && 
                  password = '$psw';";
                  $stmt = $this->dbConnect()->prepare($sql);
                  $stmt->execute();
  
                  return $stmt->fetch();
            }
            catch (PDOException $e){
              echo "Login Error:".$e->getMessage();
            }
             
          }

        public function check_userEmail($email){
            try {

                $sql = "SELECT email FROM $this->table_name WHERE email='$email';";
                $stmt = $this->dbConnect()->prepare($sql);
                $stmt->execute();
             
                $result= $stmt->fetchAll();
                if(empty($result)){
                    return false;
                }
                else{
                    return true;
                }
            }
            catch (PDOException $e) {
                echo "Check User Email: ".$e->getMessage();
            }
        }

        public function check_username($username){
            try {

                $sql = "SELECT username FROM $this->table_name WHERE username='$username';";
                $stmt = $this->dbConnect()->prepare($sql);
                $stmt->execute();
             
                $result= $stmt->fetchAll();
                if(empty($result)){
                    return false;
                }
                else{
                    return true;
                }
            }
            catch (PDOException $e) {
                echo "Check User: ".$e->getMessage();
            }
        }

         // Create blog table 
        public function create_blog(){
            try {
                $sql = "CREATE TABLE IF NOT EXISTS $this->table_name(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY  KEY, 
                    title VARCHAR(225), content LONGBLOB, picture VARCHAR(225), time TIMESTAMP CURRENT_TIMESTAMP, ";
                    $this->dbConnect()->exec($sql);
                    return "Table Created";
            }
            catch (PDOException $e){
                echo   "Table Creation Error: " . $e->getMessage(); 
                }
        }
        // get blog posts from db
        public function getBlog($blog){
            $sql = "SELECT * FROM $blog";
            $result = $this->dbConnect()->query($sql);
            return $result->fetchAll();
        }

        public function postBlog($blog_table, $title, $content, $picture){
            try{
                $sql =  "INSERT INTO $blog_table(title, content, picture) VALUES (?, ?, ?)";
                $stmt = $this->dbConnect()->prepare($sql);

                $result = $stmt->execute([
                    $title,
                    $content,
                    $picture
                ]);
                if($result == true){
                    return true;
                }
            }
            catch(PDOException $e){
                echo "Blog Error: ".$e->getMessage();
            }
        }
        
        // Close db connection
        public function close_db(){
            $con=$this->dbConnect();
            return $con = null;
        }

    }
    