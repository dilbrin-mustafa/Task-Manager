<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::firstOrCreate(['name' => 'Work']);
        Project::firstOrCreate(['name' => 'Personal']);
        Project::firstOrCreate(['name' => 'Shopping List']);
    }
}
