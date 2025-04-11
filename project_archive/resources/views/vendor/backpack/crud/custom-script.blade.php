@push('after_scripts')
<script>
    $(document).ready(function() {
        // Hide rejection reason field by default
        $(".rejection-reason-field").hide();
        
        // Function to toggle rejection reason field
        function toggleRejectionReason() {
            if ($("#status").val() === "rejected") {
                $(".rejection-reason-field").show();
            } else {
                $(".rejection-reason-field").hide();
            }
        }
        
        // Run on page load
        toggleRejectionReason();
        
        // Run when status changes
        $("#status").change(function() {
            toggleRejectionReason();
        });
    });
</script>
@endpush

@include('vendor.backpack.crud.custom-script')
</body>