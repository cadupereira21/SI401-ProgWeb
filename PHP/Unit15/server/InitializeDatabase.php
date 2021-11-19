<?php

    require 'ValidateStudents.php';
    require 'Student.php';
    require 'Validate.php';
    require 'StudentsFileManager.php';
    require 'StudentsDatabase.php';

    $file = new StudentsFileManager();
    $db = new StudentsDatabase($file);