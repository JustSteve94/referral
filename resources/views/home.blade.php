@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Balance</div>
                <div class="panel-body">
                    <form method="PATCH" action="/addmoney" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form form-group">
                            <label for="Amount" class="col-md-4 control-label">Amount</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="Amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(!Auth::user()->referred_by)
                <div class="panel panel-default">
                    <div class="panel-heading">Referral Link</div>
                    <div class="panel-body">
                        <a href="{{url('/register').'?ref='.Auth::user()->referral_id}}">{{url('/register').'?ref='.Auth::user()->referral_id}}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
