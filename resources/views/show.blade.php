@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Show File</h1>
		<p>Current File Name: {{ $file->name }}</p>
		<p>Current File Path: {{ $file->path }}</p>

		<form action="{{ route('files.update', ['id' => $file->id]) }}" method="POST">
			@method('PUT')
			@csrf
			<div class="form-group">
				<label for="name">New File Name:</label>
				<input type="text" name="name" id="name" value="{{ old('name') ?? $file->name }}" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">Update File Name</button>
		</form>

		<p class="mt-3"><a href="{{ route('files.index') }}" class="btn btn-secondary">Back to File List</a></p>
	</div>
@endsection