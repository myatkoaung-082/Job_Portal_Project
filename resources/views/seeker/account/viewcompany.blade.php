@extends('seeker.layouts.master')

@section('title')
    Companies
@endsection

@section('content')
    

        <div class="container mb-5 min-vh-100">
            {{-- search company start --}}
            <form action="{{ route('seeker#searchCompany')}}" method="get">
                @csrf
                <div class="row my-3">
                    <div class=" col-lg-4">
                        <div class="input-form">
                            <i class="fa-solid fa-industry text-primary fs-6"></i>
                            <select name="industry" class="input" id="industry">
                                @if ($industry)
                                    <option value="">Choose Industry</option>
                                    @foreach ($industry as $i)
                                        <option value="{{ $i->id }}" @if (request('industry') == $i->id) selected @endif>
                                            {{ $i->industry_name }}</option>
                                    @endforeach
                                @else
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class=" col-lg-4">
                        <div class="input-form">
                            <i class="fa-solid fa-building text-primary fs-6"></i>
                            <input type="text" name="searchKey" class="input" placeholder="Enter Company Name"
                                value="{{ request('searchKey') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <button type="submit"
                            class="btn btn-primary text-light input-form w-100 d-flex align-items-center justify-content-center"><i class="fa-solid fa-magnifying-glass me-2"></i>SEARCH</button>
                    </div>
                </div>
            </form>
            {{-- search company end --}}
            <div class="row my-5">
                @if (count($data) != null)
                @foreach ($data as $d)
                    <div class="col-4 my-4 wow animate__fadeIn">
                        <div class="company-card position-relative overflow-visible border border-1 rounded p-3 shadow-sm">
                            <div class="row ">
                                <div class="col-4">
                                    <span class="company-logo w-100 ">
                                        @if ($d->logo)
                                            <img src="{{ asset('storage/company/' . $d->logo) }}" class="rounded shadow-sm"
                                                alt="" style="width: 100px; height:100px; object-fit:cover;">
                                        @else
                                            <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                                class="rounded shadow-sm" alt="" style="width: 100px; height:100px; object-fit:cover;">
                                        @endif
                                    </span>
                                    <small>Opening Jobs: <strong>{{$d->total_job}}</strong></small>
                                </div>
                                <div class="col-8 py-2">
                                    <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                        style="height: 100%;">
                                        <a href="" class="text-decoration-none ">
                                            <h5 class="company-name text-primary">
                                                {{ $d->name }}
                                            </h5>
                                        </a>
                                        <span class="my-1 fs-13 "><i class="bi bi-geo-alt me-2"></i>{{ $d->township_name }},
                                            {{ $d->state_name }}</span>
                                        <span class="lh-sm mb-2 fs-13"><i
                                                class="bi bi-list-check me-2"></i>{{ $d->address }}</span>
    
    
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute more-info d-flex justify-content-center w-100" style="left: 0;">
                                <a href="@if ($userIndustry)
                                            {{ route('seeker#companydetail',[$d->user_id, $userIndustry]) }}
                                        @else
                                            {{ route('seeker#companydetail1',$d->user_id) }}
                                        @endif"
                                    class="btn btn-primary text-white rounded-4">
                                    More info <i class="bi bi-arrow-right-circle"></i>
                                </a>
                            </div>
    
                        </div>
                    </div>
                @endforeach
                @else
                <div class="row">
                    <div
                        class="col-lg-10 offset-1 d-flex justify-content-center align-items-center bg-primary text-light">
                        <h5 class="py-2">There is no company for your searching!</h5 class="py-2">
                    </div>
                </div>
                @endif
                
                <div class="mt-5">{{ $data->appends(request()->query())->links() }}</div>
    
    
    
            </div>
    
    
    
    
        </div>
    
@endsection

@section('scriptcode')

<script>
     $(document).ready(function() {
    
        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    })
</script>
    
@endsection
