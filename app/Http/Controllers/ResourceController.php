<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\{Resource, ResourceRecord};
use App\Http\Requests\{
    ResourceUpdateRequest as UpdateRequest,
    ResourceCreateRequest as CreateRequest,
    ResourceRecordsShowRequest as ShowRequest,
    ResourceStatusUpdateRequest as RecordUpdateRequest
};

class ResourceController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('generate', 'updateStatus');
    }

    /**
     * Generate records for the beacon to validate.
     *
     * @param  Resource $resource
     * @return array
     */
    public function generate(Resource $resource) : array
    {
        $resource->get()->each->generateNewRecord();

        return ['status' => 'success', 'message' => 'Records generated!'];
    }

    /**
     * Generates a new record for the resource.
     *
     * @param  ResourceRecord $record
     * @param  RecordUpdateRequest  $request
     * @return array
     */
    public function updateStatus(ResourceRecord $record, RecordUpdateRequest $request) : array
    {
        $updated = $record->updateAvailability($request);

        return [
            'status'  => ($updated ? 'success' : 'error'),
            'message' => ($updated ? 'Record updated.' : 'Record update failed.'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Resource $resources)
    {
        $resources = $resources->ordered()->paginate(3600)->get();
        
        return view('resources.index', compact('resources'));
    }

    /**
     * Show the resource and the records (filterable by date range)
     *
     * @param  ShowRequest $request
     * @param  Resource    $resource
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(ShowRequest $request, Resource $resource)
    {
        $lastRecord = $resource->records->last();
        $lastRecord = $lastRecord ? $lastRecord->created_at->diffForHumans() : 'Nothing recorded';

        $resource = $resource->withRecordsWithinDateRange($request->startDate(), $request->endDate());

        $stats = generate_stats_from_records($resource->records);

        return view('resources.show', compact('resource', 'stats', 'lastRecord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        Resource::create($request->only(['name', 'type','resource_starts','resource_ends','exclude_weekends']));

        return redirect(route('resources.index'))->withSuccess('Resource created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Resource $resource)
    {
        $resource->update($request->only('name', 'type','resource_starts','resource_ends','exclude_weekends'));

        return redirect(route('resources.show', $resource->id))->withSuccess('Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect(route('resources.index'))->withSuccess('Resource deleted!');
    }
}
