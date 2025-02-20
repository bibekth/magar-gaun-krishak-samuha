<?php

namespace App\Traits;

use App\Models\FinalSaving;
use App\Models\MonthlyCollection;
use App\Models\MonthlyDownPayment;
use App\Models\MonthlyInvestedDebt;
use App\Models\MonthlyTransaction;
use App\Models\RemainingDebt;
use App\Models\TotalDebtCollection;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelReader;

trait ImportExcelTrait
{
    use NepaliCalender;
    public function getCollection($path, $filename)
    {
        try {
            $users = [];
            $password = Hash::make('12345678');
            $available_users = User::get(['id', 'member_id']);
            foreach ($available_users as $index => $user) {
                $users[$index]['id'] = $user->id;
                $users[$index]['member_id'] = $user->member_id;
            }

            $rows = SimpleExcelReader::create('storage/' . $path . $filename)->fromSheetName('normal')->getRows()->toArray();
            $debtInvestment = SimpleExcelReader::create('storage/' . $path . $filename)->fromSheetName('debt')->getRows()->toArray();
            foreach ($rows as $row) {
                $present = collect($users)->firstWhere('member_id', $row['member_id']);
                if (empty($present)) {
                    User::create(['member_id' => $row['member_id'], 'name' => $row['name'], 'password' => $password, 'role_id' => 3, 'phone_number' => $row['phone_number']]);
                    FinalSaving::create(['user_id'=>$row['member_id'],'total_savings'=>0]);
                    TotalDebtCollection::create(['user_id'=>$row['member_id'], 'total_debt_collected_till_now'=>0]);
                }
            }
            $this->makeMonthlyTransaction($rows, $debtInvestment);
            return 'success';
        } catch (Exception $e) {
            Log::error('Error in getCollection: ' . $e->getMessage());
            return 'failed on getCollection';
        }
    }

    public function makeMonthlyTransaction($rows, $debtInvestment)
    {
        try {
            $monthlyTrasaction = [];
            $now = now();
            $nepali_date = $this->AD_to_BS(today());
            foreach ($rows as $index => $row) {
                $monthlyTrasaction[$index]['user_id'] = $row['member_id'];
                $monthlyTrasaction[$index]['year'] = $row['year'];
                $monthlyTrasaction[$index]['month'] = $row['month'];
                $monthlyTrasaction[$index]['savings'] = $row['saving'];
                $monthlyTrasaction[$index]['down_payment_amount'] = $row['down_payment'];
                $monthlyTrasaction[$index]['interest'] = $row['interest'];
                $monthlyTrasaction[$index]['fined'] = $row['fined'];
                $monthlyTrasaction[$index]['total_collected_amount'] = $row['total_collection'];
                $monthlyTrasaction[$index]['created_at'] = $now;
                $monthlyTrasaction[$index]['updated_at'] = $now;
            }
            MonthlyTransaction::insert($monthlyTrasaction);
            $this->monthlyCollection($rows, $nepali_date);
            $this->accumulateSavings($rows);
            $this->userMonthlyDownPayment($rows, $now);
            $this->remainingDebt($rows);
            $this->monthlyInvestedDebt($debtInvestment, $nepali_date, $now);
            $this->accumulateTotalDebtCollection($rows, $debtInvestment);
        } catch (Exception $e) {
            Log::error('Error in makeMonthlyTransaction: ' . $e->getMessage());
            return 'failed on makeMonthlyTransaction';
        }
    }

    public function accumulateSavings($rows)
    {
        try {
            $user_savings = DB::select('select user_id, total_savings from final_savings');
            foreach ($rows as $row) {
                $present = collect($user_savings)->firstWhere('user_id', $row['member_id']);
                if (empty($present)) {
                    FinalSaving::create(['user_id' => $row['member_id'], 'total_savings' => $row['saving']]);
                } else {
                    FinalSaving::updateOrCreate(
                        ['user_id' => $row['member_id']],
                        ['total_savings' => DB::raw('total_savings + ' . $row['saving'])]
                    );
                }
            }
        } catch (Exception $e) {
            Log::error('Error in accumulateSaving: ' . $e->getMessage());
            return 'failed on accumulateSavings';
        }
    }

    public function monthlyCollection($rows, $nepali_date)
    {
        try {
            $monthlyCollectionAmount = 0;
            foreach ($rows as $row) {
                $monthlyCollectionAmount += $row['total_collection'];
            }
            MonthlyCollection::create(['year' => $row['year'], 'month' => $row['month'], 'total_collected_amount' => $monthlyCollectionAmount]);
        } catch (Exception $e) {
            Log::error('Error in monthlyCollection: ' . $e->getMessage());
            return 'failed on monthlyCollection';
        }
    }

    public function userMonthlyDownPayment($rows, $now)
    {
        try {
            $monthlyDownPayment = [];
            foreach ($rows as $index => $row) {
                $monthlyDownPayment[$index]['user_id'] = $row['member_id'];
                $monthlyDownPayment[$index]['down_payment_amount'] = $row['down_payment'];
                $monthlyDownPayment[$index]['year'] = $row['year'];
                $monthlyDownPayment[$index]['month'] = $row['month'];
                $monthlyDownPayment[$index]['created_at'] = $now;
                $monthlyDownPayment[$index]['updated_at'] = $now;
            }
            MonthlyDownPayment::insert($monthlyDownPayment);
        } catch (Exception $e) {
            Log::error('Error in userMonthlyDownPayment: ' . $e->getMessage());
            return 'failed on userMonthlyDownPayment';
        }
    }

    public function remainingDebt($rows)
    {
        try {
            foreach ($rows as $row) {
                RemainingDebt::updateOrCreate(
                    ['user_id' => $row['member_id']],
                    ['debt_amount'=> $row['remaining_debt']]
                );
            }
        } catch (Exception $e) {
            Log::error('Error in remainingDebt: ' . $e->getMessage());
            return 'failed on remainingDebt';
        }
    }

    public function monthlyInvestedDebt($rows, $nepali_date, $now){
        try {
            $monthlyInvestedDebts= [];
            foreach ($rows as $index  => $row) {
                $monthlyInvestedDebts[$index]['user_id'] = $row['member_id'];
                $monthlyInvestedDebts[$index]['year'] = $row['year'];
                $monthlyInvestedDebts[$index]['month'] = $row['month'];
                $monthlyInvestedDebts[$index]['debt_amount'] = $row['amount'];
                $monthlyInvestedDebts[$index]['charges'] = $row['charge'];
                $monthlyInvestedDebts[$index]['final_amount'] = $row['received'];
                $monthlyInvestedDebts[$index]['created_at'] = $now;
                $monthlyInvestedDebts[$index]['updated_at'] = $now;
                RemainingDebt::updateOrCreate(
                    ['user_id'=>$row['member_id']],
                    ['debt_amount'=>DB::raw('debt_amount + '. $row['amount'])]
                );
            }
            MonthlyInvestedDebt::insert($monthlyInvestedDebts);
        } catch (Exception $e) {
            Log::error('Error in monthlyInvestedDebt: ' . $e->getMessage());
            return 'failed on monthlyInvestedDebt';
        }
    }

    public function accumulateTotalDebtCollection($rows, $debtInvestment){
        foreach($debtInvestment as $index => $debt){
            TotalDebtCollection::updateOrCreate(
                ['user_id'=>$debt['member_id']],
                ['total_debt_collected_till_now' => DB::raw('total_debt_collected_till_now + ' . $debt['amount'])]
            );
        }
    }
}
