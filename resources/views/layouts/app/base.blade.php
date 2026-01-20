<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Portal Penerimaan Santri Baru, Ruhul Islam Anak Bangsa" />
	<meta name="keywords" content="PSB, Ruhul Islam, Anak Bangsa, Aceh Besar, Aceh, Penerimaan Santri Baru" />
	<meta name="author" content="Rencong Network Solutions" />

	<title>@yield('title', '') - {{ config('app.name') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet">

	<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

	<link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet">
	@stack('styles')

</head>

<body>
	<div class='loader'>
		<div class='spinner-grow text-primary' role='status'>
			<span class='sr-only'>Loading...</span>
		</div>
	</div>

	<div class="page-container">
		@include('layouts.app.header')
		@include('layouts.app.sidebar')
		<div class="page-content">
			<div class="main-wrapper">
				@yield('content')
			</div>
		</div>

	</div>

	<script src="{{ asset('assets/plugins/jquery/jquery-3.4.1.min.js') }}"></script>
	<script src="https://unpkg.com/@popperjs/core@2"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/blockui/jquery.blockUI.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ asset('assets/js/main.min.js') }}"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>
	@if (\Session::has('status'))
	<script>
		showSwal('{{ Session::get('status') }}', '{{ Session::get('message') }}');
	</script>
	@endif
	@stack('scripts')
</body>

</html>