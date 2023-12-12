<?php

namespace App\Imports;

use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Students([
            'fname' => $row['1'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'gender' => $row['gender'],
            'mobile' => $row['mobile'],
            'birthdate' => $row['birthdate'],
            'email' => $row['email'],
            'course' => $row['course'],
            'year' => $row['year'],
            'section' => $row['section'],
            'address' => $row['address'],
        ]);
    }
}

