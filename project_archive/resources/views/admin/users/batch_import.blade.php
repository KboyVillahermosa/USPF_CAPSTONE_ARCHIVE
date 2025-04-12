@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Batch Import Users</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upload CSV File</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.batch.import') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="csv_file">CSV File</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                            <small class="form-text text-muted">
                                Please upload a CSV file with the following columns:
                                <code>name, email, role, department</code> (required),
                                <code>course, year_level, student_id, position, password</code> (optional)
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <div class="alert alert-info">
                                <strong>Note:</strong> If password is not provided, a random password will be generated.
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <a href="{{ backpack_url('user') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Import Users</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Sample CSV Format</h3>
                </div>
                <div class="card-body">
                    <pre>name,email,role,department,course,year_level,student_id,position,password
John Doe,john@example.com,student,CCS,BSIT,3rd,1234567,,"password123"
Jane Smith,jane@example.com,faculty,COE,,,4567890,Professor,"password456"
Admin User,admin@example.com,admin,CBA,,,,Manager,"password789"</pre>
                </div>
            </div>
        </div>
    </div>
@endsection