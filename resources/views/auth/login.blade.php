<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 right-box">
                <div class="logo d-flex align-items-center">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500 rounded-circle" />
                    </a>
                    <span class="ml-6 text-lg fw-bolder fs-4" style="text-shadow: 2px 2px 4px #99ff62;">Laptop Cafe
                        Jogjakarta</span>
                </div>
                <div class="d-flex mb-4 tab-buttons">
                    <button class="tablink btn w-50 active" onclick="openTab(event, 'Login')"
                        id="loginTab">{{ __('Login') }}</button>
                    <button class="tablink btn w-50" onclick="openTab(event, 'Register')"
                        id="registerTab">{{ __('Register') }}</button>
                </div>
                <div id="Login" class="tabcontent show">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3 flex-column">
                            <x-text-input id="phone" class="form-control form-control-lg bg-light fs-6"
                                type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone"
                                placeholder="Phone Number" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="input-group mb-1 flex-column">
                            <x-text-input id="password" class="form-control form-control-lg bg-light fs-6 mb-3"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="Password" />
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <x-primary-button
                                class="btn btn-lg btn-primary w-100 fs-6">{{ __('Log in') }}</x-primary-button>
                        </div>
                    </form>
                </div>
                <div id="Register" class="tabcontent">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group mb-3 flex-column">
                            <x-text-input id="name" class="form-control form-control-lg bg-light fs-6"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                placeholder="Name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="input-group mb-3 flex-column">
                            <x-text-input id="phone" class="form-control form-control-lg bg-light fs-6"
                                type="text" name="phone" :value="old('phone')" required autocomplete="phone"
                                placeholder="Phone Number" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="input-group mb-3 flex-column">
                            <x-text-input id="password" class="form-control form-control-lg bg-light fs-6"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="input-group mb-3 flex-column">
                            <x-text-input id="password_confirmation" class="form-control form-control-lg bg-light fs-6"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm Password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="input-group" style="padding-top: 30px;">
                            <x-primary-button
                                class="btn btn-lg btn-primary w-100 fs-6">{{ __('Register') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: url('{{ asset('images/login-bg.png') }}') no-repeat center center; background-size: cover;">
                <!-- Content inside the left box is removed as it will be covered by the background image -->
            </div>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("show");
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("show");
            evt.currentTarget.classList.add("active");
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Check for any errors in the session
            const hasErrors = {{ $errors->any() ? 'true' : 'false' }};

            // Check specific errors related to the login form
            const loginErrors = {{ $errors->has('phone') || $errors->has('password') ? 'true' : 'false' }};

            // Check specific errors related to the register form
            const registerErrors = {{ $errors->has('name') || $errors->has('phone') || $errors->has('password') || $errors->has('password_confirmation') ? 'true' : 'false' }};

            if (hasErrors) {
                if (loginErrors) {
                    document.getElementById("loginTab").click();
                } else if (registerErrors) {
                    document.getElementById("registerTab").click();
                }
            } else {
                // Activate the login tab by default
                document.getElementById("loginTab").click();
            }
        });
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            background: #ececec;
        }

        .box-area {
            width: 930px;
        }

        .logo {
            margin-top: -40px;
            padding-bottom: 40px;
        }

        .right-box {
            padding: 40px 30px 40px 40px;
        }

        ::placeholder {
            font-size: 16px;
        }

        .rounded-4 {
            border-radius: 20px;
        }

        .rounded-5 {
            border-radius: 30px;
        }

        .tablink {
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: color 0.3s, border-bottom 0.3s;
            font-size: 17px;
            flex: 1;
            text-align: center;
            position: relative;
            color: #000;
        }

        .tablink::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #067D40;
            transition: width 0.3s, left 0.3s;
        }

        .tablink.active::before {
            width: 100%;
            left: 0;
        }

        .tablink.active {
            color: #067D40;
        }

        .tabcontent {
            display: none;
            padding: 6px 12px;
            border-top: none;
            border: none;
            outline: none;
            transition: opacity 0.3s, height 0.3s;
            opacity: 0;
            height: 0;
        }

        .tabcontent.show {
            display: block;
            opacity: 1;
            height: auto;
        }

        .d-flex {
            display: flex;
        }

        .form-control {
            width: 100%;
        }

        border-radius-text-input {
            border-radius: 50px;
        }

        .btn-primary {
            background-color: #067D40;
            border-color: #067D40;
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: #109E36;
            border-color: #109E36;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group .form-control {
            width: 100%;
        }
    </style>
</x-guest-layout>
