<x-app-layout>

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-xl-8 offset-xl-2">

                    <div class="page-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="page-title">Edit Job Post</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('job-posts.update', ['jobPost' => $jobPost->id])}}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="{{$jobPost->title}}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Job Category</label>
                                    <input type="text" class="form-control" name="category"
                                        value="{{$jobPost->category}}" required>
                                </div>
                                <div class="form-group">
                                    <label>location</label>
                                    <input type="text" class="form-control" name="location"
                                        value="{{$jobPost->location}}" required>
                                </div>

                                <div class="form-group">
                                    <label>Job Type</label>
                                    <select class="form-control" name="job_type" required>
                                        <option value="">-- Select Job Type --</option>
                                        <option value="full_time"
                                            {{ $jobPost->job_type == 'full_time' ? 'selected' : '' }}>Full Time
                                        </option>
                                        <option value="part_time"
                                            {{ $jobPost->job_type == 'part_time' ? 'selected' : '' }}>Part Time
                                        </option>
                                        <option value="internship"
                                            {{ $jobPost->job_type == 'internship' ? 'selected' : '' }}>Internship
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Apllied Before</label>
                                    <input type="date" class="form-control" name="applied_before"
                                        value="{{$jobPost->applied_before}}" required>
                                </div>

                                <!-- Price -->
                                <div class="form-group">
                                    <label>Salery Range</label>
                                    <input type="number" class="form-control" name="salary_range"
                                        value="{{$jobPost->salary_range}}" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="4"
                                        value="{{$jobPost->description}}" required>{{$jobPost->description}}</textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Update Job Post</button>
                                    <a href="{{ route('job-posts.index') }}" class="btn btn-link">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>