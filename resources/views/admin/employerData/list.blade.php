@extends('admin.layouts.main')

@section('title')
    Employers
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('admin#empdatalist') }}"
                            class=" text-decoration-none d-flex align-items-center fs-6">
                            <i class="fa-solid fa-user-tie me-1 " style="width:20px;"></i> <small>Companies</small>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin#employeelist') }}" class=" text-decoration-none d-flex align-items-center fs-6">
                            <i class="fa-solid fa-users me-1 " style="width:20px;"></i> <small>Seekers</small>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin#applyList')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                            <i class="fa-solid fa-user-group me-1 " style="width:20px;"></i>
                            <small>ApplyList</small>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin#transactionList') }}"
                            class=" text-decoration-none d-flex align-items-center fs-6">
                            <i class="fa-solid fa-users-gear me-1 " style="width:20px;"></i>
                            <small>TransactionList</small>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin#chartData')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                            <i class="fa-solid fa-magnifying-glass-chart me-1" style="width:20px;"></i>
                            <small>Data Analysis</small>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            {{-- alert message --}}
            @if (session('deleteSuccess'))
                <div class=" mb-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="fa-circle-xmark fa-solid"></i> {{ session('deleteSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <div class="row mb-3">
            <div class="col text-end">
                <p class="title-1"><i class="fa-solid fa-database"></i> No of Companies - {{ count($emptotal) }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3 d-flex align-items-center">
                <span class="text-light bg-dark my-3 p-2 rounded rounded-1 me-2">Search Key -
                    @if($industryData)
                        {{ $industryData->industry_name }}
                    @else
                        No Data
                    @endif
                </span>
                <a href="{{ route('admin#empdatalist') }}"
                    class=" text-light bg-primary p-2 rounded rounded-1 text-decoration-none">Back</a>
            </div>
            <div class="my-3 col-3 offset-6">
                <form action="{{ route('admin#empdatalist') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <select name="industry" id="" class=" form-control">
                            @if($industry)
                                <option value="">Choose Industry</option>
                                @foreach ($industry as $id)
                                    <option value="{{$id->id}}">{{$id->industry_name}}</option>
                                @endforeach
                            @else
                                <option value="">Choose one...</option>
                            @endif
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-8 offset-2">

                @if (count($data) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Industry</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="tr-shadow">
                                        <td>{{ $item->id }}</td>
                                        <td class=" text-start">
                                            <span class="block-email col-6 ">{{ $item->name }}</span>
                                        </td>
                                        <td class="text-start">{{ $item->email }}</td>
                                        <td class="text-start">{{$item->industry_name}}</td>
                                        <td>
                                            @if ($item->company_phone)
                                                {{ $item->company_phone }}
                                            @else
                                                No Data
                                            @endif
                                        </td>
                                        <td class="">
                                            <div class="table-data-feature d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin#viewemp', $item->id) }}">
                                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                                        title="Details">
                                                        <i class="fa-solid fa-circle-info fs-5"></i>
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
                    <h3 class="text-secondary text-center mt-5"><i class="fa-solid fa-circle-exclamation"></i> There is no
                        employer here</h3>
                @endif

            </div>
        </div>
    </div>
@endsection
