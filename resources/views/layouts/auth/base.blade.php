<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@yield('title', config('app.name'))</title>
        <meta charset="utf-8" />
		<meta name="description" content="Portal Penerimaan Santri Baru, Ruhul Islam Anak Bangsa" />
		<meta name="keywords" content="PSB, Ruhul Islam, Anak Bangsa, Aceh Besar, Aceh, Penerimaan Santri Baru" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
	</head>
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<script>
            var defaultThemeMode = "light";
            var themeMode;
            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else { 
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>
                body {
                    background-image: url('{{ asset('assets/media/auth/bg10.jpeg') }}'); 
                } 
                [data-bs-theme="dark"]
                body { 
                    background-image: url('{{ asset('assets/media/auth/bg10-dark.jpeg') }}');
                }
            </style>
			
            
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <div class="d-flex flex-lg-row-fluid">
                    <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                        <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('assets/media/auth/agency.png') }}" alt="" />
                        <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
                        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                        <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post, 
                            <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed 
                            <br />and provides some background information about 
                            <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their 
                            <br />work following this is a transcript of the interview.
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
		</div>
        
        <div class="modal fade" id="modalTos" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<div class="modal-content">
					<div class="modal-header pb-0 border-0 justify-content-end">
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body scroll-y mx-3 mx-xl-18 pt-0 pb-15">
						@include('components.tos')
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="modalPrivacyPolicy" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<div class="modal-content">
					<div class="modal-header pb-0 border-0 justify-content-end">
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<div class="modal-body scroll-y mx-3 mx-xl-18 pt-0 pb-15">
						@include('components.privacy-policy')
					</div>
				</div>
			</div>
		</div>
        
		<script>var hostUrl = "{{ asset('assets/') }}";</script>
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		@stack('scripts')
	</body>
</html>