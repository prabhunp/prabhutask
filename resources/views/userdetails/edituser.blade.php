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
								<form class="row"  method="POST" action="{{ route('userdetailsedit') }}" id="editprofile" enctype="multipart/form-data">
									<input type="hidden" name="userid" value="{{$userdetails->id}}">
								 	{{ csrf_field() }}
								 	<div class="col-md-8">
										<div class="form-group">
											<label class="control-label">First name</label>
											<input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name" autofocus value="{{$userdetails->first_name}}">
											@if ($errors->has('first_name'))
												<div class="error">{{ $errors->first('first_name') }}</div>
											@endif
										</div>
										<div class="form-group">
											  <label class="control-label">Last Name</label>
											  <input class="form-control" type="text" placeholder="Enter your last name" id="last_name" name="last_name" value="{{$userdetails->last_name}}" autofocus>
											  @if ($errors->has('last_name'))
												<div class="error">{{ $errors->first('last_name') }}</div>
											 @endif
										</div>
										<div class="row col-md-12">
											<div class="col-md-6 form-group">
												<label class="control-label">Birthday</label>
												<input class="form-control" type="date" placeholder="Enter your birthday" required id="birthday" name="birthday" value="{{$userdetails->birthday}}">
											</div>
											<div class="col-md-6 form-group">
												<label class="control-label">Country</label>
												<select name="country" id="country" autofocus class="form-control">
												  	@foreach ($countries as $country) 
													<option @if($userdetails->country == $country->countryID) selected="selected" @endif  value="{{ $country->countryID }}">{{ $country->name }}</option>									
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
												<input class="form-control" type="text" placeholder="Enter your height" required id="height" name="height" value="{{$userdetails->height}}">
											</div>
											<div class="col-md-6 form-group">
											  	<label class="control-label">Weight</label>
												<input class="form-control" type="text" placeholder="Enter your weight" id="weight" name="weight" required value="{{$userdetails->weight}}">
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">profile Image</label>											
											<input type="hidden" name="file_name" value="{{ $userdetails->profile_image }}"/>
											<div class="img-responsive" style="padding: 10px;">
												<img src="{{	url('storage/userimage/'.$userdetails->profile_image)	}}" width="150px" height="150px" alt="{{ $userdetails->profile_image }}" title="{{ $userdetails->profile_image }}"/>
											</div>
											@if ($userdetails->profile_image)
												<input type="button" class="file_value"  name="file_type" value="keep"/>
												<input type="button" class="file_value"  name="file_type"  value="discard"/>
												<input type="button" class="file_value" name="file_type"  value="replace"/>
											@endif
											@if ($userdetails->profile_image)
												<input type="hidden" name="file_source_type" id="file_source_type" value="keep">
											@else
												<input type="hidden" name="file_source_type" id="file_source_type" value="replace">
											@endif

											<input  type="file" id="profile_image" name="profile_image" value="" style="margin-top: 10px;">

										</div>
									</div>						
									
									<hr>
									<div class="form-group col-md-12">
										<h3 class="tile-title">Current Team</h3>
									</div>
									<hr>
									<div class="form-group col-md-4">
										  <label class="control-label">Name</label>
										  <select name="team_name" id="team_name"  class="form-control">
										  		<option @if($userdetails->team_name == 'bigballers') selected="selected" @endif value="bigballers">Big Ballers</option>
										  		<option @if($userdetails->team_name == 'swish') selected="selected" @endif value="swish">SWISH</option>
										  		<option @if($userdetails->team_name == 'hoosters') selected="selected" @endif value="hoosters">Hoopsters</option>
										  		<option @if($userdetails->team_name == 'alley') selected="selected" @endif value="alley">Alley-oopers</option>	
										  		<option @if($userdetails->team_name == 'notavialable') selected="selected" @endif value="notavialable">N/A</option>										
							 		 	  </select>

										  <!-- <input class="form-control" type="text" placeholder="Enter your team_name" id="team_name" name="team_name" value="{{$userdetails->team_name}}"> -->
									</div>	
									<div class="form-group col-md-4">
										  <label class="control-label">Position</label>
										  <select name="position" id="position"  class="form-control">
										  		<option @if($userdetails->position == 'centre') selected="selected" @endif value="centre">Centre</option>
										  		<option @if($userdetails->position == 'powerforward') selected="selected" @endif value="powerforward">Power Forward</option>
										  		<option @if($userdetails->position == 'smallforward') selected="selected" @endif value="smallforward">Small Forward</option>
										  		<option @if($userdetails->position == 'shootingguard') selected="selected" @endif value="shootingguard">Shooting Guard</option>	
										  		<option @if($userdetails->position == 'pointguard') selected="selected" @endif value="pointguard">Point Guard</option>										
							 		 	  </select>
									</div>	
									<div class="form-group col-md-4">
										  <label class="control-label">Member</label>
										  <input class="form-control" type="text" placeholder="Enter your member" id="member" name="member" value="{{$userdetails->member}}">
									</div>
									<hr>																						
									<div class="form-group col-md-12">
										<h3 class="tile-title">Misc</h3>
									</div>
									<hr>
									<div class="form-group col-md-4">
										<label class="control-label">College</label>
										<select name="college" id="college"  class="form-control">
										  		<option @if($userdetails->college == 'ece') selected="selected" @endif value="ece">ECE</option>
										  		<option @if($userdetails->college == 'eee') selected="selected" @endif value="eee">EEE</option>
										  		<option @if($userdetails->college == 'it') selected="selected" @endif value="it">IT</option>
										  		<option @if($userdetails->college == 'cse') selected="selected" @endif value="cse">CSE</option>	
										  		<option @if($userdetails->college == 'na') selected="selected" @endif value="na">N/A<option>										
							 		 	  </select>
										 <!-- <input class="form-control" type="text" placeholder="Enter your college" id="college" name="college" value="{{$userdetails->college}}"> -->
									</div>
									<div class="form-group col-md-4">
										<label class="control-label">NBADebut</label>
										 <input class="form-control" type="text" placeholder="Enter your debut" id="debut" name="debut" value="{{$userdetails->debut}}" autofocus>
									</div>
								
									<div class="form-group col-md-12 align-self-end">
									 	<button class="btn btn-primary" id="editprofile" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
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
	<script type="text/javascript">		
		$(function() {
			$('.file_value').on('click', function(){

				$('#file_source_type').val($(this).val());
				if($(this).val() == 'keep'){
					$("#profile_image").prop('required',false);
				}else if($(this).val() == 'replace'){
					$("#profile_image").prop('required',true);
				}else{
					$("#profile_image").prop('required',false);
				}
			    $(this).addClass('btn btn-primary');			    
			});
			$("#editprofile").validate({
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