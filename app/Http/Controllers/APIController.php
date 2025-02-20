<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ForAPISection;
use App\Traits\NepaliCalender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    use ForAPISection, NepaliCalender;
    public function main(Request $request)
    {
        // totalSavings, totalDebtCollected, payableInterest, payableSaving, fine, userName?
        $user = Auth::user();
        $nepali_date = $this->AD_to_BS(today());
        if ($user->role->name == 'User') {
            $data['userName'] = $user->name;
            $data['totalSavings'] = $user->finalSaving->total_savings;
            $data['downPaymentHistory'] = $user->monthlyDownPayments;
            $data['monthlyTransactionHistory'] = $user->monthlyTransactions;
            $data['remainingDebt'] = $user->remainingDebt->debt_amount;
            $lastDownPayment = $data['downPaymentHistory'][count($data['downPaymentHistory']) - 1];
            $diffInYear = intval($nepali_date['year']) - intval($lastDownPayment->year);
            $diffInMonth = intval($nepali_date['month']) - intval($lastDownPayment->month);
            if ($diffInYear !== 0) {
                $diffInMonth += $diffInYear * 12;
            }
            $data['payableInterest'] = 0.01 * $data['remainingDebt'] * $diffInMonth;
            $data['payableSaving'] = 500 * $diffInMonth;
            $data['fine'] = 50 * ($diffInMonth - 1);
            $data['totalDebtCollected'] = $user->totalDebtCollected->total_debt_collected_till_now;
            return response()->json(['status' => 'success', 'body' => $data], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credential' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'body' => $validator->errors()], 500);
        }

        $user = User::where('phone_number', $request->credential)->orWhere('email', $request->credentail)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'body' => 'User not found by this credential.'], 401);
        } else {
            $check = Hash::check($request->password, $user->password);
            if ($check === false) {
                return response()->json(['status' => 'error', 'body' => "Password didn't matched."], 401);
            }
        }

        if ($user->token == null) {
            $token = $this->generateToken();
        } else {
            $token = $user->token;
        }
        $user->update(['token' => $token, 'device_id' => $request->device_id, 'fcm_id' => $request->fcm_id]);
        Auth::login($user);
        $authuser = Auth::user();
        if ($user->phone_number == $request->credential) {
            return response()->json(['status' => 'Success', 'body' => ['token' => $token, 'role' => 'User', 'user' => $authuser]], 200);
        } else {
            return response()->json(['status' => 'Success', 'body' => ['token' => $token, 'role' => 'Admin', 'user' => $authuser]], 200);
        }
    }
}
