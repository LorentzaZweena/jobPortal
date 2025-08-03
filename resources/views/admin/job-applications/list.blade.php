@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-danger">Home</a></li>
                        <li class="breadcrumb-item active">Job applications</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Job applications</h3>
                            </div>
                            <div style="margin-top: -10px;">
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Job title</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Employer</th>
                                        <th scope="col">Applied date</th>
                                        {{-- <th scope="col">Status</th> --}}
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $application->id }}</td>
                                                <td>{{ $application->job->title }}</td>
                                                <td>{{ $application->user->name}}</td>
                                                <td>{{ $application->employer->name}}</td>
                                                <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M Y') }}</td>
                                                {{-- <td>
                                                    @if($job->status == 1)
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif($job->status == 0)
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @else
                                                        <span class="badge bg-warning">Closed</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <div class="action-dots">
                                                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" onclick="deleteJobApplication({{ $application->id }})" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No job applications found.</td>
                                        </tr>
                                    @endif
                                </tbody>         
                            </table>
                        </div>
                        <div>
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function deleteJobApplication(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.jobApplications.destroy") }}',
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response){
                        if(response.status){
                            Swal.fire({
                                title: 'Deleted',
                                text: 'Job application deleted successfully.',
                                icon: 'info',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Job application could not be deleted.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }
</script>
@endsection


