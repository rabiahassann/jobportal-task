<x-app-layout>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title"> My Job Applicants</h3>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            @if(isset($applications) && count($applications) > 0)
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Job Title</th>
                                    <th>Applied At</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $applicant)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $applicant->jobPost->title }}</td>
                                    <td>{{ $applicant->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge 
                                           @if($applicant->status == 'approved')
                                            bg-success
                                            @elseif($applicant->status == 'pending')
                                            bg-warning
                                            @elseif($applicant->status == 'rejected')
                                            bg-danger
                                            @else
                                            bg-secondary
                                            @endif">
                                            {{ $applicant->status }}
                                        </span>
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="8" class="text-center">You hav'nt applied for any job.</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>