<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // User::factory(10)->create();

    // User::factory()->create([
    //   'name' => 'Test User',
    //   'mobile'=> '7887670989',
    //   'acc_type'=> 'super_admin',
    //   'company_id'=> 0,
    //   'email' => 'superadmin@example.com',
    //   'password'=> '$2y$12$hcr.nImGCtkr7osPHAto7.aStQ0y2rroFP98gSgKD2WfodkQBukO.',
    //   'profile_fill'=>1,

    // ]);


    $this->call([
      StreamProvidersTableSeeder::class,
      ProviderCredentialsTableSeeder::class,
      WebinarSeeder::class,
      GradesSubjectsSeeder::class,
    ]);
  }
}
