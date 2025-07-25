@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-danger">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
<form method="POST" id="createJobForm" name="createJobForm" action="{{ route('account.saveJob') }}">
                @csrf
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Job Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Select a Category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach           
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Job type<span class="req">*</span></label>
                                <select class="form-select" name="jobType" id="jobType">
                                    <option value="">Select job type</option>
                                    @if ($jobTypes->isNotEmpty())
                                        @foreach ($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                        @endforeach           
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Salary</label>
                                <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location<span class="req">*</span></label>
                                <input type="text" placeholder="location" id="location" name="location" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="textarea" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Responsibility</label>
                            <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Qualifications</label>
                            <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Experience<span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-select">
                                <option value="0">0 year</option>
                                <option value="1">1 year</option>
                                <option value="2">2 year</option>
                                <option value="3">3 year</option>
                                <option value="4">4 year</option>
                                <option value="5">5 year</option>
                                <option value="6">6 year</option>
                                <option value="7">7 year</option>
                                <option value="8_plus">8+ year</option>
                            </select>
                            <p></p>
                        </div>
                        

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords</label>
                            <input type="text" placeholder="keywords" id="keyword" name="keyword" class="form-control">
                        </div>

                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Name<span class="req">*</span></label>
                                <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location</label>
                                <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Website</label>
                            <input type="text" placeholder="Website" id="website" name="website" class="form-control">
                        </div>
                    </div> 
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-danger">Save Job</button>
                    </div>               
                </div>
            </form>

                               
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script>
    $("#createJobForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled', true);
    $.ajax({
        url: '{{ route("account.saveJob") }}',
        type: 'post',
        dataType: 'json',
        data: $("#createJobForm").serializeArray(),
        success: function(response){
            $("button[type='submit']").prop('disabled', false);
            if(response.status == true){
                $(".is-invalid").removeClass('is-invalid');
                $(".invalid-feedback").removeClass('invalid-feedback').html('');
                window.location.href = '{{ route("account.myJobs") }}';
                
            } else {
                var errors = response.errors;
                $(".is-invalid").removeClass('is-invalid');
                $(".invalid-feedback").removeClass('invalid-feedback').html('');
                
                if(errors.title){
                    $("#title").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.title);
                }

                if(errors.category){
                    $("#category").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.category);
                }

                if(errors.jobType){
                    $("#jobType").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.jobType);
                }

                if(errors.vacancy){
                    $("#vacancy").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.vacancy);
                }

                if(errors.location){
                    $("#location").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.location);
                }

                if(errors.description){
                    $("#description").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.description);
                }

                if(errors.company_name){
                    $("#company_name").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.company_name);
                }
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
});
    </script>
@endsection