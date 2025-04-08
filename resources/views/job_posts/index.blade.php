<x-app-layout>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Job Listing</h3>
            </div>
            <div class="col-auto text-end">
                <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>
                <a href="{{route('job-posts.create')}}" class="btn btn-dark add-button ml-3">
                    <i class="fas fa-plus">Add Job Post</i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            @if(isset($jobPosts))
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Job Title</th>
                                    <th>Category</th>
                                    <th>Job Type</th>
                                    <th>Applied Before</th>
                                    <th class="text-center">Action</th>
                                    <th class="">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobPosts as $jobPost)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$jobPost->title}}
                                    </td>
                                    <td>{{$jobPost->category}}</td>
                                    <td>{{$jobPost->job_type}}</td>
                                    <td>{{$jobPost->applied_before}}</td>
                                    <td class="text-center">

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('job-posts.edit', ['jobPost' => $jobPost->id]) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>

                                            <form action="{{ route('job-posts.destroy', ['jobPost' => $jobPost->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>


                                    </td>
                                    <td>
                                        <a href="{{ route('job-applicants.show', ['jobPost' => $jobPost->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-users me-1"></i> View Applicants
                                        </a>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <div class="flex justify-center mt-4">

                        </table>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>