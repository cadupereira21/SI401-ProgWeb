<?php

class StudentsFileManager
{

    private const STUDENTS_FILE_TXT = 'studentsFile.txt';


    static function WriteStudent(Student $s):int{
        $aux = $s->GetName() .','. $s->GetRa() .','. $s->GetSex() .','. $s->GetAge() .','. $s->GetAddress() .','. $s->GetPhone() .','. $s->GetEmail();

        try{
            $openedFile = fopen(self::STUDENTS_FILE_TXT, 'a');
            if(fwrite($openedFile, $aux) === FALSE) {
                echo 'Não foi possível escrever no arquivo ' .self::STUDENTS_FILE_TXT;
            }
            fclose($openedFile);
            return 0;
        } catch (Exception $e){
            echo $e;
            return -1;
        }
    }

    static function ReadStudents(){
        $auxArray = array();

        try{
            $openedFile = fopen(self::STUDENTS_FILE_TXT, 'r');
            while(feof($openedFile)){
                $auxString = explode(',', fgets($openedFile));

                //region Students Variables
                $name = $auxString[0];
                $ra = $auxString[1];
                $sex = $auxString[2];
                $age = $auxString[3];
                $address = $auxString[4];
                $phone= $auxString[5];
                $email = $auxString[6];
                //endregion

                array_push($auxArray, new Student($name, $ra, $sex, $age, $address, $phone, $email));
            }
            return $auxArray;
        } catch (Exception $e) {
            echo $e;
        }
    }

}