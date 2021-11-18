<?php

    require 'ValidateStudents.php';
    require 'Student.php';
    require 'Validate.php';
    require 'StudentsDatabase.php';
    require 'StudentsFileManager.php';

    $file = new StudentsFileManager();
    $db = new StudentsDatabase($file);

    function CreateNewStudent(){
        try {
            return new Student($_POST['name'], $_POST['ra'], $_POST['sex'], $_POST['age'], $_POST['address'], $_POST['phone'], $_POST['email']);
        } catch (HttpInvalidParamException $e) {
            echo $e;
            return $e;
        }
    }

    function RegisterStudent(Student $s): int
    {
        global $db;

        return $db->RegisterStudent($s);
    }



