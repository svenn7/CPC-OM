<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Students;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Students::factory()->create();
    }
}
