@extends('default')
@section('pageTitle', 'Edit Profile')
@section('pageAction')
<a href="/profile" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back to Profile
</a>
@endsection
@section('content')
  <!-- Edit Profile Content -->
  <div class="content">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- Profile Picture Section -->
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">Profile Picture</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="profile-avatar mb-3">
                            <img width="100" src="{{ asset('' . (Auth::user()->profile_photo ?? 'user-avatar.jpg')) }}" alt="Profile" class="rounded-circle" id="profileImage">
                            <button type="button" class="btn btn-sm btn-primary avatar-edit" onclick="document.getElementById('imageUpload').click()">
                                <i class="fas fa-camera"></i>
                            </button>
                            <input type="file" name="profile_photo" id="imageUpload" accept="image/*" style="display: none;">
                        </div>
                        <p class="text-muted">Upload a new profile picture. JPG or PNG only.</p>
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', Auth::user()->first_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', Auth::user()->last_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" name="company" class="form-control" value="{{ old('company', Auth::user()->company) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" name="job_title" class="form-control" value="{{ old('job_title', Auth::user()->job_title) }}">
                            </div>
                            <div class="col-12">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', Auth::user()->location) }}">
                            </div>
                            <div class="col-12">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea name="bio" rows="4" class="form-control">{{ old('bio', Auth::user()->bio) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
      </form>
  </div>
@endsection