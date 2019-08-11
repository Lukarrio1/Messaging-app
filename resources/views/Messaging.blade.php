@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       @include('components.active')
       @include('components.message')
    </div>
</div>
@endsection
