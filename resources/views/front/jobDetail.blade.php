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
                                <div class="apply_now {{ ($count == 1) ? 'save-job' : '' }}">
                                    <a class="heart_mark" href="javascript:void(0);" onclick="shareJob({{ $job->id }})"> <i class="fa fa-link" aria-hidden="true"></i></a>
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
                            <button onclick="shareJob({{ $job->id }});" class="btn btn-danger">Share</button>
                            @if (Auth::check())
                                <button type="button" onclick="applyJob({{ $job->id }})" class="btn btn-outline-danger">Apply Now</button>
                            @else
                                <a href="{{ route('account.login') }}" class="btn btn-outline-danger">Login to apply</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if (Auth::user())
                    @if (Auth::user()->id == $job->user_id)
                <div class="card shadow border-0 mt-4">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                <div class="jobs_conetent">
                                    <h4>Applicants</h4>
                                </div>
                            </div>
                            <div class="jobs_right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Applied date</th>
                            </tr>
                            @if ($applications->isNotEmpty())
                                @foreach ($applications as $application)
                                    <tr>
                                        <td>{{ $application->user->name }}</td>
                                        <td>{{ $application->user->email }}</td>
                                        <td>{{ $application->user->mobile }}</td>
                                        <td>{{ \Carbon\Carbon::parse($application->applied_at)->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No applicants found</td>
                                    </tr>
                            @endif
                        </table>
                        
                        <div class="border-bottom"></div>
                    </div>
                </div>
                @endif
                @endif
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
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to apply for this job.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, apply!'
    }).then((result) => {
        if (result.isConfirmed) {
            let progress = 0;
            Swal.fire({
                title: 'Applying...',
                html: `
                    <div style="width: 100%; background-color: #eee; height: 10px; border-radius: 5px; overflow: hidden;">
                        <div id="progress-bar" style="width: 0%; height: 100%; background-color: #d33;"></div>
                    </div>
                    <p style="margin-top:10px;">Please wait while we submit your application.</p>
                `,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    const bar = document.getElementById('progress-bar');
                    const interval = setInterval(() => {
                        progress += 5;
                        if (progress > 95) progress = 95;
                        bar.style.width = progress + '%';
                    }, 200);

                    $.ajax({
                        url: '{{ route("applyJob") }}',
                        type: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            clearInterval(interval);
                            bar.style.width = '100%';
                            setTimeout(() => {
                                Swal.fire({
                                    icon: response.status ? 'info' : 'info',
                                    title: response.status ? 'Applied!' : 'Error',
                                    text: response.message
                                });
                                if (response.status) {
                                    $('button[onclick*="applyJob"]').prop('disabled', true).text('Applied');
                                }
                            }, 300);
                        },
                        error: function(xhr) {
                            clearInterval(interval);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    });
                }
            });
        }
    });
}



function shareJob(id) {
    const jobUrl = "{{ url('jobs') }}/" + id;

    navigator.clipboard.writeText(jobUrl).then(() => {
        Swal.fire({
            icon: 'info',
            title: 'Link copied!',
            text: 'Job link has been copied to your clipboard.',
            timer: 2000,
            showConfirmButton: false
        });
    }).catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Unable to copy the link. Please try again.'
        });
        console.error('Copy failed', err);
    });
}



</script>
@endsection

