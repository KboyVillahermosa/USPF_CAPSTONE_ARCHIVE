@if($entry->status === 'pending')
    <a href="{{ url(config('backpack.base.route_prefix') . '/dissertation/' . $entry->id . '/reject') }}" class="btn btn-sm btn-danger">
        <i class="la la-times"></i> Reject
    </a>
@endif