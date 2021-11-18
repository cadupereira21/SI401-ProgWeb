<?php

    class Validate{


        private function __construct(){}

        public static function GetInstance(): Validate
        {
            return new Validate();
        }

        /**
         * @param Student $student
         * @return mixed
         */
         public function ValidateStudentsData(Student $student){
            try{
                $this->ValidateName($student->GetName());
                $this->ValidateRa($student->GetRa());
                $this->ValidateAddress($student->GetAddress());
                $this->ValidatePhone($student->GetPhone());
                $this->ValidateEmail($student->GetEmail());
                return 0;
            } catch (HttpInvalidParamException $e){
                return 'ERRO NA VALIDAÇÃO DOS DADOS: ' .$e;
            }
        }

        private function ValidateName(string $nome)
        {
            if ($nome == "") throw new HttpInvalidParamException("Nome não pode ser vazio!");

            // TODO: Check if name already exists in database
        }

        private function ValidateRa(string $ra)
        {
            if ($ra == "") throw new HttpInvalidParamException("Ra não pode ser vazio!");
            // TODO: Check if ra already exists in database
        }

        private function ValidateAddress(string $address)
        {
            if ($address == "") throw new HttpInvalidParamException("Endereco nao pode ser vazio!");
        }

        private function ValidatePhone(string $phone)
        {

            if ($phone == "") throw new HttpInvalidParamException("Ra não pode ser vazio!");
            // TODO: Check if phone already exists in database
        }

        private function ValidateEmail(string $email)
        {
            if ($email == "") throw new HttpInvalidParamException("Ra não pode ser vazio!");
            // TODO: Check if email already exists in database
        }
    }
