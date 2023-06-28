<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
@section('title', 'Login')
<!-- BEGIN: Head-->
@include('partials._head')
<!-- END: Head-->
<!-- BEGIN: Body-->

<body>
  
    <div class="dashboard-landing">
        <div class="left-side">
            
            <img src="{{ asset('app-assets/images/loginpage.svg') }}" alt="" class="img-fluid">
            
        </div>
        <div class="right-side">
            <div class="login-fields">
                <!-- Login v1 -->
                <div>
                    
                    <div class="card-body">
                    <div style="display: flex; justify-content: center;">
                        <img src="{{ asset('images/logo/logo.png') }}" class="logo" alt="kenMeat" />
                    </div>

                                                
                            <br><br><br>
                        
                            <h4 class="mb-1 card-title"> Forgot your Password? 🔒 </h4>
                        <p class="mb-2 card-text"> Enter Email to associated with your account</p>

                        @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                        </span>
                        @endif
                        <form class="mt-2 auth-login-form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-1">
                                <label for="login-email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="login-email" name="email"
                                    placeholder="john@example.com" aria-describedby="login-email" tabindex="1"
                                    autofocus />
                           
                            </div>
                      
                       
                            <button type="submit" class="btn w-100" tabindex="4" style="background: linear-gradient(to right, darkred, lightcoral); color: white;"> Send Reset Link </button>
                        </form>
                           <p class="text-right mt-2" style="text-align: right;">
                              <a href="{{ route('logout') }}">
                                 <i data-feather="chevron-left"></i> Back to login
                              </a>
                           </p>

                    </div>
                </div>
                <!-- /Login v1 -->
            </div>
        </div>
    </div>


    @include('partials._javascripts')
</body>
<!-- END: Body-->

</html>
