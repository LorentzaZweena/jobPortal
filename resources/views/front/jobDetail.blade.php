@extends('front.layouts.app')
@section('main')
<section class="section-4 bg-2">
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}" class="text-danger"><i class="fa fa-arrow-left text-danger" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                @include('front.message')
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                <div class="jobs_conetent">
                                    <a href="#" class="text-danger">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i>&nbsp; {{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>&nbsp; {{ $job->jobType->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            @if (!empty($job->description))
                                <p>{!! nl2br($job->description) !!}</p>
                            @endif
                        </div>
                        
                        @if (!empty($job->responsibility))
                            <div class="single_wrap">
                                <h4>Responsibility</h4>
                                <p>{!! nl2br($job->responsibility) !!}</p>
                            </div>
                        @endif
                        
                        @if (!empty($job->qualifications))
                            <div class="single_wrap">
                                <h4>Qualifications</h4>
                                <p>{!! nl2br($job->qualifications) !!}</p>
                            </div>
                        @endif
                        
                        @if (!empty($job->benefit))
                            <div class="single_wrap">
                                <h4>Benefits</h4>
                                <p>{!! nl2br($job->benefit) !!}</p>
                            </div>
                        @endif
                        
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            @if (Auth::check())
                                <a href="#" onclick="saveJob({{ $job->id }});" class="btn btn-danger">Save</a>
                            @else
                                <a href="{{ route('account.login') }}" class="btn btn-outline-danger">Login to save</a>
                            @endif

                            @if (Auth::check())
                                <button type="button" onclick="applyJob({{ $job->id }})" class="btn btn-outline-danger">Apply Now</button>
                            @else
                                <a href="{{ route('account.login') }}" class="btn btn-outline-danger">Login to apply</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summary</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</span></li>
                                <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                @if (!empty($job->salary))
                                    <li>Salary: <span>{{ $job->salary }}</span></li>
                                @endif
                                <li>Location: <span>{{ $job->location }}</span></li>
                                <li>Job type: <span>{{ $job->jobType->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{ $job->company_name }}</span></li>
                                @if (!empty($job->company_location))
                                    <li>Location: <span>{{ $job->company_location }}</span></li>
                                @endif
                                @if (!empty($job->company_website))
                                    <li>Website: <span><a href="{{ $job->company_website }}" target="_blank" class="link-danger link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">{{ $job->company_website }}</a></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script type="text/javascript">
function applyJob(id) {
    if(confirm('Are you sure you want to apply for this job?')) {
        $.ajax({
            url: '{{ route("applyJob") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                $('.alert').remove();
                let alertClass = response.status ? 'alert-success' : 'alert-danger';
                let alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show mb-5" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            
                $('.job_details_header').before(alertHtml);
                $('html, body').animate({scrollTop: 0}, 500);
                if(response.status) {
                    $('button[onclick*="applyJob"]').prop('disabled', true).text('Applied');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('.alert').remove();
                let alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Something went wrong. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.job_details_header').before(alertHtml);
                $('html, body').animate({scrollTop: 0}, 500);
            }
        });
    }
}

function saveJob(id) {
    if(confirm('Are you sure you want to apply for this job?')) {
        $.ajax({
            url: '{{ route("saveJob") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                $('.alert').remove();
                let alertClass = response.status ? 'alert-success' : 'alert-danger';
                let alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show mb-5" role="alert">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            
                $('.job_details_header').before(alertHtml);
                $('html, body').animate({scrollTop: 0}, 500);
                if(response.status) {
                    $('button[onclick*="saveJob"]').prop('disabled', true).text('Applied');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('.alert').remove();
                let alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Something went wrong. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.job_details_header').before(alertHtml);
                $('html, body').animate({scrollTop: 0}, 500);
            }
        });
    }
}
</script>
@endsection

