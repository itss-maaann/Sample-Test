<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class Api_UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'You can populate your view with listed ata',
            'result' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'status' => true,
            'message' => 'Hey, you can return view for create from this route',
            'result' => (object) [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //I have created a formRequest validation class by 'ValidateUser' name for rules and customized messages
    //if you are hitting this function from API route from postman or application etc, make sure to pass ("Accept": "application/json"), otherwise you will not receive validation failure errors in json response.
    public function store(ValidateUser $request)
    {
        //This will start Database transaction
        DB::beginTransaction();
        try {
            //Mass assignment to User Model
            $user = User::create($request->validated());
            //You have to use "$user->phone" instead of hardcoding
            $phone = '+923359369361'; //I just hardcoded my number because i have verified this on TWILIO trial account so that i can receive sms.
            $message = 'Hey Mr/Mrs '.$user->name.' Your account is created';
            //Function for sending SMS is written in app\Http\helpers
            sendSms($phone, $message) ? $smsConfirmation = "SMS sent to ".$phone : $smsConfirmation = "SMS failed for ".$phone;
            //If code is processed without any errors, record will be inserted successfully
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User created successfully and '.$smsConfirmation, //From here you will know if TWILIO has sent message to the designated number or not.
                'result' => $user,
            ]);
        } catch (\Exception $ex) {
            //If we catch any error at any point, it will rollback current Database entry and won't save an incomplete record
            DB::rollback();
            //If we catch any error at any point, this will tell us about exact error
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'result' => (object) []]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //As this controller is for User's model, so we have done (Implicit route-model-binding) here
    public function show(User $user)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => "You requested to read this user's record",
                'result' => $user,
            ]);
        } catch (\Exception $ex) {
            //If we catch any error at any point, this will tell us about exact error
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'result' => (object) []]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //As this controller is for User's model, so we have done (Implicit route-model-binding) here
    public function edit(User $user)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => "You requested to edit this user's record",
                'result' => $user,
            ]);
        } catch (\Exception $ex) {
            //If we catch any error at any point, this will tell us about exact error
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'result' => (object) []]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //As mentioned above, there is a formRequest validation class by 'ValidateUser' name for rules and customized messages
    //if you are hitting this function from API route from postman or application etc, make sure to pass ("Accept": "application/json"), otherwise you will not receive validation failure errors in json response.
    //Remember that this would be a PUT request so if you must send data in json format e-g postman (Body => raw [JSON])
    //As this controller is for User's model, so we have done (Implicit route-model-binding) here and injected User Model as argument
     //I have customized response for "ModelNotFoundException" in (Illuminate\Foundation\Exceptions\Handler) in render function on line 326
    public function update(ValidateUser $request, User $user)
    {
        //This will start Database transaction
        DB::beginTransaction();
        try {
            //Mass update User Model
            $user->update($request->validated());
            //If code is processed without any errors, record will be updated successfully
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'result' => $user,
            ]);
        } catch (\Exception $ex) {
            //If we catch any error at any point, it will rollback current Database entry and won't save an incomplete record
            DB::rollback();
            //If we catch any error at any point, this will tell us about exact error
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'result' => (object) []]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //Make sure to pass ("Accept": "application/json"), otherwise you will not receive failure cases in json response e-g user does not exists.
    //I have customized response for "ModelNotFoundException" in (Illuminate\Foundation\Exceptions\Handler) in render function on line 326
    public function destroy(User $user)
    {
        //This will start Database transaction
        DB::beginTransaction();
        try {
            //This will soft delete user
            $user->delete();
            $message = 'Your Account has been deleted';
            //Function for sending Email in Queue is written in app\Http\helpers
            sendEmail($user, $message);

            //You have to use "$user->phone" instead of hardcoding
            $phone = '+923359369361'; //I just hardcoded my number because i have verified this on TWILIO trial account so that i can receive sms.
            $message = 'Hey Mr/Mrs '.$user->name.' Your account has been deleted';
            //Function for sending SMS is written in app\Http\helpers
            sendSms($phone, $message) ? $smsConfirmation = "SMS sent to ".$phone : $smsConfirmation = "SMS failed for ".$phone;

            //If code is processed without any errors, record will be deleted successfully
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully, email is sent to user email and '.$smsConfirmation,
                'result' => $user,
            ]);
        } catch (\Exception $ex) {
            //If we catch any error at any point, it will rollback current Database deletion process and won't left an incomplete operation
            DB::rollback();
            //If we catch any error at any point, this will tell us about exact error
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'result' => (object) []]);
        }
    }
}
