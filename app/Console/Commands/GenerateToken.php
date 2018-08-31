<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Auth;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:generate_token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成用户令牌';

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
        //
        $userId = $this->ask('请输入用户id');
        $user = User::find($userId);
        if(!$user){

            $this->ask("错误的用户id");

        }

        $ttl = 365*24*60;
        $token = Auth::guard('api')->setTTL($ttl)->fromUser($user);
        $this->info($token);
    }
}
