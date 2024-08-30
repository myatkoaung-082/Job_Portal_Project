@extends('admin.layouts.main')

@section('title')
    Category
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            {{-- alert message --}}
            @if(session('createSuccess'))
                <div class=" mb-3">
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <strong><i class="fa-check fa-solid"></i> {{ session('createSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('deleteSuccess'))
                <div class=" mb-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="fa-circle-xmark fa-solid"></i> {{ session('deleteSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('updateSuccess'))
                <div class=" mb-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="fa-solid fa-pen-to-square"></i> {{ session('updateSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <div class="row mb-3">
            <div class="col-6 text-start d-flex align-items-center">
                <p class="title-1"><i class="fa-solid fa-database"></i> All Categories -  {{ $data->total() }}</p>
            </div>
            <div class="col-6 text-end">
                <a href="{{ route('admin#categorycreatepage') }}">
                    <button class="btn btn-primary btn-sm p-2">
                        <i class="fa-solid fa-plus"></i>Add Category
                    </button>
                </a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3 d-flex align-items-center">
                <span class="text-light bg-dark my-3 p-2 rounded rounded-1 me-2">
                    Search Key - 
                    @if (request('searchKey'))
                        {{ request('searchKey') }}
                    @else
                        No Data
                    @endif
                </span>
                <a href="{{route('admin#categorylist')}}" class=" text-light bg-primary p-2 rounded rounded-1 text-decoration-none">Back</a>
            </div>
            <div class="my-3 col-3 offset-6">
                <form action="{{ route('admin#categorylist') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <input type="text" name="searchKey" id="" class="form-control me-2" placeholder="Search Category Name ... " value = "{{ request('searchKey') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-8 offset-2">

                @if(count($data) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category_name</th>
                                    <th>Created_at</th>
                                    <th>Functions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr class="tr-shadow">
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <span class="block-email col-6 text-start">{{$item->name}}</span>
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        <td class="">
                                            <div class="table-data-feature d-flex justify-content-center gap-2">
                                                <a href="{{route('admin#categoryeditpage',$item->id)}}">
                                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="my-3">
                            {{ $data->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <h3 class="text-secondary text-center mt-5"><i class="fa-solid fa-circle-exclamation"></i> There is no category here</h3>
                @endif

            </div>
        </div>
    </div>
@endsection