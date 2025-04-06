@if($entry->approved)
    <span class="badge badge-success">Yes</span>
@else
    <div class="btn-group">
        <button type="button" 
                onclick="approveResearch({{ $entry->id }})"
                class="btn btn-sm btn-success">
            <i class="la la-check"></i> Yes
        </button>
        <button type="button" 
                onclick="showRejectModal({{ $entry->id }})"
                class="btn btn-sm btn-danger">
            <i class="la la-times"></i> No
        </button>
    </div>
@endif

<script>
function approveResearch(id) {
    if (confirm('Are you sure you want to approve this research?')) {
        axios.post(`/admin/research-repository/${id}/approve`)
            .then(response => {
                if (response.data.success) {
                    crud.table.ajax.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while approving the research');
            });
    }
}

function showRejectModal(id) {
    // Assuming you have a modal with id 'rejectModal' and input with id 'rejection_reason'
    $('#rejectModal').modal('show');
    $('#rejectModal').data('research-id', id);
}

function rejectResearch() {
    const id = $('#rejectModal').data('research-id');
    const reason = $('#rejection_reason').val();

    axios.post(`/admin/research-repository/${id}/reject`, {
        rejection_reason: reason
    })
    .then(response => {
        if (response.data.success) {
            $('#rejectModal').modal('hide');
            crud.table.ajax.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while rejecting the research');
    });
}
</script>