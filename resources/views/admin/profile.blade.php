@extends('admin.layout.main')
@section('title', 'Admin Profile')
@section('page-title', 'Admin Profile')

@section('content')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .profile-grid {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }
    .profile-sidebar {
        flex: 1;
        min-width: 250px;
    }
    .profile-main {
        flex: 2;
        min-width: 300px;
    }
    .card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 20px;
        padding: 20px;
    }
    .card-header {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 10px;
        font-weight: bold;
        font-size: 18px;
    }
    .avatar-section {
        text-align: center;
        margin-bottom: 20px;
    }
    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #007bff;
    }
    .avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        margin: 0 auto;
        border: 3px solid #007bff;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    button:hover {
        background-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #545b62;
    }
    .alert {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    .info-item {
        margin-bottom: 15px;
    }
    .info-label {
        color: #666;
        font-size: 12px;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 500;
    }
    .badge {
        display: inline-block;
        padding: 3px 8px;
        background-color: #28a745;
        color: white;
        border-radius: 3px;
        font-size: 12px;
    }
    hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #eee;
    }
</style>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
     @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-grid">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="card">
                <div class="avatar-section">
                    @if($admin->avatar)
                        <img src="{{ asset('storage/'.$admin->avatar) }}" 
                             class="avatar" 
                             alt="Profile Picture">
                    @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <div style="text-align: center;">
                    <h3 style="margin: 10px 0 5px;">{{ $admin->name }}</h3>
                    <p style="color: #666; margin: 0 0 10px;">{{ $admin->email }}</p>
                    <span class="badge">Active</span>
                </div>
                
                <hr>
                
                <div class="info-item">
                    <div class="info-label">Member Since</div>
                    <div class="info-value">{{ $admin->created_at->format('F d, Y') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ $admin->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="profile-main">
            <!-- Update Profile Form -->
            <div class="card">
                <div class="card-header">Update Profile Information</div>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $admin->name) }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $admin->email) }}" 
                               required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="avatar">Profile Picture</label>
                        <input type="file" 
                               id="avatar" 
                               name="avatar" 
                               accept="image/*">
                        <small style="color: #666; display: block; margin-top: 5px;">
                            Allowed: JPG, PNG, JPEG. Max: 2MB
                        </small>
                    </div> -->

                    <button type="submit">Update Profile</button>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="card">
                <div class="card-header">Change Password</div>
                
                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" 
                               id="new_password" 
                               name="new_password" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" 
                               id="new_password_confirmation" 
                               name="new_password_confirmation" 
                               required>
                    </div>

                    <button type="submit" class="btn-secondary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection