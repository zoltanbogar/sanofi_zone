<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(Faker\Generator $faker)
    {
        //User::truncate();
        //DB::delete('TRUNCATE role_user');

        //-------------------------------------------------
        // Zsolt
        //-------------------------------------------------
        $user = User::create([
            'firstname'    => 'Zsolt',
            'lastname'     => 'Boga',
            'phone'    => '123456789',
            'company' => 'Sanofi',
	        'site_name' => 'Zengo',
            'email'        => 'boga.zsolt@zengo.eu',
            'password'     => bcrypt('admin'),
            'confirmed_at' => Carbon::now()
        ]);

        $user->syncRoles([
            \App\Models\Role::$ADMIN,
            \App\Models\Role::$ADMIN_SUPER,
            \App\Models\Role::$DEVELOPER,
        ]);

        //-------------------------------------------------
        // Zoltan
        //-------------------------------------------------
        $user = User::create([
            'firstname'    => 'Zoltan',
            'lastname'     => 'Bogar',
            'phone'    => '123456789',
            'company' => 'Sanofi',
	        'site_name' => 'Zengo',
            'email'        => 'bogar.zoltan@zengo.eu',
            'password'     => bcrypt('admin'),
            'confirmed_at' => Carbon::now()
        ]);

        $user->syncRoles([
            \App\Models\Role::$ADMIN,
            \App\Models\Role::$ADMIN_SUPER,
            \App\Models\Role::$DEVELOPER,
        ]);

        //-------------------------------------------------
        // Default Admin
        //-------------------------------------------------
        $user = User::create([
            'firstname'    => 'Admin',
            'lastname'     => 'Zone Access Rights',
            'phone'    => '123456789',
            'company' => 'Sanofi',
            'email'        => 'admin@laravel-admin.dev',
            'password'     => bcrypt('admin'),
            'site_name' => 'Sanofi',
            'confirmed_at' => Carbon::now()
        ]);

        $user->syncRoles([
            \App\Models\Role::$ADMIN,
            \App\Models\Role::$ADMIN_SUPER,
            \App\Models\Role::$DEVELOPER,
        ]);

        for ($i = 0; $i < 30; $i++) {
            $user = User::create([
                'firstname'    => $faker->firstName,
                'lastname'     => $faker->lastName,
                'phone'    => $faker->phoneNumber,
                'company' => 'Sanofi',
                'email'        => $faker->email,
                'password'     => bcrypt('secret'),
	            'site_name' => 'Sitename',
                'confirmed_at' => Carbon::now()
            ]);

            $user->syncRoles([
                \App\Models\Role::$ADMIN,
                \App\Models\Role::$ANALYTICS,
            ]);
        }
    }
}