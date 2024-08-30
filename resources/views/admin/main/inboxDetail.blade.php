@extends('admin.layouts.main')

@section('title')
    Inbox Details
@endsection

@section('content')
    <div class="container-fluid">
        @if(count($data) != 0)
            @foreach ($data as $d)
                <div class="form w-50 mx-auto p-5 shadow-md">
                    <div class="mb-2 text-center">
                        <h3>Contact Details</h3>
                    </div>
                    <div class="mb-2">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="" class="form-control" value="{{$d->name}}" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="" class="form-control" value="{{$d->email}}" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="date">Post Created</label>
                        <input type="text" name="" class="form-control" id="" value="{{$d->created_at}}" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="message">Message</label>
                        <textarea name="message" id="" cols="30" rows="5" class="form-control" disabled>{{$d->message}}</textarea>
                    </div>
                    <div class="mb-2 text-center">
                        <a href="{{route('admin#inbox')}}" class="btn btn-sm btn-primary p-2">Back</a>
                    </div>
                </div>
            @endforeach
        @else
        @endif
    </div>
@endsection