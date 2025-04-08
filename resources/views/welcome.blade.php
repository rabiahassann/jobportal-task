<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - Your Website Name</title>
    <!-- Bootstrap CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- TailwindCSS CDN (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
    .job-card:hover {
        transform: scale(1.05);
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
    }

    .job-card {
        transition: all 0.3s ease;
    }
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Job Portal Task</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @guest
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
                    @else
                    @if(Auth::user()->role == 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Filters Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h5>Filter Jobs</h5>
                <form method="GET" action="{{ route('home') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="location">Location</label>
                            <select class="form-control" id="location" name="location">
                                <option value="">Any Location</option>
                                @foreach($locations as $location)
                                <option value="{{ $location }}"
                                    {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="job_type">Job Type</label>
                            <select class="form-control" id="job_type" name="job_type">
                                <option value="">Any Job Type</option>
                                @foreach($jobTypes as $type)
                                <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category">Job Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Any Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-dark btn-block">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(session('alert'))
        <script>
        alert("{{ session('alert') }}");
        </script>
        @endif

        @if(isset($activeJobPosts))
        <h1 class="text-center mb-4">Job Listings</h1>
        <div class="row">
        @foreach($activeJobPosts as $job)
    <div class="col-md-4 mb-3">
        <div class="card job-card shadow-sm border-light rounded-lg">
            <div class="card-body">
                <h5 class="card-title">{{ $job->title }}</h5>
                <p class="card-text">Category: {{ $job->category }}</p>
                <p class="card-text">Location: {{ $job->location }}</p>
                <p class="card-text">{{ $job->description }}</p>
                <p class="card-text text-muted">Posted: {{ \Carbon\Carbon::parse($job->created_at)->format('F j, Y') }}</p>
                <p class="card-text text-muted">Last date to apply: {{ \Carbon\Carbon::parse($job->applied_before)->format('F j, Y') }}</p>

                @if(Auth::check())
                    <!-- Check if the user has already applied for this job -->
                    @php
                        $alreadyApplied = \App\Models\JobApplicant::where('user_id', Auth::id())
                                                                ->where('job_post_id', $job->id)
                                                                ->exists();
                    @endphp

                    @if($alreadyApplied)
                        <button class="btn btn-secondary" disabled>Applied</button>
                    @else
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applyModal{{ $job->id }}">
                            Apply Now
                        </button>
                    @endif
                @else
                    <a href="{{ url('/login') }}" class="btn btn-primary">Apply Now</a>
                @endif
            </div>
        </div>
    </div>

    @if(Auth::check())
        <!-- Apply Modal -->
        <div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel{{ $job->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('apply.job') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applyModalLabel{{ $job->id }}">Apply for: {{ $job->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Cover Letter</label>
                                <textarea name="cover_letter" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Upload CV</label>
                                <input type="file" name="cv" class="form-control-file" required accept=".pdf,.doc,.docx">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark">Submit Application</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endforeach

        </div>
        @endif
    </div>

    <!-- Bootstrap JS + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- NOT slim -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>