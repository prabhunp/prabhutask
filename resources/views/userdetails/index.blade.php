@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">        
        <div class="col-md-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button> 
                    <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('danger'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button> 
                    <strong>{{ $message }}</strong>
            </div>
        @endif
          <div class="tile">
            <div class="tile-body">
            <div class="bs-component tablebutton">

             <input type="hidden" value="{{ route('userdetailsedit') }}" id="custom_hidden_edit_url"/>
             <input type="hidden" value="{{ route('userdetailsdelete') }}" id="custom_hidden_delete_url"/>
             
             <div class="pull-right">
                <a href="{{route('userdetailscreate')}}" class="btn btn-primary">Add New </a>
            </div>
            </div>
              <table class="table table-borded table-striped " id="users-table">
                <thead>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Country</th>
                    <th>Debut</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>        
    </div>
</div>
@endsection

@section('javascript')
    @parent
    
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/user.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endsection
