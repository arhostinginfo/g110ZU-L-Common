@extends('layouts.app')

@section('content')
<h2>Talukas</h2>
<a href="{{ route('talukas.create') }}">Create New Taluka</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Taluka Name</th>
            <th>District</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($talukas as $taluka)
        <tr>
            <td>{{ $taluka->id }}</td>
            <td>{{ $taluka->taluka_name }}</td>
            <td>{{ $taluka->district->district_name }}</td>
            <td>
                <a href="{{ route('talukas.edit', $taluka->id) }}">Edit</a>
                <form action="{{ route('talukas.destroy', $taluka->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
