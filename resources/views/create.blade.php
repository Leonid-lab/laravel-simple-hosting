@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Upload File</h1>

		<form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="file">Select File:</label>
				<input type="file" name="file" id="file" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">Upload</button>
		</form>
	</div>
@endsection
