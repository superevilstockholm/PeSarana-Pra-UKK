@extends('layouts.base')
@section('title', 'Daftar - PeSarana')
@section('meta-description', 'Halaman SignUp website PeSarana untuk user.')
@section('meta-keywords', 'auth, signup, PeSarana, sekolah')
@section('content')
<section class="vh-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-md-7 col-lg-5 col-xxl-4 py-4">
                <div class="card border-0 bg-transparent">
                    <div class="card-header p-0 m-0 border-0 bg-transparent d-flex aling-items-center justify-content-center p-0 m-0">
                        <img class="p-0 m-0 object-fit-cover" style="width: 180px; height: 140px;" src="{{ asset('static/img/logo-pesarana-1-transparent.svg') }}" alt="Logo PeSarana">
                    </div>
                    <div class="card-body border-0 p-0 m-0">
                        <h1 class="text-center fs-3 text-center fw-semibold mb-0">
                            Selamat Datang👋
                        </h1>
                        <p class="text-center text-secondary fw-semibold">
                            Mendaftar ke PeSarana sebagai siswa untum mengakses dashboard kamu.
                        </p>
                        <form class="p-0 m-0 w-100 h-100" action="{{ route('signup') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input name="nisn" type="text" class="form-control" id="floatingInputNISN" placeholder="NISN" value="{{ old('nisn') }}" inputmode="numeric" maxlength="10" required>
                                <label for="floatingInputNISN">NISN</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" name="dob" class="form-control" id="floatingInputDOB" value="{{ old('dob') }}" required>
                                <label for="floatingInputDOB">Tanggal Lahir</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="Email" value="{{ old('email') }}" required>
                                <label for="floatingInputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control" id="floatingInputPassword" placeholder="Password" required>
                                <label for="floatingInputPassword">Password</label>
                            </div>
                            <x-alerts :errors="$errors"></x-alerts>
                            <button class="btn btn-primary w-100 mb-2" type="submit">Daftar</button>
                            <p>Sudah memiliki akun? <a class="text-primary" href="{{ route('login') }}">Masuk Disini</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
