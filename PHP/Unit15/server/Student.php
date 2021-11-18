<?php

    class Student{

        private string $name;
        private string $ra;
        private string $sex;
        private string $age;
        private string $address;
        private string $phone;
        private string $email;

        public function __construct(string $name, string $ra, string $sex, string $age, string $address, string $phone, $email)
        {
            $this->name = stripslashes($name);
            $this->ra = $ra;
            $this->sex = $sex;
            $this->age = $age;
            $this->address = stripslashes($address);
            $this->phone = $phone;
            $this->email = $email;

            $message = Validate::GetInstance()->ValidateStudentsData($this);

            if($message != 0) throw new HttpInvalidParamException($message);
        }

        /**
         * @return string
         */
        public function GetName(): string
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function GetRa(): string
        {
            return $this->ra;
        }

        /**
         * @return string
         */
        public function GetSex(): string
        {
            return $this->sex;
        }

        /**
         * @return string
         */
        public function GetAge(): string
        {
            return $this->age;
        }

        /**
         * @return string
         */
        public function GetAddress(): string
        {
            return $this->address;
        }

        /**
         * @return string
         */
        public function GetPhone(): string
        {
            return $this->phone;
        }

        public function GetEmail()
        {
            return $this->email;
        }
    }