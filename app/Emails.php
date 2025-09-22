<?php

namespace App;

use App\Jobs\Email;

trait Emails
{

  public static function sendError(array $content)
  {
    self::email(new Email([
      'emailClass' => 'DefaultMail',
      'to' => env('DEV_EMAIL'),
      'bccStatus' => false,
      'subject' => __("Error occured"),
      'contents' => view('emails.exception',compact('content'))->render(),
    ]));
  }

  public function SendOtpMail(string $otp, string $expTime, string $user)
  {

    self::dispatchSync(new Email([
      'emailClass' => 'DefaultMail',
      'to' => $user,
      'subject' => __('Your OTP for BookMyTeacher'),
      'name' => 'BookMyTeacher-Student',
      'contents' => view('emails.otp', [
        'otp'      => $otp,
        'expTime'  => $expTime
      ])->render(),
    ]));

    // self::dispatchSync(new Email([
    //   'emailClass' => 'DefaultMail',
    //   'to' => $user,
    //   'subject' => __('Your OTP for BookMyTeacher'),
    //   'name' => 'BookMyTeacher-Student',
    //   'contents' => view('emails.otp', [
    //     'otp'      => $otp,
    //     'expTime'  => $expTime
    //   ])->render(),
    // ]));
  }

  // public function accountCreated(Account $user){
  //     if($user->status == 'pending'){
  //         self::email(new Email([
  //             'emailClass' => 'DefaultMail',
  //             'to' => env('ADMIN_EMAIL'),
  //             'subject' => __("New User Registration Awaiting Approval"),
  //             'contents' => view('email.accountCreatedAdmin')->withUser($user)->render(),
  //         ]));
  //     }

  //     self::email(new Email([
  //     'emailClass' => 'DefaultMail',
  //         'name' => $user->name,
  //         'to' => $user->email,
  //         'subject' => __("Account created"),
  //         'contents' => view('email.accountCreated')->withUser($user)->render(),
  //     ]));
  // }

  // public function accountApproved(Account $user){
  //     self::email(new Email([
  //     'emailClass' => 'DefaultMail',
  //         'name' => $user->name,
  //         'to' => $user->email,
  //         'subject' => __("Account approved"),
  //         'contents' => view('email.accountApproved')->withUser($user)->render(),
  //     ]));
  // }

  // public function accountSuspended(Account $user){
  //     self::email(new Email([
  //     'emailClass' => 'DefaultMail',
  //         'name' => $user->name,
  //         'to' => $user->email,
  //         'subject' => __("Account Subspended"),
  //         'contents' => view('email.accountSuspended')->withUser($user)->render(),
  //     ]));
  // }

  // public function accountDeleted(Account $user){
  //     self::email(new Email([
  //     'emailClass' => 'DefaultMail',
  //         'name' => $user->name,
  //         'to' => $user->email,
  //         'subject' => __("Account Deleted"),
  //         'contents' => view('email.accountDeleted')->withUser($user)->render(),
  //     ]));
  // }

  /**
   * Dispatch email job
   * @param Email $mail
   */
  public static function email(Email $mail)
  {
    !ENV('EMAIL', false) or dispatch($mail);
  }


  public static function dispatchSync(Email $mail)
  {
     !ENV('EMAIL', false) or dispatch_sync($mail);
  }
}
