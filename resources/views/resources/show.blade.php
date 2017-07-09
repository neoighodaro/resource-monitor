@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body record-title">
                    <div class="clearfix">
                        <h1 class="pull-left">{{ $resource->type == 'power' ? '⚡️' : '🌏' }} {{ $resource->name }}</h1>
                        <a class="btn btn-sm btn-default pull-right" style="position:relative;top:5px;margin-left: 5px;" href="{{ route('resources.edit', $resource->id) }}">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <form method="post" action="{{ route('resources.destroy', $resource->id) }}" onsubmit="return confirm('Are you sure you want to delete this resource?')">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete"/>
                            <button class="btn btn-sm btn-danger pull-right" style="position:relative;top:5px">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </form>
                    </div>
                    <div><strong>ID: {{ $resource->id }}</strong></div>
                    <span class="label label-primary">
                        {{ $resource->type }}
                    </span>&nbsp;
                    <span class="label label-default">
                        {{ 'Last Record: ' . $lastRecord }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Date Range
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <form method="get" action="">
                                <div class="input-daterange input-group" id="datepicker">
                                    <span class="input-group-addon">From</span>
                                    <input type="text" class="style input-lg form-control" placeholder="Click to select from date" name="start" readonly />
                                    <span class="input-group-addon">To</span>
                                    <input type="text" class="style input-lg form-control" placeholder="Click to select to date" name="end" readonly />
                                    <div class="input-group-btn">
                                        <button class="btn btn-lg btn-primary" type="submit">
                                            <i class="glyphicon glyphicon-filter"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">Total Records</div>
                <div class="panel-body">
                    <span class="huge">{{ $stats->get('records')->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">Uptime Percentage</div>
                <div class="panel-body">
                    <span class="huge huge-success">{{ $stats->get('uptime_percentage') }}%</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">Downtime Percentage</div>
                <div class="panel-body">
                    <span class="huge huge-danger">{{ $stats->get('downtime_percentage') }}%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">Per Minute Breakdown</div>
                <div class="panel-body">
                    <ul class="list-group" style="margin-bottom: 0">
                    @forelse ($resource->records as $record)
                        <li class="record list-group-item list-group-item-{{ $record->available ? "success" : "danger" }}">
                            {{ $record->created_at->format('D jS F, Y – h:ia') }}
                            <span class="badge">{{ $record->available ? "&#x2191;" : "&#x2193;" }}</span>
                        </li>
                    @empty
                        <li class="list-group-item list-group-item-blank">There are no records to show, change the filter date range.</li>
                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection