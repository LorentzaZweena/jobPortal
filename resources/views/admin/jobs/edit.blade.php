@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-danger">Home</a></li>
                        <li class="breadcrumb-item active">Edit job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 mt-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                    <div class="card-body card-form">
                        <form method="POST" id="editJobForm" name="editJobForm" action="{{ route('admin.jobs.update', $job->id) }}">
                        @csrf
                        @method('PUT')
                    <div class="card border-0 shadow">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Edit job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input value="{{ $job->title }}" type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ ($job->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                            <option {{ ($job->job_type_id == $jobType->id) ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                        @endforeach           
                                    @endif
                                    </select>
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary</label>
                                    <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input value="{{ $job->location }}" type="text" placeholder="location" id="location" name="location" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <div class="form-check">
                                        <input {{ ($job->isFeatured == 1) ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" id="isFeatured" name="isFeatured">
                                        <label class="form-check-label" for="isfeatured">
                                            Featured
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <div class="form-check-inline">
                                        <input {{ ($job->status == 1) ? 'checked' : '' }} class="form-check-input" type="radio" value="1" id="status-active" name="status">
                                        <label class="form-check-label" for="status">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input {{ ($job->status == 0) ? 'checked' : '' }} class="form-check-input" type="radio" value="0" id="status-block" name="status">
                                        <label class="form-check-label" for="status">
                                            Inactive
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="textarea" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="textarea" name="benefit" id="benefit" cols="5" rows="5" placeholder="Benefits">{{ $job->benefit }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-select">
                                    <option value="0" {{ ($job->experience == 0) ? 'selected' : '' }}>0 year</option>
                                    <option value="1" {{ ($job->experience == 1) ? 'selected' : '' }}>1 year</option>
                                    <option value="2" {{ ($job->experience == 2) ? 'selected' : '' }}>2 year</option>
                                    <option value="3" {{ ($job->experience == 3) ? 'selected' : '' }}>3 year</option>
                                    <option value="4" {{ ($job->experience == 4) ? 'selected' : '' }}>4 year</option>
                                    <option value="5" {{ ($job->experience == 5) ? 'selected' : '' }}>5 year</option>
                                    <option value="6" {{ ($job->experience == 6) ? 'selected' : '' }}>6 year</option>
                                    <option value="7" {{ ($job->experience == 7) ? 'selected' : '' }}>7 year</option>
                                    <option value="8_plus" {{ ($job->experience == '8_plus') ? 'selected' : '' }}>8+ year</option>
                                </select>
                                <p></p>
                            </div>
                            

                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</label>
                                <input value="{{ $job->keyword }}" type="text" placeholder="keywords" id="keyword" name="keyword" class="form-control">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                    <p></p>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input value="{{ $job->company_location }}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input value="{{ $job->company_website }}" type="text" placeholder="Website" id="website" name="website" class="form-control">
                            </div>
                        </div> 
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-danger">Update Job</button>
                        </div>               
                    </div>
            </form>
                    </div>               
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script>
        $("#editJobForm").submit(function(e){
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route("admin.jobs.update", $job->id) }}',
            type: 'post',
            dataType: 'json',
            data: $("#editJobForm").serializeArray(),
            success: function(response){
                $("button[type='submit']").prop('disabled', false);
                if(response.status == true){
                    $(".is-invalid").removeClass('is-invalid');
                    $(".invalid-feedback").removeClass('invalid-feedback').html('');
                    window.location.href = '{{ route("admin.jobs") }}';
                    
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
        $("#userForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("admin.jobs.edit", $job->id) }}',
                type: 'POST',
                dataType: 'json',
                data: $("#userForm").serializeArray().concat({ name: '_method', value: 'PUT' }),
                success: function(response){
                    if(response.status == true){
                            $("#name").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html('');

                            $("#email").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html('');

                        window.location.href = "{{ route('admin.users.lists') }}";
                    }else{
                        var errors = response.errors;
                        if(errors.name){
                            $("#name").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.name);
                        } else {
                            $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                        }

                        if(errors.email){
                            $("#email").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.email);
                        } else {
                            $("#email").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                        }
                    }
                }
            })
        });
    </script>
@endsection

