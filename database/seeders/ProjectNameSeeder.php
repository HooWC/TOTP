<?php

namespace Database\Seeders;

use App\Models\ProjectName;
use Illuminate\Database\Seeder;

class ProjectNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectName::create(['name' => 'authenticator-saml']);
        ProjectName::create(['name' => 'example-project']);
    }
}
