
@if ($crud->hasAccess('create'))
    <a href="{{ backpack_url('user/batch-import') }}" class="btn btn-primary" data-style="zoom-in">
        <span class="ladda-label"><i class="la la-cloud-upload"></i> Batch Import</span>
    </a>
@endif