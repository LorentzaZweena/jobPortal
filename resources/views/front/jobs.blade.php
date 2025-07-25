@extends('front.layouts.app')

@section('main')
    <section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    {{-- <select name="sort" id="sort" class="form-control">
                        <option value="latest" {{ (Request::get('sort') == 'latest' || !Request::get('sort')) ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ Request::get('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select> --}}

                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input value="{{ Request::get('location') }}" type="text" name="location" id="location" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                        <option {{ (Request::get('category') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                        </select>
                    </div>                   

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if ($jobTypes->isNotEmpty())
                            @foreach ($jobTypes as $jobType)
                                <div class="form-check mb-2"> 
                                    <input {{ (in_array($jobType->id, $jobTypeArray)) ? 'checked' : '' }} class="form-check-input job-type-checkbox" name="job_type" type="checkbox" value="{{ $jobType->id }}" id="job-type-{{ $jobType->id }}">    
                                    <label class="form-check-label " for="job-type-{{ $jobType->id }}">{{ $jobType->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <select name="experience" id="experience" class="form-control">
                            <option value="">Select Experience</option>
                                <option value="0" {{ Request::get('experience') == '0' ? 'selected' : '' }}>0 year</option>
                                <option value="1" {{ Request::get('experience') == '1' ? 'selected' : ''}}>1 year</option>
                                <option value="2" {{ Request::get('experience') == '2' ? 'selected' : ''}}>2 years</option>
                                <option value="3" {{ Request::get('experience') == '3' ? 'selected' : ''}}>3 years</option>
                                <option value="4" {{ Request::get('experience') == '4' ? 'selected' : ''}}>4 years</option>
                                <option value="5" {{ Request::get('experience') == '5' ? 'selected' : ''}}>5 years</option>
                                <option value="6" {{ Request::get('experience') == '6' ? 'selected' : ''}}>6 years</option>
                                <option value="7" {{ Request::get('experience') == '7' ? 'selected' : ''}}>7 years</option>
                                <option value="8_plus" {{ Request::get('experience') == '8_plus' ? 'selected' : ''}}>8+ year</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-danger">Search</button>
                    <a href="{{ route("jobs") }}" class="btn btn-danger mt-3">Reset</a>
                </div>
                </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">
                        @if ($jobs->isNotEmpty())
                            @foreach ($jobs as $job)
                                <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body"> 
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                    <p>{{ Str::words(strip_tags($job->description), $words=6, '...') }}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $job->location }}</span>
                                        </p>
                                        {{-- <p>{{ $job->category->name }}</p> --}}
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{ $job->jobType->name }}</span>
                                        </p>
                                        <p><i class="fa fa-briefcase"></i>&nbsp;&nbsp;{{ $job->experience_formatted }}</p>
                                        @if (!is_null($job->salary))
                                            <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $job->salary }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{ route('jobDetail', $job->id) }}" class="btn btn-outline-danger btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                            @endforeach
                        @else
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <strong>Uh oh!</strong> No jobs found.
                            </div>
                        </div>

                        @endif                 
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script>
function buildSearchUrl() {
    var url = '{{ route("jobs") }}';
    var keyword = $("#keyword").val();
    var location = $("#location").val();
    var category = $("#category").val();
    var experience = $("#experience").val();
    var sort = $("#sort").val();
    
    var jobTypes = [];
    $('input[name="job_type"]:checked').each(function() {
        jobTypes.push($(this).val());
    });
    
    var params = [];
    
    if (keyword != "") {
        params.push('keyword=' + encodeURIComponent(keyword));
    }
    
    if (location != "") {
        params.push('location=' + encodeURIComponent(location));
    }
    
    if (category != "") {
        params.push('category=' + category);
    }
    
    if (experience != "") {
        params.push('experience=' + experience);
    }
    
    if (sort != "") {
        params.push('sort=' + sort);
    }
    
    if (jobTypes.length > 0) {
        jobTypes.forEach(function(jobType) {
            params.push('job_type[]=' + jobType);
        });
    }
    
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    return url;
}

    $("#searchForm").submit(function(e){
        e.preventDefault();
        window.location.href = buildSearchUrl();
    });

    $("#sort").change(function() {
        window.location.href = buildSearchUrl();
    });

    $(".job-type-checkbox").change(function() {
        window.location.href = buildSearchUrl();
    });
</script>


@endsection
