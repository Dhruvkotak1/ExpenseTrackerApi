<?php

namespace App\Jobs;

use App\Mail\resetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class DeleteToken implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('password_reset_tokens')->where('email',$this->email)->delete();
    }
}
