@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading clearfix">
                    <span class="ttl">Users</span>
                    <a class="btn btn-default btn-sm pull-right" href="{{ route('register') }}"><i class="glyphicon glyphicon-plus"></i> New User</a>
                </div>
                <div class="panel-body">
                    <ul class="list-group" style="margin:0">
                    @foreach ($users as $user)
                        <li class="list-group-item">
                            <i class="glyphicon glyphicon-user"></i> <strong>{{ $user->name }}</strong> ({{ $user->email }})
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection