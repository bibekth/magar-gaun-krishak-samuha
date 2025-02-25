<?php

namespace App\Http\Controllers;

use App\Models\FinalSaving;
use App\Models\MonthlyDownPayment;
use App\Models\MonthlyTransaction;
use App\Models\User;
use App\Traits\ForAPISection;
use App\Traits\NepaliCalender;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    use ForAPISection, NepaliCalender;
    public function main(Request $request)
    {
        // totalSavings, totalDebtCollected, payableInterest, payableSaving, fine, userName?
        $user = Auth::user();
        // $nepali_date = $this->AD_to_BS(today());
        if ($user->role->name == 'User') {
            $data['userName'] = $user->name;
            $data['totalSavings'] = $user->finalSaving ? $user->finalSaving->total_savings : 0;
            $data['downPaymentHistory'] = $user->monthlyDownPayments;
            $data['monthlyTransactionHistory'] = $user->monthlyTransactions;
            $data['remainingDebt'] = $user->remainingDebt ? $user->remainingDebt->debt_amount : 0;
            // $lastDownPayment = $data['downPaymentHistory'][count($data['downPaymentHistory']) - 1];
            // $diffInYear = intval($nepali_date['year']) - intval($lastDownPayment->year);
            // $diffInMonth = intval($nepali_date['month']) - intval($lastDownPayment->month);
            // if ($diffInYear !== 0) {
            //     $diffInMonth += $diffInYear * 12;
            // }
            $diffInMonth = $user->remainingDebt->unpaid_months + 1;
            $data['payableInterest'] = 0.01 * $data['remainingDebt'] * $diffInMonth;
            $data['payableSaving'] = 500 * $diffInMonth;
            $data['fine'] = 50 * ($diffInMonth - 1);
            $data['totalDebtCollected'] = $user->totalDebtCollected ? $user->totalDebtCollected->total_debt_collected_till_now : 0;
            $data['lastDownPayment'] = $data['downPaymentHistory'][count($data['downPaymentHistory']) - 1];
            $data['unpaid_months'] = $user->remainingDebt->unpaid_months;
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

        $user = User::where('phone_number', $request->credential)->orWhere('email', $request->credential)->first();
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

    public function pay(Request $request)
    {
        try {
            DB::beginTransaction();
            // Down Payment, Year, month, kati month ko ghatauney, tyo anusar ko interest, savings, ra fine aaxa ki nai?
            $user = Auth::user();
            $remainingDebt = $user->remainingDebt;
            $nepali_date = $this->AD_to_BS(today());
            MonthlyTransaction::create([
                'user_id' => $user->member_id,
                'year' => $request->year ?: $nepali_date['year'],
                'month' => $request->month ?: $nepali_date['month'],
                'savings' => $request->savings,
                'down_payment_amount' => $request->down_payment_amount,
                'interest' => $request->interest,
                'fined' => $request->fine,
                'total_collected_amount' => $request->savings + $request->down_payment_amount + $request->interest,
            ]);
            $remainingDebt->update(['debt_amount' => DB::raw('debt_amount - ' . $request->down_payment_amount), 'unpaid_months' => DB::raw('unpaid_months - ' . ($request->unpaid_months - 1))]);
            $user->finalSaving->update(['total_savings' => DB::raw('total_savings + ' . $request->savings)]);
            MonthlyDownPayment::create([
                'user_id' => $user->member_id,
                'down_payment_amount' => $request->down_payment_amount,
                'year' => $request->year ?: $nepali_date['year'],
                'month' => $request->month ?: $nepali_date['month']
            ]);
            DB::commit();
            return response()->json(['status'=>'success','body'=>'success'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>'error','body'=>$e], 500);
        }
    }
}
