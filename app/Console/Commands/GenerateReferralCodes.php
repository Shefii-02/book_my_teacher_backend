<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateReferralCodes extends Command
{
    protected $signature = 'users:generate-referral-codes';
    protected $description = 'Generate referral codes for existing users who do not have one';

    public function handle()
    {
        $this->info("Generating referral codes...");

        User::whereNull('referral_code')->chunk(200, function ($users) {
            foreach ($users as $user) {
                $user->referral_code = $this->generateCode();
                $user->save();
            }
        });

        $this->info("Referral codes generated successfully!");
    }

    private function generateCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do {
            $random = substr(str_shuffle($characters), 0, 6);
            $code = 'BMT-' . $random;
            // $code = 'BMT-' . rand(100000, 999999);
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
