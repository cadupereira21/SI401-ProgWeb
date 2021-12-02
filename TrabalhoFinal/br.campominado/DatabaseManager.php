<?php

require "User.php";
require "Game.php";

class DatabaseManager
{
    private static ?DatabaseManager $instance = null;
    private bool $isBdUp = FALSE;

    private const DB_NAME = "CampoMinado";
    private const USER_USERNAME = "simpleUser";
    private const USER_PASSWORD = "#simpleuser#123";

    //region Funções Privadas
    private function __construct()
    {
        $this->CreateDatabase();
    }

    private function CreateDatabase(){
        $conn = $this->GetConnection("root", "");

        if(!$this->isBdUp){
            try {
                $stmt = "CREATE DATABASE " . self::DB_NAME;
                $conn->exec($stmt);
                echo "Sucesso na criacao do bd!";
            } catch (PDOException $e){
                echo "Erro ao criar o Banco de Dados: " .$e->getMessage() ."<br/>";
            }
        }

        $this->CreateUser($conn);
        $this->CreateTableUser($conn);
        $this->CreateTableGame($conn);

        $this->CloseConnection($conn);
        $this->isBdUp = TRUE;
    }

    private function CreateUser(PDO $conn){
        $user = self::USER_USERNAME;
        $pass = self::USER_PASSWORD;
        $db = self::DB_NAME;

        // Existe um bug na hora de criar o usuario para acessar o banco de dados, por isso dropamos ele antes de cria-lo (isso faz com que sempre que executemos esse codigo,
        //um novo usuario seja recriado)
        try{
            $stmt = "DROP USER '$user'@localhost; FLUSH PRIVILEGES;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT SELECT, INSERT, UPDATE, DELETE ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;";
            $conn->exec($stmt);
            echo "Sucesso na criacao do usuario!" ."<br/>";
        } catch (PDOException $e){
            echo "Erro ao criar o Usuário: " .$e->getMessage() ."<br/>";
        }
    }

    private function CreateTableUser(PDO $conn){
        try{
            $stmt = "USE " .self::DB_NAME .";
                    CREATE TABLE IF NOT EXISTS User(
                        id smallint not null,
                        name char(50) not null,
                        cpf char(11) not null,
                        birthday date not null,
                        phone char(11) not null,
                        username char(30) not null,
                        email char(50) not null,
                        password char(35) not null,
                        primary key (id, cpf)
                    )";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela User!" ."<br/>";
        } catch (PDOException $e){
            echo "Erro ao criar a tabela User: " .$e->getMessage() ."<br/>";
        }
    }

    private function CreateTableGame(PDO $conn){
        try{
            $stmt = "USE " .self::DB_NAME .";
                    CREATE TABLE IF NOT EXISTS Game(
                        id smallint not null,
                        userId smallint not null,
                        gameDate date not null,
                        gameMode char(8) not null,
                        grid char(5) not null,
                        numBombs int not null,
                        gameTime time not null,
                        isAWin bit not null,
                        primary key (id),
                        foreign key (userId) references user (id)
                    )";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela Game" ."<br/>";
        } catch (PDOException $e){
            echo "Erro ao criar a tabela Game: " .$e->getMessage() ."<br/>";
        }
    }
    //endregion

    public static function GetInstance(): DatabaseManager
    {
        if(self::$instance == null) self::$instance = new DatabaseManager();

        return self::$instance;
    }

    public function GetUsername(): string
    {
        return self::USER_USERNAME;
    }

    public function GetPassword(): string
    {
        return self::USER_PASSWORD;
    }

    public function GetDbName(): string
    {
        return self::DB_NAME;
    }

    public function GetConnection(string $username, string $pwd, string $dbname = "")
    {
        $conn = null;

        $dsn = "mysql:host=localhost";

        if($dbname != ""){
            $dsn = $dsn .';dbname=' .$dbname;
        }

        try{
            global $conn;
            $conn = new PDO($dsn, $username, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Connection Failed: " .$e->getMessage();
        }

        return $conn;
    }

    public function CloseConnection(&$conn){
        if($conn != null) $conn = null;
    }

    public function RegisterUser(User $user){
        $conn = $this->GetConnection(self::USER_USERNAME, self::USER_PASSWORD, self::DB_NAME);

        try {
            $stmt = 'INSERT INTO User VALUES ((SELECT max(id)+1 FROM User), ' .$user->getName() .', ' .$user->getCpf() .', ' .$user->getBirthday() .', ' .$user->getPhone() .', '
                .$user->getUsername() .', ' .$user->getEmail() .', ' .$user->getPassword() .')';

            $conn->exec($stmt);
            echo "Sucesso ao registrar usuário!" .'<br/>';
        } catch (PDOException $e){
            echo "Erro ao registrar usuário: " .$e->getMessage() .'<br/>';
        }

    }

}

/*
 * REFERENCIAS
 *
 *  https://stackoverflow.com/questions/30066241/how-to-see-if-database-exists-with-pdo
 *
 *  https://stackoverflow.com/questions/2583707/can-i-create-a-database-using-pdo-in-php
 *
 */