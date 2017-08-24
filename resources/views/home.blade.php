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
                    <form method="POST" class="form-horizontal" action="{{url('/')}}/balance/{{Auth::user()->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form form-group">
                            <label for="amount" class="col-md-4 control-label">Amount</label>
                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control" name="amount" value="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>

                        <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                              @if(Session::has('alert-' . $msg))

                              <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                              @endif
                            @endforeach
                        </div> <!-- end .flash-message -->
                    </form>
                </div>
            </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Referral Link</div>
                    <div class="panel-body">
                        <a href="{{url('/register').'?ref='.Auth::user()->referral_id}}">{{url('/register').'?ref='.Auth::user()->referral_id}}</a>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
