<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adduser {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');


        User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>bcrypt($password),
            'api_token'=>Str::random(60)
        ]);
    }
}
