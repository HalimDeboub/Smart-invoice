<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      \App\Models\Counter::factory(1)->create();
       /*  $this->call(
            [
               // RolesAndPermissionsSeeder::class,
                CustomerSeeder::class,
                InvoiceSeeder::class,
                ProductSeeder::class,
                InvoiceProductSeeder::class,
               // GuideSeeder::class,
               // RestaurantSeeder::class,
                //HotelSeeder::class,
              //  TaxiSeeder::class,
            ]
        ); */
      //  \App\Models\Counter::factory(1)->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
