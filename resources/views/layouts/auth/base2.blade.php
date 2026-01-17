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
            <div class="d-flex flex-column flex-center flex-column-fluid">
                @yield('content')
			</div>
		</div>
		<script>var hostUrl = "{{ asset('assets/') }}";</script>
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
	</body>
</html>