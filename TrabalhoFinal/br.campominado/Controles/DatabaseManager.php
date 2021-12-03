<?php

require "User.php";
require "Game.php";
require "DatabaseKeys.php";

class DatabaseManager
{
    private static ?DatabaseManager $instance = null;
    private bool $isBdUp = FALSE;

    private const DB_ACCESS_DB_NAME = "CampoMinado";
    private const DB_ACCESS_USERNAME = "simpleUser";
    private const DB_ACCESS_PASSWORD = "#simpleuser#123";

    //region Funções Privadas
    private function __construct()
    {
        $this->CreateDatabase();
    }

    private function CreateDatabase(){
        $conn = $this->GetConnection("root", "");

        if(!$this->isBdUp){
            try {
                $stmt = "CREATE DATABASE " . self::DB_ACCESS_DB_NAME;
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
        $user = self::DB_ACCESS_USERNAME;
        $pass = self::DB_ACCESS_PASSWORD;
        $db = self::DB_ACCESS_DB_NAME;

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
            $stmt = "USE " .self::DB_ACCESS_DB_NAME .";
                    CREATE TABLE IF NOT EXISTS User(
                        userId smallint not null AUTO_INCREMENT,
                        name char(50) not null,
                        cpf char(11) not null,
                        birthday date not null,
                        phone char(11) not null,
                        username char(30) not null,
                        email char(50) not null,
                        password char(35) not null,
                        primary key (userId),
						unique (cpf)
                    )";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela User!" ."<br/>";
        } catch (PDOException $e){
            echo "Erro ao criar a tabela User: " .$e->getMessage() ."<br/>";
        }
    }

    private function CreateTableGame(PDO $conn){
        try{
            $stmt = "USE " .self::DB_ACCESS_DB_NAME .";
                    CREATE TABLE IF NOT EXISTS Game(
                        gameId smallint not null,
                        game_userId smallint not null,
                        gameDate date not null,
                        gameMode char(8) not null,
                        grid char(5) not null,
                        numBombs int not null,
                        gameTime time not null,
                        isAWin bit not null,
                        primary key (gameId),
                        foreign key (game_userId) references user (userId)
                    )";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela Game" ."<br/>";
        } catch (PDOException $e){
            echo "Erro ao criar a tabela Game: " .$e->getMessage() ."<br/>";
        }
    }

    private function BuildUser(array $userElements): ?User
    {
        $user = null;

        try {
            $user = User::BuildUser($userElements);
        } catch (ErrorException $e) {
            echo "Erro ao criar o usuário: " .$e->getMessage() .'<br/>';
        }

        return $user;
    }

    private function BuildGame(array $gameElements): ?Game
    {
        $game = null;

        try {
            $game = Game::BuildGame($gameElements);
        } catch (ErrorException $e) {
            echo "Erro ao criar um objeto jogo: " .$e->getMessage() .'<br/>';
        }

        return $game;
    }

    private function ProcessKey(string $key): string {

        $s = "";

        switch ($key){
            case DatabaseKeys::USER_ID: $s = "SELECT * FROM User WHERE " .DatabaseKeys::USER_ID ." = "; break;
            case DatabaseKeys::USER_NAME: $s = "SELECT * FROM User WHERE " .DatabaseKeys::USER_NAME ." = "; break;
            case DatabaseKeys::USER_USERNAME: $s = "SELECT * FROM User WHERE " .DatabaseKeys::USER_USERNAME ." = "; break;
            case DatabaseKeys::USER_CPF: $s = "SELECT * FROM User WHERE " .DatabaseKeys::USER_CPF ." = "; break;
            case DatabaseKeys::GAME_ID: $s = "SELECT * FROM Game WHERE " .DatabaseKeys::GAME_ID ." = "; break;
            case DatabaseKeys::GAME_USERID: $s = "SELECT * FROM Game WHERE " .DatabaseKeys::GAME_USERID ." = "; break;
        }

        return $s;
    }
    //endregion

    public static function GetInstance(): DatabaseManager
    {
        if(self::$instance == null) self::$instance = new DatabaseManager();

        return self::$instance;
    }

    public function GetUsername(): string
    {
        return self::DB_ACCESS_USERNAME;
    } // Use para GetConnection fora da classe!

    public function GetPassword(): string
    {
        return self::DB_ACCESS_PASSWORD;
    } // Use para GetConnection fora da classe!

    public function GetDbName(): string
    {
        return self::DB_ACCESS_DB_NAME;
    } // USe para GetConnection fora da classe!

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
        $conn = $this->GetConnection(self::DB_ACCESS_USERNAME, self::DB_ACCESS_PASSWORD, self::DB_ACCESS_DB_NAME);

        try {
            $stmt = "INSERT INTO User VALUES ('{$user->getId()}', '{$user->getName()}', '{$user->getCpf()}', '{$user->getBirthday()}', '{$user->getPhone()}', '{$user->getUsername()}', '{$user->getEmail()}', '{$user->getPassword()}')";

            $conn->exec($stmt);
            echo "Sucesso ao registrar usuário!" .'<br/>';
        } catch (PDOException $e){
            echo "Erro ao registrar usuário: " .$e->getMessage() .'<br/>';
        }
        $this->CloseConnection($conn);
    }

    public function RegisterGame(Game $game){
        $conn = $this->GetConnection(self::DB_ACCESS_USERNAME, self::DB_ACCESS_PASSWORD, self::DB_ACCESS_DB_NAME);

        if($game->isAWin()){
            $isAWin = 1;
        }
        else{
            $isAWin = 0;
        }


        try {
            $stmt = "INSERT INTO Game VALUES ('{$game->getId()}', '{$game->getUserId()}', '{$game->getDate()}', '{$game->getGameMode()}', '{$game->getGrid()}', '{$game->getNumBombs()}', '{$game->getTime()}', {$isAWin})";

            $conn->exec($stmt);
            echo "Sucesso ao registrar Jogo!" .'<br/>';
        } catch (PDOException $e){
            echo "Erro ao registrar Jogo: " .$e->getMessage() .'<br/>';
        }
        $this->CloseConnection($conn);
    }

    /*
     * Função de busca que cria um SELECT dependendo da chave passada. Ela pode ser um dos seguintes atributos estaticos de DatabaseKeys:
     *  USER_ID, USER_NAME, USER_USERNAME, USER_CPF, GAME_ID, GAME_USERID
     */
    public function Search(string $key, $elem)
    {
        $conn = $this->GetConnection(self::DB_ACCESS_USERNAME, self::DB_ACCESS_PASSWORD, self::DB_ACCESS_DB_NAME);
        $aux = array();

        $sql = $this->ProcessKey($key);

        $param = $elem;
        if(gettype($elem) != gettype(1)) $param = "'{$elem}'";

        try{
            $stmt = $conn->query($sql .$param);
            $aux = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Sucesso na Busca!" .'<br/>';
        } catch (PDOException $e){
            echo "Erro na Busca: " .$e->getMessage() .'<br/>';
        }

        if($key == DatabaseKeys::GAME_ID || $key == DatabaseKeys::GAME_USERID) return $this->BuildGame($aux);

        return $this->BuildUser($aux);
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