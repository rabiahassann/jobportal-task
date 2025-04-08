<x-app-layout>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Job Applicants</h3>
            </div>
            <div class="col-auto text-end">
                <a href="{{ route('job-posts.index') }}" class="btn btn-primary add-button ml-3">
                    <i class="fas fa-arrow-left me-1"></i> Back to Jobs
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="showBulkEmailForm">
                            <i class="fas fa-envelope me-1"></i> Send Bulk Email
                        </button>
                    </div>

                    <form action="{{ route('job-applicants.send-bulk-email', $jobPost) }}" method="POST" id="bulkEmailForm" style="display: none;">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Subject</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email Message</label>
                                    <textarea class="form-control" name="message" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="sendBulkEmail">
                                    <i class="fas fa-paper-plane me-1"></i> Send Email to Selected Applicants
                                </button>
                                <button type="button" class="btn btn-secondary" id="hideBulkEmailForm">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            @if(isset($applicants) && count($applicants) > 0)
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Applied At</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applicants as $applicant)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input applicant-checkbox" 
                                                   name="applicants[]" value="{{ $applicant->id }}">
                                        </div>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $applicant->user->name }}</td>
                                    <td>{{ $applicant->user->email }}</td>
                                    <td>{{ $applicant->created_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('job-applicants.update-status', $applicant->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                                <option value="pending" {{ $applicant->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="accepted" {{ $applicant->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="rejected" {{ $applicant->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('job-applicants.download-cv', $applicant->id) }}" 
                                           class="btn btn-sm bg-info-light">
                                            <i class="fas fa-download me-1"></i> Download CV
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="8" class="text-center">No applicants found for this job post.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#selectAll').change(function() {
            var isChecked = $(this).prop('checked');
            $('.applicant-checkbox').each(function() {
                $(this).prop('checked', isChecked);
            });
            updateBulkEmailButton();
        });

        $('.applicant-checkbox').change(function() {
            updateSelectAllCheckbox();
            updateBulkEmailButton();
        });

        function updateSelectAllCheckbox() {
            var allChecked = $('.applicant-checkbox:checked').length === $('.applicant-checkbox').length;
            $('#selectAll').prop('checked', allChecked);
        }

        function updateBulkEmailButton() {
            var hasChecked = $('.applicant-checkbox:checked').length > 0;
            $('#showBulkEmailForm').prop('disabled', !hasChecked);
        }

        $('#showBulkEmailForm').click(function() {
            if ($('.applicant-checkbox:checked').length === 0) {
                alert('Please select at least one applicant first');
                return;
            }
            $('#bulkEmailForm').toggle();
            $(this).hide();
        });

        $('#hideBulkEmailForm').click(function() {
            $('#bulkEmailForm').toggle();
            $('#showBulkEmailForm').show();
        });

        $('#bulkEmailForm').submit(function(e) {
            e.preventDefault();

            if ($('.applicant-checkbox:checked').length === 0) {
                alert('Please select at least one applicant');
                return;
            }

            var selectedApplicants = [];
            $('.applicant-checkbox:checked').each(function() {
                selectedApplicants.push($(this).val());
            });

            $('input[name="applicants[]"]').remove(); // Remove previous applicants array input
            selectedApplicants.forEach(function(applicantId) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'applicants[]',
                    value: applicantId
                }).appendTo('#bulkEmailForm');
            });

            if (confirm('Are you sure you want to send this email to selected applicants?')) {
                this.submit();
            }
        });

        updateBulkEmailButton();

        // Add success/error message handling for status updates
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    });
</script>

<style>
    .status-select {
        width: 120px;
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
        cursor: pointer;
    }
    
    .status-select:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

</x-app-layout>