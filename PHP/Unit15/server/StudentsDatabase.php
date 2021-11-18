<?php

class StudentsDatabase
{
    private array $studentsRegistered;
    private StudentsFileManager $fileManager;

    /**
     * @param array $studentsRegistered
     * @param StudentsFileManager $fileManager
     */
    public function __construct(StudentsFileManager $fileManager)
    {
        $this->fileManager = $fileManager;

        //$this->studentsRegistered = $this->fileManager->ReadStudents();
    }

    public function GetStudentsRegistered(): array
    {
        return $this->studentsRegistered;
    }

    public function RegisterStudent(Student $s): int
    {
        return $this->fileManager->WriteStudent($s);
    }

}