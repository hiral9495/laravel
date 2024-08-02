@extends('login11')

@section('content')

<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card">
		<div class="card-header" style="text-align:center">REGISTRATION</div>
		<div class="card-body">
			<form action="{{ route('sample.validate_registration') }}" method="POST">
				@csrf
				<div class="form-group mb-3">
					<input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
					@if($errors->has('name'))
						<span class="text-danger">{{ $errors->first('name') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
					<input type="text" name="email" class="form-control" placeholder="Email Address" value="{{old('email')}}" >
					@if($errors->has('email'))
						<span class="text-danger">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password" value="{{ session('password') }}">
					@if($errors->has('password'))
						<span class="text-danger">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="form-group mb-3">
					<input type="password" name="confirmPassword" class="form-control" placeholder="confirm Password" value="{{old('confirmPassword')}}">
					@if($errors->has('confirmPassword'))
						<span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
					@endif
				</div>
				<div class="d-grid mx-auto">
					<button type="submit" class="btn btn-primary btn-block mb-4">Register</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection('content')