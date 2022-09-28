<?php

use App\Jobs\SendEmailToUserJob;
use Twilio\Rest\Client;
function sendSms($receiverNumber, $message)
{
    $sid = config('twilio.account_sid');
    $token = config('twilio.auth_token');
    $client = new Client($sid, $token);
    //I can use Queue job for SMS too but I just wanted to return failure responses for non-verified TWILIO caller ids in "catch" and then show you response message either SMS is sent or Not.
    try {
        $client->messages->create(
            $receiverNumber,
            [
                'from' => config('twilio.sms_from'),
                'body' => $message,
            ]
        );
    } catch (\Twilio\Exceptions\TwilioException $e) {
        return;
    }
    return true;
}

function sendEmail($user, $message)
{
    $details = [
        'title' => 'This is a testing Email from Krasimir Veselinov',
        'message' => $message,
        'to' => $user,
    ];
    try {
        //I have created a job for sending email in Queue so that we should'nt care about response time
        dispatch(new SendEmailToUserJob($details));
    } catch (\Exception $e) {
        report($e);
        return Redirect::back()->with('error', $e->getMessage());
    }
}
