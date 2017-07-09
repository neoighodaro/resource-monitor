@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            @if (session()->has('errors'))
            <div class="alert alert-danger">
              <strong>Error!</strong> {{ session()->get('errors')->first() }}
            </div>
            @endif

            <form class="form-horizontal" action="{{ route('resources.store') }}" method="post">
                {{ csrf_field() }}
                <div class="panel panel-info">
                    <div class="panel-heading">Add new resource</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                              <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" placeholder="e.g HNG Product WIFI" required maxlength="15">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Type:</label>
                            <div class="col-sm-10">
                                <select class="form-control" required name="type">
                                    <option>Select type</option>
                                    <option value="power" {{ old('type') == 'power' ? 'selected' : '' }}>⚡️ Power</option>
                                    <option value="internet" {{ old('type') == 'internet' ? 'selected' : '' }}>🌏 Internet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        <button class="btn btn-md btn-primary pull-right" type="submit">Create Resource</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection