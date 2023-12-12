<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Students;

class StudentsSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Students::factory(50)->create();
    }
}
