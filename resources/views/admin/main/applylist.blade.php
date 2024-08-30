@extends('admin.layouts.main')

@section('title')
    Apply List
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
                <p class="title-1"><i class="fa-solid fa-database"></i> All ApplyLists - {{ count($data) }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3 d-flex align-items-center">
                <span class="text-light bg-dark my-3 p-2 rounded rounded-1 me-2">Search Key -
                    @if (request('searchKey'))
                        {{ request('searchKey') }}
                    @else
                        No Data
                    @endif
                </span>
                <a href="{{ route('admin#applyList') }}"
                    class=" text-light bg-primary p-2 rounded rounded-1 text-decoration-none">Back</a>
            </div>
            <div class="my-3 col-3 offset-6">
                <form action="{{ route('admin#applyList') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <input type="text" name="searchKey" id="" class="form-control" placeholder="Name ... "
                            value = "{{ request('searchKey') }}">
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
                                    <th>Seeker Name</th>
                                    <th>Job Position</th>
                                    <th>Company</th>
                                    <th>Apply Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="tr-shadow">
                                        <td>{{ $item->name }}</td>
                                        <td class=" text-start">
                                            <span class="block-email col-6 ">{{ $item->professional_title_name }}</span>
                                        </td>
                                        <td class="text-start">
                                            @if($data1)
                                                @foreach ($data1 as $de)
                                                    @if($item->company_id == $de->id)
                                                        @php
                                                         $name = $de->name;
                                                        @endphp
                                                        {{$name}}
                                                    @endif
                                                @endforeach
                                            @else
                                                No Data
                                            @endif

                                        </td>
                                        <td>
                                            {{$item->apply_date}}
                                        </td>
                                        <td>
                                            @switch($item->status)
                                                @case(0)
                                                    <div class="text-light bg-primary">Pending</div>
                                                @break
                                                @case(1)
                                                    <div class="text-dark bg-info">Accept</div>
                                                @break
                                                @case(2)
                                                <div class="text-light bg-secondary">Reject</div>
                                                @break
                                                      
                                            @endswitch
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
                        apply list here</h3>
                @endif

            </div>
        </div>
    </div>
@endsection
