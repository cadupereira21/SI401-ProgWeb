<?php

class User
{
    private int $id;
    private string $name;
    private string $username;
    private string $cpf;
    private string $birthday;
    private string $phone;
    private string $email;
    private string $password;

    //region Construtor, Getters e Setters
    public function __construct(int $id, string $nome, string $apelido, string $cpf, string $dataNasc, string $telefone, string $email, string $senha)
    {
        $this->id = $id;
        $this->name = $nome;
        $this->username = $apelido;
        $this->cpf = $cpf;
        $this->birthday = $dataNasc;
        $this->phone = $telefone;
        $this->email = $email;
        $this->password = $senha;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    //endregion

    /**
     * @throws ErrorException
     */
    public static function BuildUser(array $elem): User{
        if(count($elem) != 8){
            throw new ErrorException("Parâmetro passado não possui 8 elementos para serem usados!");
        }

        return new User($elem['userId'], $elem['name'], $elem['username'], $elem['cpf'], $elem['birthday'], $elem['phone'], $elem['email'], $elem['password']);
    }

}

/*
 *  REFERENCIAS
 *
 *  https://www.php.net/manual/pt_BR/function.date.php
 * */
 ?>