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

//    static function ReadStudents(){
//        $auxArray = array();
//
//        try{
//            $openedFile = fopen(self::STUDENTS_FILE_TXT, 'r');
//            while(feof($openedFile)){
//                $auxString = explode(',', fgets($openedFile));
//
//                $name = $auxString[0];
//                $ra = $auxString[1];
//
//            }
//        } catch (Exception $e) {
//            echo $e;
//        }
//    }

}