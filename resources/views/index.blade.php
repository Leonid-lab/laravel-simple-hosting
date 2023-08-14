@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Your Files</h1>

		<ul class="list-group">
			@foreach($files as $file)
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a>
					<div>
						<a href="{{ route('files.download', $file->id) }}" class="btn btn-sm btn-success">Download</a>
						<form action="{{ route('files.delete', $file->id) }}" method="post" class="ml-3">
							@method('DELETE')
							@csrf
							<button type="submit" class="btn btn-sm btn-danger">Delete</button>
						</form>
					</div>
				</li>
			@endforeach
		</ul>

		<div class="mt-3">
			{{ $files->links('pagination::bootstrap-4') }}
		</div>
	</div>

	<div class="container mt-4">
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
