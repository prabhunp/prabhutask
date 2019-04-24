@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Details</div>

                <div class="card-body">
					<div class="col-md-12">
						<div class="tile">
							<div class="tile-body">
								<form class="row form-horizontal"  method="POST" action="{{ route('userdetailscreate') }}" id="usersprofile" enctype="multipart/form-data">
								 	{{ csrf_field() }}
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label">First name *</label>
										<input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name"  autofocus value="">
										@if ($errors->has('first_name'))
											<div class="error">{{ $errors->first('first_name') }}</div>
										@endif
									</div>
									<div class="form-group">
										  <label class="control-label">Last Name *</label>
										  <input class="form-control" type="text" placeholder="Enter your last name" id="last_name" name="last_name" value=""  autofocus>
										  @if ($errors->has('last_name'))
											<div class="error">{{ $errors->first('last_name') }}</div>
										 @endif
									</div>	
									<div class="row col-md-12">
										<div class="col-md-6 form-group">
											<label class="control-label">Birthday</label>
											<input class="form-control" type="date" placeholder="Enter your birthday"  id="birthday" name="birthday" value="">
										</div>
										<div class="col-md-6 form-group">
											<label class="control-label">Country *</label>
											<select name="country" id="country"  class="form-control" autofocus>
												 <option value="">Select Option</option>
											@foreach ($countries as $country) 
												 <option value="{{ $country->countryID }}">{{ $country->name }}</option>  
											@endforeach	
										 	</select>
										 	 @if ($errors->has('country'))
												<div class="error">{{ $errors->first('country') }}</div>
											@endif										
										</div>	
									</div>																							
									<div class="row col-md-12">
										<div class="col-md-6 form-group">
											<label class="control-label">Height</label>
											<input class="form-control" type="text" placeholder="Enter your height"  id="height" name="height" value="">
										</div>
										<div class="col-md-6 form-group">
										  	<label class="control-label">Weight</label>
											<input class="form-control" type="text" placeholder="Enter your weight" id="weight" name="weight"  value="">
										</div>
									</div>	
								</div>								
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">profile Image</label>
											<input  type="file" id="profile_image" name="profile_image" value="" >
										</div>
									</div>	
									<hr>
									<div class="form-group col-md-12">
										<h3 class="tile-title">Current Team</h3>
									</div>
									<hr>
									<div class="form-group col-md-4">
										  <label class="control-label">Name</label>
										  <select name="team_name" id="team_name" required class="form-control">
										  		<option value="bigballers">Big Ballers</option>
										  		<option value="swish">SWISH</option>
										  		<option value="hoosters">Hoopsters</option>
										  		<option value="alley">Alley-oopers</option>	
										  		<option value="notavialable">N/A</option>										
							 		 	  </select>										
									</div>	
									<div class="form-group col-md-4">
										  <label class="control-label">Position</label>
										  <select name="position" id="position" required class="form-control">
										  		<option value="centre">Centre</option>
										  		<option value="powerforward">Power Forward</option>
										  		<option value="smallforward">Small Forward</option>
										  		<option value="shootingguard">Shooting Guard</option>	
										  		<option value="pointguard">Point Guard</option>										
							 		 	  </select>
									</div>	
									<div class="form-group col-md-4">
										  <label class="control-label">Member</label>
										  <input class="form-control" type="text" placeholder="Enter your member" id="member" name="member" value="">
									</div>
									<hr>																						
									<div class="form-group col-md-12">
										<h3 class="tile-title">Misc</h3>
									</div>
									<hr>
									<div class="form-group col-md-4">
										<label class="control-label">College</label>
										<select name="college" id="college" required class="form-control">
										  		<option value="ece">ECE</option>
										  		<option value="eee">EEE</option>
										  		<option value="it">IT</option>
										  		<option value="cse">CSE</option>	
										  		<option value="na">N/A<option>										
							 		 	  </select>										
									</div>
									<div class="form-group col-md-4">
										<label class="control-label">NBADebut *</label>
										 <input class="form-control" type="text" placeholder="Enter your debut" id="debut" name="debut" value="" autofocus>
										 @if ($errors->has('debut'))
											<div class="error">{{ $errors->first('debut') }}</div>
										@endif
									</div>
									<div class="col-md-12">
										<p>* - Required field</p>
									</div>
									<div class="form-group col-md-12 align-self-end">
								 		<button class="btn btn-primary" id="usersprofile" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
								 		<button class="btn btn-info" type="reset"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cancel</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
@endsection
@section('javascript')
    @parent
	<script src="{{ asset('js/jquery.validate.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
  	<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/user.js') }}"></script>
	<script type="text/javascript">$('#sampleTable').DataTable();</script>
	
	<script type="text/javascript">
		
		$(document).ready(function() {
			$("#usersprofile").validate({
				ignore: ":hidden",
				rules: {
				 first_name: {
					 required: true
				 },
				 last_name: {
					 required: true
				 },
				 country: {
					 required: true
				 },
				 debut: {
					 required: true
				 },
				 
				},
				submitHandler: function () {
					return true;
				}
			});
		});	 
	</script>

@endsection