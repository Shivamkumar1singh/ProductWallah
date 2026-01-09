@extends('layouts.admin.master')

@section('content')


<div class="pb-1">
<!-- profile header start -->
        <div class="user-profile card user-card mb-4">
          <div class="card-header border-0 p-0 pb-0">
            <div class="cover-img-block">
              <img src="{{ $admin->cover_image ? asset('storage/'.$admin->cover_image) : asset('admin/assets/images/cover.jpg') }}" class="img-fluid w-100" alt="Cover Image">
              <div class="overlay"></div>
              <div class="change-cover">
                {{-- CHANGE COVER --}}
                <form action="{{ route('admin.profile.cover') }}" method="POST" enctype="multipart/form-data" class="change-cover">
                    @csrf
            
                    <label class="dropdown">
                        <a class="arrow-none dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="icon ph ph-camera"></i>
                        </a>
            
                        <div class="dropdown-menu">
                            <label class="dropdown-item mb-0 cursor-pointer">
                                <i class="ph ph-cloud-arrow-up me-2"></i>
                                Upload new
                                <input
                                    type="file"
                                    name="cover_image"
                                    hidden
                                    onchange="this.form.submit()"
                                >
                            </label>
            
                            @if($admin->cover_image)
                            <a
                                href="{{ route('admin.profile.cover.remove') }}"
                                class="dropdown-item text-danger"
                            >
                                <i class="ph ph-trash me-2"></i> Remove
                            </a>
                            @endif
                        </div>
                    </label>
                </form>
              </div>
            </div>
          </div>
          <div class="card-body py-0">
            <div class="user-about-block m-0">
              <div class="row">
                <div class="col-md-4 text-center mt-n5">
                  {{-- PROFILE IMAGE --}}
                    <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="change-profile d-inline-block cursor-pointer">
                            <div class="profile-dp">
                                <img class="rounded-circle img-fluid wid-100"
                                     src="{{ $admin->profile_image
                                        ? asset('storage/'.$admin->profile_image)
                                        : asset('admin/assets/images/avatar-1.svg') }}">
                                <input type="file" name="profile_image" hidden onchange="this.form.submit()">
                                <div class="overlay"><span>change</span></div>
                            </div>
                        </label>
                    </form>
                  <h5 class="mb-1">{{ $admin->name }}</h5>
                  <p class="mb-2 text-muted">Admin</p>
                </div>
                <div class="col-md-8 mt-md-4">
                  <div class="row">
                    <div class="col-md-6">
                      <a class="mb-1 text-muted d-flex align-items-end text-h-primary"
                        ><i class="ph ph-globe me-2 f-18"></i>{{ $admin->email }}</a
                      >
                      <div class="clearfix"></div>
                      <a class="mb-1 text-muted d-flex align-items-end text-h-primary"
                        ><i class="ph ph-phone me-2 f-18"></i>{{ $admin->phone ?? 'N/A' }}</a
                      >
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="d-flex">
                        <div class="flex-shrink-0">
                          <i class="ph ph-map-pin f-18"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <p class="mb-0 text-muted">4289 Calvin Street</p>
                          <p class="mb-0 text-muted">Baltimore, near MD Tower Maryland,</p>
                          <p class="mb-0 text-muted">Maryland (21201)</p>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- profile header end -->
