<!-- Add this to your sidebar menu -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dissertation') }}">
        <i class="nav-icon la la-book"></i> Dissertations
        @php
            $pendingDissertations = \App\Models\Dissertation::where('type', 'dissertation')
                                                           ->where('status', 'pending')
                                                           ->count();
        @endphp
        @if($pendingDissertations > 0)
            <span class="badge badge-danger">{{ $pendingDissertations }}</span>
        @endif
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('thesis') }}">
        <i class="nav-icon la la-scroll"></i> Theses
        @php
            $pendingTheses = \App\Models\Dissertation::where('type', 'thesis')
                                                     ->where('status', 'pending')
                                                     ->count();
        @endphp
        @if($pendingTheses > 0)
            <span class="badge badge-danger">{{ $pendingTheses }}</span>
        @endif
    </a>
</li>