@extends('layouts.landing.base')

@section('title', 'Home')

@section('content')=
<div class="row justify-content-center">
	<div class="col-md-8 text-center">
		<h1>Welcome to PSB Ruhul Islam Anak Bangsa</h1>
		<p class="lead">Portal Penerimaan Santri Baru</p>
		<a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3">Login to Continue</a>
	</div>
</div>
@endsection