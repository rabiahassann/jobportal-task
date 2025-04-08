<x-app-layout>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">

                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Add Product</h3>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{route('job-posts.store')}}" method="POST">
                            @csrf

            
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="form-group">
                                <label>Apllied Before</label>
                                <input type="date" class="form-control" name="applied_before" required>
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label>Salery Range</label>
                                <input type="number" class="form-control" name="salary_range" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="4" required></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Create Job Post</button>
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
