<x-app-layout>
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Products</h3>
            </div>
            <div class="col-auto text-end">
                <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a>
                <a href="{{route('job-posts.create')}}" class="btn btn-primary add-button ml-3">
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
                                        <th>Salery Range</th>
                                        <th>Applied Before</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobPosts as $jobPost)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                        {{$jobPost->title}}
                                        </td>
                                     
                                        <td>{{$jobPost->salary_range}}</td>
                                        <td>{{$jobPost->created_at}}</td>
                                       
                                        <td class="text-center">
                                          
                                            <a href="{{ route('job-posts.edit', ['jobPost' => $jobPost->id]) }}"
                                                class="btn btn-sm bg-success-light">
                                                <i class="far fa-edit me-1">Edit</i> 
                                            </a>
                                            <a href="{{ route('job-applicants.show', ['jobPost' => $jobPost->id]) }}"
                                                class="btn btn-sm bg-primary-light">
                                                <i class="far fa-eye me-1">View Applicants</i>
                                            </a>
                                            <form action="{{ route('job-posts.destroy', ['jobPost' => $jobPost->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-danger-light">
                                                    <i class="far fa-trash me-1">Delete</i> 
                                                </button>
                                            </form>
                                        
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