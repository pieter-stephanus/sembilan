<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }} </title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <style>
    body {
      font-family: 'Nunito';
    }

  </style>
</head>

<body class="bg-light">
  {{-- <div class="container-fluid fixed-top p-4">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    @if (Route::has('login'))
                        <div class="">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-muted">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-muted">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-muted">Register</a>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div> --}}

  <div class="container-fluid my-4">
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-10">
        <div class="w-50 pb-3">
          <x-jet-application-logo style="width: 317px;" />
        </div>
        <div class="card shadow-sm">
          <div class="row g-0">
            <div class="col-md-6 pr-0">
              <div class="card-body border-right border-bottom p-3 h-100">
                <div class="d-flex flex-row bd-highlight mb-3">
                  <div>
                    <i class="fas fa-university"></i>
                  </div>
                  <div class="pl-3">
                    <div class="mb-2">
                      <span class="h5 font-weight-bolder text-dark">Masuk dengan akun Anda</span>
                    </div>
                    <p class="text-muted">
                      Situs ini dapat diakses menggunakan akun Gmail dalam Domain sttar.ac.id
                    </p>
                    @if (Route::has('login'))
                      <div class="d-flex align-content-center">
                        @auth
                          <a href="{{ url('/dashboard') }}" class="btn btn-primary mt-1">
                            <i class="fas fa-university"></i>
                            Kembali ke Beranda PDI
                          </a>
                        @else
                          <a href="{{ route('solo.auth', ['provider' => 'google']) }}"
                            class="btn btn-primary mt-1 mx-auto">
                            <i class="fab fa-google"></i>
                            {{ __('adminlte::adminlte.sign_in_with_google') }}
                          </a>

                          {{-- <a href="{{ route('login') }}" class="btn btn-warning  mt-1 mx-auto">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ __('adminlte::adminlte.sign_in') }}
                          </a> --}}

                          @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-success  mt-1 mx-auto">
                              <i class="fas fa-user-plus"></i>
                              {{ __('adminlte::adminlte.register') }}
                            </a>
                          @endif
                      @endif
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 pl-0">
              <div class="card-body border-bottom p-3 h-100">
                <div class="d-flex flex-row bd-highlight mb-3">
                  <div>
                    <i class="fas fa-users"></i>
                  </div>
                  <div class="pl-3">
                    <div class="mb-2">
                      <span class="h5 font-weight-bolder text-dark">Cara Akses</span>
                    </div>
                    <div class="text-muted">
                      <b>Untuk Mahasiswa</b>
                      <p>Silahkan masuk dengan alamat surat elektronik: NIM@student.sttar.ac.id</p>
                      <b>Untuk Pegawai</b>
                      <p>
                        Silahkan masuk dengan alamat surat elektronik: akun@staff.sttar.ac.id; akun@sttar.ac.id; dan/atau akun gmail
                        lain yang telah terdaftar.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 pr-0">
              <div class="card-body border-right p-3 h-100">
                <div class="d-flex flex-row bd-highlight mb-3">
                  <div>
                    <i class="fas fa-street-view"></i>
                  </div>
                  <div class="pl-3">
                    <div class="mb-2">
                      <span class="h5 font-weight-bolder text-dark">Akses Pihak Lain</span>
                    </div>
                    <p class="text-muted">
                      Silahkan login menggunakan akun Gmail atau Google Workspace yang telah didaftarkan bersama kami
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 pl-0">
              <div class="card-body p-3 h-100">
                <div class="d-flex flex-row bd-highlight mb-3">
                  <div>
                    <i class="fas fa-coffee"></i>
                  </div>
                  <div class="pl-3">
                    <div class="mb-2">
                      <span class="h5 font-weight-bolder text-dark">Permasalahan Akses Masuk</span>
                    </div>
                    <p class="text-muted">
                      Mohon menghubungi staf TIK jika terdapat permasalahan login
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
          <div class="text-sm text-muted">
            <div class="flex align-content-center">
              <a target="_blank" href="https://sttar.ac.id" class="text-muted mr-2">
                <i class="far fa-star"></i>
                STTAR
              </a>

              <a target="_blank" href="https://pdu.sttar.ac.id" class="text-muted">
                <i class="fas fa-jedi"></i>
                PDU
              </a>
            </div>
          </div>

          <div class="text-sm text-muted">
            <i class="far fa-copyright"></i> 2021 PDI
            {{-- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) --}}
          </div>
        </div>
      </div>
    </div>
    </div>
  </body>

  </html>
