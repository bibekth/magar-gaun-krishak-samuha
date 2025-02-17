<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ForAPISection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    use ForAPISection;
    public function main(Request $request)
    {
        $user = Auth::user();
        if ($user->role->name == 'User') {
            $data['totalSaving'] = $user->finalSaving->total_savings;
            $data['downPaymentHistory'] = $user->monthlyDownPayments;
            $data['monthlyTransactionHistory'] = $user->monthlyTransactions;
            $data['remainingDebt'] = $user->remainingDebt->debt_amount;
            $data['totalDebtCollected'] = $user->totalDebtCollected->total_debt_collected_till_now;
            return response()->json(['status' => 'success', 'body' => $data], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'credential' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'body' => $validator->errors()], 500);
        }

        $user = User::where('phone_number', $request->credential)->orWhere('email', $request->credentail)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'body' => 'User not found by this credential.'], 401);
        }else{
            $check = Hash::check($request->password, $user->password);
            if($check === false){
            return response()->json(['status' => 'error', 'body' => "Password didn't matched."], 401);
            }
        }

        if ($user->token == null) {
            $token = $this->generateToken();
        } else {
            $token = $user->token;
        }
        $user->update(['token' => $token, 'device_id' => $request->query('device_id'), 'fcm_id' => $request->query('fcm_id')]);
        Auth::login($user);
        $authuser = Auth::user();
        if ($user->phone_number == $request->credential) {
            return response()->json(['status' => 'Success', 'body' => ['token' => $token, 'role' => 'User', 'user' => $authuser]], 200);
        } else {
            return response()->json(['status' => 'Success', 'body' => ['token' => $token, 'role' => 'Admin', 'user' => $authuser]], 200);
        }
    }
}
