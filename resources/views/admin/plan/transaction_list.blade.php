@extends('admin.layouts.main')

@section('title')
    Transaction List
@endsection

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{route('admin#empdatalist')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-user-tie me-1 " style="width:20px;"></i> <small>Companies</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin#employeelist')}}" class=" text-decoration-none d-flex align-items-center fs-6">
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
                            <a href="{{route('admin#transactionList')}}" class=" text-decoration-none d-flex align-items-center fs-6">
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
            <div class="col-md-12">
                <div class="row mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span class="text-light bg-dark my-3 p-2 rounded rounded-1 me-2">Search Key -
                            @if (request('searchKey'))
                                {{ request('searchKey') }}
                            @else
                                No Data
                            @endif
                        </span>
                        <a href="{{ route('admin#transactionList') }}"
                            class=" text-light bg-primary p-2 rounded rounded-1 text-decoration-none">Back</a>
                    </div>
                    <div class="my-3 col-3 offset-6">
                        <form action="{{ route('admin#transactionList') }}" method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="searchKey" id="" class="form-control" placeholder="Order Code ... "
                                    value = "{{ request('searchKey') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive table-responsive-data2" >
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Plan Name</th>
                                <th>Company Name</th>
                                <th>Order Code</th>
                                <th>Purchased Date</th>
                                <th>Status Level</th>
                            </tr>
                        </thead>
                        <tbody id="mylist">
                            @foreach($data as $d)
                                <tr class="tr-shadow ">
                                    <input type="hidden" name="purchase_id" value="{{$d->id}}" class="purchase_id">
                                    <input type="hidden" name="company_id" value="{{$d->company_id}}" class="company_id">
                                    <td>{{ $d->plan_name}}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>
                                        <a href="{{ route('admin#adminTransactionDetails', $d->id)}}">
                                            {{ $d->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $d->created_at->format('d-m-Y') }}</td>
                                    <td class="">
                                        <select name="status" class="form-control changebtn w-50 mx-auto">
                                            <option value="0" class="bg-primary text-white p-1" @if ($d->status_level == 0)
                                                selected
                                            @endif>Pending</option>
                                            <option value="1" class="bg-info text-white p-1" @if ($d->status_level == 1)
                                                selected
                                            @endif>Accept</option>
                                            <option value="2" class="bg-danger text-white p-1" @if ($d->status_level == 2)
                                                selected
                                            @endif>Reject</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->appends(request()->query())->links() }}
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptcode')
    <script>
        $(document).ready(function(){
            $('.changebtn').change(function(){
                $current = $(this).val();
                $target = $(this).parents("tr");
                $purchase_id = $target.find(".purchase_id").val()*1;
                $target2 = $(this).parents("tr");
                $company_id = $target2.find(".company_id").val()*1;
                console.log($purchase_id);
                console.log($current);
                console.log($company_id);
                $.ajax({
                    type: 'get',
                    url: '/ajax/statusdata',
                    dataType: 'json',
                    data: {
                        'status':$current,
                        'purchase_id':$purchase_id,
                        'company_id':$company_id
                    }
                })
            })

})
    </script>
@endsection