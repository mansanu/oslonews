@extends('admin')
@section('content')
<link href="{{ asset('/css/bootstrap-chosen.css') }}" rel="stylesheet">
<script src="{{ asset('/js/chosen.jquery.js') }}"></script>
<script>
  $(function() {
	$('.chosen-select').chosen();
  });
</script>
<div id="page-wrapper">
 <div class="container-fluid">

	<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            News 
                        </h1>
                        <ol class="breadcrumb">
                           
                            <li class="active">
                                <i class="fa fa-file"></i> News
                            </li>
                        </ol>
                    </div>
                </div>
    <!-- /.row -->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					News Detail
				</div>


                <div class="panel-body">
        
					  @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
				
				 <form role="form" method="POST" action="{{ url('/news/store') }}" class="form-horizontal" enctype="multipart/form-data">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}">

				
				<div class="form-group">
					<label class="col-sm-2 control-label">Hub</label>
					<div class="col-sm-10">	 
						{!! Form::select('hub_id[]',$hubs , Input::old('hub_id[]'), ['multiple'=>'multiple','data-placeholder'=>'Please Select Hub','class'=>'chosen-select form-control']) !!}
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Country</label>
					<div class="col-sm-10">	 
						{!! Form::select('country_id[]',$countries , Input::old('country_id[]'), ['multiple'=>'multiple','data-placeholder'=>'Please Select Category','class'=>'chosen-select form-control']) !!}
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">News Category</label>
					<div class="col-sm-10">	 
						{!! Form::select('category_id[]',$categories , Input::old('category_id[]'), ['multiple'=>'multiple','data-placeholder'=>'Please Select Category','class'=>'chosen-select form-control']) !!}
					</div>
				</div>
				
				
				

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-default">Add</button>
				</div>
			  </div>

			</form>
         
		 
				</div>
			</div>
		 </div>
     </div>

	 <!-- /.row -->
	
  </div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->	

@endsection