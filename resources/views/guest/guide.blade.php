@extends('guest.layouts.main')

@section('title')
    Guide
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <embed src="{{ asset('image/guidebook(Final).pdf') }}" type="application/pdf" width="100%"
            height="800px">
        </div>
    </div>
@endsection