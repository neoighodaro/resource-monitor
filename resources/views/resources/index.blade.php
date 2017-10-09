@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading clearfix">
                    <span class="ttl">Available Resources</span>
                    <a class="btn btn-default btn-sm pull-right" href="{{ route('resources.create') }}"><i class="glyphicon glyphicon-plus"></i> New Resource</a>
                </div>
                <div class="panel-body">
                    <div class="list-group" style="margin:0">
                    @forelse ($resources as $resource)
                        <a class="list-group-item" href="{{ route('resources.show', $resource->id) }}">
                           {{ $resource->type == 'power' ? '⚡️' : '🌏' }} {{ $resource->name }}
                        </a>
                    @empty
                        <div class="list-group-item" style="border:0">
                            No resources available at the moment, add one above.
                        </div>
                    @endforelse
                    </div>
                </div>

                {{ $resource->links() }}
                
            </div>
        </div>
    </div>
</div>
@endsection