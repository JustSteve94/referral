<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'amount' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('home')->withErrors($validator);
        } else {
            $this->makeDeposit($request);

            return Redirect::to('home');
        }
    }

    public function makeDeposit(Request $request) {
        $amount = $request->amount;

        $user = Auth::user();

        $this->checkReferral($amount, $user);

        $request->session()->flash('alert-success', 'Deposit was successfully made!' );
    }

    public function checkReferral(int $amount, User $user, $counter=0) {
        $user_referred_by = $user->referred_by;
        $counter++;

        if ($user_referred_by) {
            $tax = $this->applyReferralTax($amount);
            
            $this->updateUserDeposit($user, $amount);

            $user_parent = $this->findUserReferral($user_referred_by);
            
            if ($counter <= 1) {
                $this->checkReferral($tax, $user_parent, $counter);
            } else {
                $this->updateUserDeposit($user_parent, $tax);
            }
        } else {
            $this->updateUserDeposit($user, $amount);
        }
    }

    public function applyReferralTax(&$amount) {
        $tax_amount = 0.1 * $amount;
        $amount -= $tax_amount;

        return $tax_amount; // final sum of money palced in account
    }

    public function findUserReferral($user_referred_by) {
        $user_referral = User::where('referral_id', $user_referred_by)->first();

        return $user_referral;
    }

    public function updateUserDeposit(User $user, $amount) {
        $user_deposit = $user->amount;
        $user_deposit += $amount;
        $user->update(['amount' => $user_deposit]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
