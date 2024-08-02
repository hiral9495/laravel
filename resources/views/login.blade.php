@extends('login11')

@section('content')

@if($message = Session::get('success'))

<div class="alert alert-info">
{{ $message }}
</div>

@endif

<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header"  style="text-align:center">LOGIN</div>
			
			<div class="card-body">
				<form action="{{ route('sample.validate_login') }}" method="post">
					@csrf
					<div class="form-group mb-3">
						<input type="text" name="email" class="form-control" placeholder="Email" />
						@if($errors->has('email'))
							<span class="text-danger">{{ $errors->first('email') }}</span>
						@endif
					</div>
					<div class="form-group mb-3">
						<input type="password" name="password" class="form-control" placeholder="Password" value="{{session('password')}}"/>
						@if($errors->has('password'))
							<span class="text-danger">{{ $errors->first('password') }}</span>
						@endif
					</div>
					<div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
        <label class="form-check-label" for="form2Example31"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div>
					<div class="d-grid mx-auto">
						<button type="subit" class="btn btn-primary btn-block mb-4">Login</button>
					</div>
					<div class="text-center">
    <p>Not a member? <a href="{{ route('registration') }}">Register</a></p>
  </div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection('content')