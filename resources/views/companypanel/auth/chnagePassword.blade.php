@extends('companypanel.auth.layout.app')
@section('title', 'Change Password    ')
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Reset Password</h4>
                        </div>
                        <div class="card-body">
                            @if(session()->has('error_message'))
                            <p class="text-danger">The password and confirmation password do not match</p>
                            @else
                                <p class="text-muted">Enter Your New Password</p>
                            @endif
                            <form method="POST" action="{{url('company-reset-password')}}">
                                 @csrf
                                <input value="{{$user->email}}" type="hidden" name="email" >
                                <div class="form-group position-relative">
                                        <label for="password">New Password</label>
                                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" tabindex="2" placeholder="Password">
                                        <span toggle="#password" class="fa fa-fw fa-eye toggle-password" style="position:absolute; top:38px; right:15px; cursor:pointer;"></span>
                                        @error('password') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div class="form-group position-relative">
                                        <label for="password-confirm">Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="confirmed" tabindex="2" placeholder="Password">
                                        <span toggle="#password-confirm" class="fa fa-fw fa-eye toggle-password" style="position:absolute; top:38px; right:15px; cursor:pointer;"></span>
                                        @error('confirmed') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');

        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                const input = document.querySelector(this.getAttribute('toggle'));
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>
