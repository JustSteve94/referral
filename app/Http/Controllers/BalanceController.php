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

        $user_deposit = Auth::user()->amount;

        $referralChildID = Auth::user()->referred_by;

        if ($referralChildID) {
            $percentage = 0.1 * $amount;// REPEATED
            $amount -= $percentage;// REPEATED
            
            $referralParent = User::where('referral_id', $referralChildID)->first();// REPEATED
            $referralParentID = $referralParent->referred_by;
            if ($referralParentID) {
                $referralGrandParent = User::where('referral_id', $referralParentID)->first();// REPEATED
                $percentage2 = 0.1 * $percentage; // REPEATED
                $percentage -= $percentage2;// REPEATED
                $grandParentAmount = $referralGrandParent->amount;// REPEATED
                $grandParentAmount += $percentage2;
                $referralGrandParent->update(['amount' => $grandParentAmount]);
            }
            $parentAmount = $referralParent->amount;// REPEATED
            $parentAmount += $percentage;
            $referralParent->update(['amount' => $parentAmount]);
        }

        $user_deposit += $amount;
        // store
        Auth::user()->update(['amount' => $user_deposit]);

        // redirect
        $request->session()->flash('alert-success', 'Deposit was successfully made!' );
    }

    public function checkReferral(int $amount) {
        $user_referred_by = Auth::user()->referred_by;

        if ($user_referred_by) {
            $arr[] = $this->applyReferralTax($amount);
        }
    }

    public function applyReferralTax(int $amount) {
        $tax_amount = 0.1 * $amount;
        $amount -= $tax_amount;

        return array($tax_amount, $amount); // final sum of money palced in account
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
