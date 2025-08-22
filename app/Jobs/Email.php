<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\DefaultMail;
use Illuminate\Support\Facades\Mail;

class Email implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $mailClass;
    protected $to;
    protected $bcc;
    protected $cc;
    protected $bccStatus;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details){
        $this->details = $details;
        $this->mailClass = 'App\\Mail\\'.($details['emailClass'] ?? 'DefaultMail');
        $this->to = $this->details['to'];
        //$this->to = explode(',', env("BCC_EMAIL"));
        $this->bcc = explode(',', env("BCC_EMAIL"));
        $this->bccStatus = $this->details['bccStatusbcc'] ?? false;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){

        $email = new $this->mailClass($this->details);

        if ($this->bccStatus && !empty($this->bcc)) {
            Mail::to($this->to)->bcc($this->bcc)->send($email);
        } else {
            Mail::to($this->to)->send($email);
        }
    }

    public static function dispatchWithDelay(array $details, int $delayInMinutes = 1)
    {
        self::dispatch($details)->delay(now()->addMinutes($delayInMinutes));
    }
}
