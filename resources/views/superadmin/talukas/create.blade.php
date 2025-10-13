@extends('layouts.app')

@section('content')
<h2>{{ isset($taluka) ? 'Edit' : 'Create' }} Taluka</h2>

<form action="{{ isset($taluka) ? route('talukas.update', $taluka->id) : route('talukas.store') }}" method="POST">
    @csrf
    @if(isset($taluka)) @method('PUT') @endif

    <label>Taluka Name:</label>
    <input type="text" name="taluka_name" value="{{ $taluka->taluka_name ?? old('taluka_name') }}" required>

    <label>District:</label>
    <select name="district_id" required>
        @foreach($districts as $district)
            <option value="{{ $district->id }}" {{ (isset($taluka) && $taluka->district_id == $district->id) ? 'selected' : '' }}>
                {{ $district->district_name }}
            </option>
        @endforeach
    </select>

    <button type="submit">{{ isset($taluka) ? 'Update' : 'Create' }}</button>
</form>
@endsection
