<?php

class DatabaseManager
{
    private static ?DatabaseManager $instance = null;

    private const DB_ACCESS_DB_NAME = "campominado";
    private const DB_ACCESS_USERNAME = "simpleUser";
    private const DB_ACCESS_PASSWORD = "#simpleuser#123";
    //region Funções Privadas

    private function CreateUser(PDO $conn){
        $user = self::DB_ACCESS_USERNAME;
        $pass = self::DB_ACCESS_PASSWORD;
        $db = self::DB_ACCESS_DB_NAME;

        // Existe um bug na hora de criar o usuario para acessar o banco de dados, por isso dropamos ele antes de cria-lo (isso faz com que sempre que executemos esse codigo,
        //um novo usuario seja recriado)
        try{
            $stmt = "DROP USER '$user'@localhost;FLUSH PRIVILEGES;
					CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
					GRANT SELECT, INSERT, UPDATE, DELETE ON `$db`.* TO '$user'@'localhost';
					FLUSH PRIVILEGES;";
            $conn->exec($stmt);
            echo "Sucesso na criacao do Usuário!" ."<br/>";
        } catch (PDOException $e){
            throw new Exception("Erro ao criar o Usuário: " .$e->getMessage() ."<br/>");
        }
    }

    private function CreateTableUser(PDO $conn){
        try{
            $stmt = "USE " .self::DB_ACCESS_DB_NAME .";
                    CREATE TABLE IF NOT EXISTS `user` (
					  `userId` smallint(6) NOT NULL AUTO_INCREMENT,
					  `name` char(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
					  `cpf` char(15) NOT NULL,
					  `birthday` date NOT NULL,
					  `phone` char(15) NOT NULL,
					  `username` char(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
					  `email` char(50) NOT NULL,
					  `password` char(35) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
					  PRIMARY KEY (`userId`),
					  UNIQUE KEY `cpf` (`cpf`)
					) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela User!" ."<br/>";
        } catch (PDOException $e){
            throw new Exception("Erro ao criar a tabela User: " .$e->getMessage() ."<br/>");
        }
    }

    private function CreateTableGame(PDO $conn){
        try{
            $stmt = "USE " .self::DB_ACCESS_DB_NAME .";
                    CREATE TABLE IF NOT EXISTS `game` (
					  `gameId` smallint(6) NOT NULL AUTO_INCREMENT,
					  `game_userId` smallint(6) NOT NULL,
					  `gameDate` datetime NOT NULL,
					  `gameMode` char(8) NOT NULL,
					  `grid` char(7) NOT NULL,
					  `numBombs` int(11) NOT NULL,
					  `gameTime` time NOT NULL,
					  `isAWin` bit(1) NOT NULL,
					   PRIMARY KEY (`gameId`),
					   KEY `game_userId` (`game_userId`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $conn->exec($stmt);

            echo "Sucesso na criacao da tabela Game" ."<br/>";
        } catch (PDOException $e){
            throw new Exception("Erro ao criar a tabela Game: " .$e->getMessage() ."<br/>");
        }
    }

    private function GetConnection(string $username, string $pwd, string $dbname = "")
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

    private function CloseConnection(&$conn){
        if($conn != null) $conn = null;
    }

	private function databaseExiste(PDO $conn) : bool
	{
		$verificacaoBanco = "SELECT SCHEMA_NAME
							FROM INFORMATION_SCHEMA.SCHEMATA
							WHERE SCHEMA_NAME = '".self::DB_ACCESS_DB_NAME."'";
		
		$existe = $conn->query($verificacaoBanco)->rowCount();
		return $existe == 1;		
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

    public function CreateDatabase(){

		$conn = $this->GetConnection("root", "");

		if($this->databaseExiste($conn)){
			echo "Já existe um banco de dados!";
		}else{
            try {
                $stmt = "CREATE DATABASE " . self::DB_ACCESS_DB_NAME;
                $conn->exec($stmt);
                echo "Sucesso na criacao do bd!<br/>";
				$this->CreateUser($conn);
				$this->CreateTableUser($conn);
				$this->CreateTableGame($conn);
            } catch (PDOException $e){
                echo "Erro ao criar o Banco de Dados: " .$e->getMessage() ."<br/>";
            } catch (Exception $e){
				echo "Ocorreu um erro no processo de criação do banco de dados! ";
                echo $e->getMessage();
				echo "Desfazendo alterações...<br/>";
				$this->DropDatabase();
            }
        }
		$this->CloseConnection($conn);
    }

	public function DropDatabase(){
		
		try{
			$conn = $this->GetConnection("root", "");
		    $sql = 'DROP DATABASE '. self::DB_ACCESS_DB_NAME;
			$conn->query($sql);
			echo "Banco de dados deletado com sucesso!<br/>";

		} catch (PDOException $e){
            echo "Erro ao deletar o db: " .$e->getMessage() ."<br/>";
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