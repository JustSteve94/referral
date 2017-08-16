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
            @if(!Auth::user()->referred_by)
                <div class="panel panel-default">
                    <div class="panel-heading">Referral Link</div>
                        <a href="{{url('/register').'?ref='.Auth::user()->referral_id}}">{{url('/register').'?ref='.Auth::user()->referral_id}}</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
