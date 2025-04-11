@if($entry->status === 'pending')
    <a href="{{ url(config('backpack.base.route_prefix') . '/dissertation/' . $entry->id . '/approve') }}" class="btn btn-sm btn-success">
        <i class="la la-check"></i> Approve
    </a>
@endif