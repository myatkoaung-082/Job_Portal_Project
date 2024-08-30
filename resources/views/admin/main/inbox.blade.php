@extends('admin.layouts.main')

@section('title')
    Inbox
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if(session('deleteSuccess'))
            <div class="">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa-key fa-solid"></i> {{ session('deleteSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
    <div class="all-jobs d-flex flex-column align-items-center justify-content-center mt-5">
        <ul class="nav nav-pills rounded border border-1 mb-3" id="pills-tab" role="tablist"
            style="width: 803px">
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark active" id="pills-active-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="true">Seekers</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="pills-expired-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-expired" type="button" role="tab" aria-controls="pills-expired"
                    aria-selected="false">Companies</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-active" role="tabpanel"
                aria-labelledby="pills-active-tab" tabindex="0">
                <table class="table">
                    
                    @if (count($sdata) != 0)
                        <thead class="border-bottom-1">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Posted Date</th>
                                <th scope="col">Message</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sdata as $s)
                                <tr class="tr-shadow">
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ $s->created_at }}</td>
                                    <td>{{ Str::limit($s->message,'20','...') }}</td>
                                    <td>
                                        <a href="{{route('admin#inboxView1',$s->sid)}}"
                                            class="btn btn-outline-info me-3" data-toggle="tooltip"
                                            data-placement="top" title="detail">

                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <a href="{{route('admin#inboxDelete',$s->sid)}}"
                                            class="btn btn-outline-danger" data-toggle="tooltip"
                                            data-placement="top" title="Delete">

                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> 
                    @else
                        <div class="p-2 m-2">
                            <div class="bg-secondary p-5 text-light text-center">
                                <i class="fa-solid fa-warning"></i> There is no contacts
                            </div>
                        </div>        
                    @endif
                </table>
            </div>
            <div class="tab-pane fade" id="pills-expired" role="tabpanel"
                aria-labelledby="pills-expired-tab" tabindex="0">
                <table class="table">
                    @if (count($cdata) != 0)
                        <thead class="border-bottom-1">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Posted Date</th>
                                <th scope="col">Message</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cdata as $c)
                                <tr class="tr-shadow">
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->email }}</td>
                                    <td>{{ $c->created_at }}</td>
                                    <td>{{ Str::limit($c->message,'20','...')}}</td>
                                    <td></td>
                                    <td>
                                        <a href="{{route('admin#inboxView',$c->cid)}}"
                                            class="btn btn-outline-info me-3" data-toggle="tooltip"
                                            data-placement="top" title="detail">

                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <a href="{{route('admin#inboxDelete',$c->cid)}}"
                                            class="btn btn-outline-danger" data-toggle="tooltip"
                                            data-placement="top" title="Delete">

                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <div class="p-2 m-2">
                            <div class="bg-secondary p-5 text-light text-center">
                                <i class="fa-solid fa-warning"></i> There is no contacts
                            </div>
                        </div>    
                    @endif
                </table>
            </div>

        </div>
    </div>
</div>
@endsection