<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\User;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User(['name'=>"default", 'email'=>"", 'password'=>""]);
        $u->save();
    }
}
