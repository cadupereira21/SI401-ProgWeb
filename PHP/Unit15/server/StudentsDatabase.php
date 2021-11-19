<?php

class StudentsDatabase
{
    private string $studentsRegistered = "";
    private StudentsFileManager $fileManager;

    /**
     * @param StudentsFileManager $fileManager
     */
    public function __construct(StudentsFileManager $fileManager)
    {
        $this->fileManager = $fileManager;
        $this->studentsRegistered = $this->fileManager->ReadStudents();
    }

    public function GetStudentsRegistered(): string
    {
        return $this->studentsRegistered;
    }

    public function RegisterStudent(Student $s): int
    {
        return $this->fileManager->WriteStudent($s);
    }

}