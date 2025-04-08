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
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $applicant)
                                <tr>
                                   
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $applicant->jobPost->title }}</td>
                                    <td>{{ $applicant->created_at->format('d M Y') }}</td>
                                    <td>
                                    {{ $applicant->status }}
                                    </td>
                                    <td class="text-center">
                                      
                                        <a href="{{ route('job-applicants.download-cv', $applicant->id) }}" 
                                           class="btn btn-sm bg-info-light">
                                            <i class="fas fa-download me-1"></i> Update CV
                                        </a>
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