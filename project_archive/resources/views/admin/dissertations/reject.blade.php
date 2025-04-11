@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Reject Dissertation</span>
            <small>{{ $dissertation->title }}</small>
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Provide Feedback</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url(config('backpack.base.route_prefix') . '/dissertation/' . $dissertation->id . '/reject') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="rejection_reason">Reason for Rejection</label>
                            <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="5" required>{{ old('rejection_reason') }}</textarea>
                            <small class="form-text text-muted">Please provide detailed feedback explaining why this dissertation was rejected.</small>
                            
                            @if($errors->has('rejection_reason'))
                                <div class="text-danger">
                                    {{ $errors->first('rejection_reason') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Reject Submission</button>
                            <a href="{{ url(config('backpack.base.route_prefix') . '/dissertation') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection