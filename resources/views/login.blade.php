<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BengkelExpert | Login</title>
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
</head>
    <main>
        <div class="container">

          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="card mb-3 p-5 shadow border">
                    <div class="d-flex justify-content-center py-2">
                        <a href="{{ route('login') }}" class="logo d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/media/logos/logopolos_v2.png') }}" alt="Logo" style="width: 50%; height: auto;">
                        </a>
                    </div><!-- End Logo -->
                    <div class="card-body ">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Bengkel Expert</h5>
                            <p class="text-center small">Masukkan email dan password anda</p>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form class="row g-3 needs-validation" method="POST" action="{{route('login')}}">
                            @csrf
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="email" class="form-control" id="email" required>
                                    <div class="invalid-feedback">Masukkan email anda.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                                <div class="invalid-feedback">Masukkan password anda!</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-danger w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>


                </div>
              </div>
            </div>

          </section>

        </div>
      </main><!-- End #main -->

      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

      <!-- Vendor JS Files -->
      {{-- <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/chart.js/chart.umd.js"></script>
      <script src="assets/vendor/echarts/echarts.min.js"></script>
      <script src="assets/vendor/quill/quill.js"></script>
      <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
      <script src="assets/vendor/tinymce/tinymce.min.js"></script>
      <script src="assets/vendor/php-email-form/validate.js"></script>

      <!-- Template Main JS File -->
      <script src="assets/js/main.js"></script>
      <!-- Sweetalert -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

      @if($message = Session::get('failed'))
          <script>
            Swal.fire('{{ $message }}');
          </script>
      @endif
</body>
</html>
