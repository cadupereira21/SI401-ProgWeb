<?php

interface ValidateStudents
{
    public function ValidateName(string $nome);
    public function ValidateRa(string $ra);
    public function ValidateAddress(string $address);
    public function ValidatePhone(string $phone);
    public function ValidateEmail(string $email);
}