<!-- profile body start -->    
        <div>
            <div class="card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Personal details</h5>
                <button
                  type="button"
                  class="btn btn-primary btn-sm rounded m-0 float-end"
                  data-bs-toggle="collapse"
                  data-bs-target=".pro-det-edit"
                  aria-expanded="false"
                  aria-controls="pro-det-edit-1 pro-det-edit-2"
                >
                  <i class="ph ph-note-pencil align-middle"></i>
                </button>
              </div>
              <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Full Name</label>
                    <div class="col-sm-9"> {{ $admin->name }} </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Gender</label>
                    <div class="col-sm-9"> {{ ucfirst($admin->gender ?? '-') }} </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Birth Date</label>
                    <div class="col-sm-9"> {{ $admin->dob ? \Carbon\Carbon::parse($admin->dob)->format('d-m-Y') : '' }} </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Marital Status</label>
                    <div class="col-sm-9"> {{ ucfirst($admin->marital_status ?? '-') }} </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Location</label>
                    <div class="col-sm-9">
                      <p class="mb-0 text-muted">{{ $admin->address ?? '-' }}</p>
                    </div>
                  </div>
              </div>
              <div class="card-body border-top pro-det-edit collapse" id="pro-det-edit-2">
                <form method="POST" action="{{route('admin.profile.personal')}}">
                  @csrf
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Full Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name= "name" placeholder="Full Name" value="{{ $admin->name }}" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Gender</label>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="gender"
                          value="male"
                          {{ $admin->gender === 'male' ? 'checked' : '' }}
                        />
                        <label class="form-check-label" for="gender"> Male </label>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="gender"
                          value="female" {{ $admin->gender === 'female' ? 'checked' : '' }}
                        />
                        <label class="form-check-label" for="gender"> Female </label>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Birth Date</label>
                    <div class="col-sm-9">
                      <input type="date" name="dob" class="form-control" value="{{ $admin->dob ? \Carbon\Carbon::parse($admin->dob)->format('Y-m-d') : '' }}" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Marital Status</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="exampleFormControlSelect1" name="marital_status">
                        <option value="">Select Marital Status</option>
                        <option value="married" {{ $admin->marital_status === 'married' ? 'selected' : '' }} > Married</option>
                        <option value="unmarried" {{ $admin->marital_status === 'unmarried' ? 'selected' : '' }}>Unmarried</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Location</label>
                    <div class="col-sm-9">
                      <textarea name ="address" class="form-control">{{ $admin->address }}</textarea>
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Contact Information</h5>
                <button
                  type="button"
                  class="btn btn-primary btn-sm rounded m-0 float-end"
                  data-bs-toggle="collapse"
                  data-bs-target=".pro-dont-edit"
                  aria-expanded="false"
                  aria-controls="pro-dont-edit-1 pro-dont-edit-2"
                >
                  <i class="ph ph-note-pencil align-middle"></i>
                </button>
              </div>
              <div class="card-body border-top pro-dont-edit collapse show" id="pro-dont-edit-1">
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Mobile Number</label>
                    <div class="col-sm-9"> {{ $admin->phone ?? '-' }} </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Email Address</label>
                    <div class="col-sm-9"> {{ $admin->email }} </div>
                  </div>
              </div>
              <div class="card-body border-top pro-dont-edit collapse" id="pro-dont-edit-2">
                <form method="POST" action="{{ route('admin.profile.contact')}}">
                  @csrf
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Mobile Number</label>
                    <div class="col-sm-9">
                      <input type="text" name="phone" class="form-control" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" placeholder="Enter 10-digit mobile number" value="{{ $admin->phone }}" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Email Address</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $admin->email }}" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="mb-4"></div>
            <!-- <div class="card">
              <div class="card-body d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Other Information</h5>
                <button
                  type="button"
                  class="btn btn-primary btn-sm rounded m-0 float-end"
                  data-bs-toggle="collapse"
                  data-bs-target=".pro-wrk-edit"
                  aria-expanded="false"
                  aria-controls="pro-wrk-edit-1 pro-wrk-edit-2"
                >
                  <i class="ph ph-note-pencil align-middle"></i>
                </button>
              </div>
              <div class="card-body border-top pro-wrk-edit collapse show" id="pro-wrk-edit-1">
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Occupation</label>
                    <div class="col-sm-9"> Designer </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Skills</label>
                    <div class="col-sm-9"> C#, Javascript, Scss </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Jobs</label>
                    <div class="col-sm-9"> DashboardPack </div>
                  </div>
              </div>
              <div class="card-body border-top pro-wrk-edit collapse" id="pro-wrk-edit-2">
                <form>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Occupation</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Full Name" value="Designer" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Email Address</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Ema" value="Demo@domain.com" />
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label font-weight-bolder">Jobs</label>
                    <div class="col-sm-9">
                      <div class="form-check form-inline">
                        <input class="form-check-input" type="checkbox" id="pro-wrk-chk-1" />
                        <label class="form-check-label" for="pro-wrk-chk-1"> C# </label>
                      </div>
                      <div class="form-check form-inline">
                        <input class="form-check-input" type="checkbox" id="pro-wrk-chk-2" />
                        <label class="form-check-label" for="pro-wrk-chk-2"> Javascript </label>
                      </div>
                      <div class="form-check form-inline">
                        <input class="form-check-input" type="checkbox" id="pro-wrk-chk-3" />
                        <label class="form-check-label" for="pro-wrk-chk-3"> Scss </label>
                      </div>
                      <div class="form-check form-inline">
                        <input class="form-check-input" type="checkbox" id="pro-wrk-chk-3" />
                        <label class="form-check-label" for="pro-wrk-chk-3"> Html </label>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div> -->
          </div>
        </div>
<!-- profile body end -->
</div>
@endsection
