@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('content')
    <div class="title m-b-md">
        <h1>@yield('code')</h1>
        <p>@yield('message')</p>
        <button onclick="window.location.reload();" class="btn btn-primary">Refresh</button>
    </div>
@endsection
