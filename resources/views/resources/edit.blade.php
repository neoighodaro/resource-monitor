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

            <form class="form-horizontal" action="{{ route('resources.update', $resource->id) }}" method="post">
                <input type="hidden" name="_method" value="put">
                {{ csrf_field() }}
                <div class="panel panel-info">
                    <div class="panel-heading">Edit: {{ $resource->name }}</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                              <input type="text" name="name" value="{{ old('name', $resource->name) }}" class="form-control" id="name" placeholder="e.g HNG Product WIFI" required maxlength="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Type:</label>
                            <div class="col-sm-10">
                                <select class="form-control" required name="type">
                                    <option>Select type</option>
                                    <option value="power" {{ old('type', $resource->type) == 'power' ? 'selected' : '' }}>⚡ Power</option>
                                    <option value="internet" {{ old('type', $resource->type) == 'internet' ? 'selected' : '' }}>🌏 Internet</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Report starts:</label>
                            <div class="col-sm-10">
                                <div class="input-group clockpicker">
                                <input type="text" name="resource_starts" class="form-control" value="{{ old('resource_starts',$resource->resource_starts) }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Report ends:</label>
                            <div class="col-sm-10">
                                <div class="input-group clockpicker">
                                <input type="text" name="resource_ends" class="form-control" value="{{old('resource_ends',$resource->resource_ends)}}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Exclude Weekends</label>
                            <div class="col-sm-10">
                                <select class="form-control" required name="exclude_weekends">
                                    <option value="1" {{ old('exclude_weekends', $resource->exclude_weekends) == 1 ? 'selected' : '' }}> Yes</option>
                                    <option value="0" {{ old('exclude_weekends', $resource->exclude_weekends) == 0 ? 'selected' : '' }}> No</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer clearfix">
                        <button class="btn btn-md btn-primary pull-right" type="submit">Update Resource</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection