@extends('seeker.layouts.master')

@section('title')
    Jobs
@endsection

@section('content')
    {{-- @dd($proTitle) --}}
    <div class="container">

        {{-- search section start --}}
        <form action="{{ route('seeker#serachJob') }}" method="get">
            @csrf
            <div class="row my-3">
                <div class=" col-lg-3">
                    <div class="input-form">
                        <i class="fa-solid fa-earth-asia text-primary fs-6"></i>
                        <select name="state" class="input" id="state">
                            @if ($state)
                                <option value="">Choose State/Region</option>
                                @foreach ($state as $s)
                                    <option value="{{ $s->id }}" @if (request('state') == $s->id) selected @endif>
                                        {{ $s->state_name }}</option>
                                @endforeach
                            @else
                            @endif
                        </select>
                    </div>
                </div>
                <div class=" col-lg-3">
                    <div class="input-form">
                        <i class="fa-solid fa-city text-primary fs-6"></i>
                        <select name="township" class="input" id="township">
                            @if ($townshipData)
                                <option value="">Choose Township</option>
                                @foreach ($townshipData as $t)
                                    <option value="{{ $t->township_id }}">{{ $t->township_name }}</option>
                                @endforeach
                            @else
                                <option value="">Choose Township</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class=" col-lg-3">
                    <div class="input-form">
                        <i class="fa-solid fa-keyboard text-primary fs-6"></i>
                        <input type="text" name="searchKey" class="input" placeholder="Enter Job Position"
                            value="{{ request('searchKey') }}">
                    </div>
                </div>

                <div class="col-lg-3">
                    <button type="submit"
                        class="btn btn-primary text-light input-form w-100 d-flex align-items-center justify-content-center"><i
                            class="fa-solid fa-magnifying-glass me-2"></i>SEARCH</button>
                </div>
            </div>
        </form>
        {{-- search section end --}}
        <hr>
        <div class="row justify-content-evenly ">
            {{-- filter section start --}}
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('seeker#filterJob') }}" method="get">
                            @csrf
                            <div class=" d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary text-light w-100 py-2"><i
                                        class="fa-solid fa-filter me-2"></i>FILTER BY</button>
                            </div>
                            <hr>

                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Category
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class=" list-unstyled">
                                                @foreach ($category as $c)
                                                    <li class=" d-flex justify-content-between">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="category"
                                                                id="flexRadioDefault1" value="{{ $c->id }}"
                                                                {{ old('category') == $c->id ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                {{ $c->name }}
                                                            </label>
                                                        </div>
                                                        <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center ms-1"
                                                            style="width: 20px; height:20px;">
                                                            <span class="text-light">{{ $c->total_job }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Work Type
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class=" list-unstyled">
                                                @foreach ($workType as $wt)
                                                    <li class="">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="workType"
                                                                id="flexRadioDefault1" value="{{ $wt->id }}">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                {{ $wt->work_type_name }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Experience Level
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class=" list-unstyled">
                                                @foreach ($expLevel as $el)
                                                    <li class="">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="expLevel" id="flexRadioDefault1"
                                                                value="{{ $el->id }}">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                {{ $el->experience_level_name }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            Salary Range
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class=" list-unstyled">
                                                @foreach ($salaryRange as $sr)
                                                    <li class="">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="salaryRange" id="flexRadioDefault1"
                                                                value="{{ $sr->id }}">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                {{ $sr->salary_range_name }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- filter section end --}}
            {{-- all jobs start --}}
            <div class="col-lg-9">
                @if (count($data) != 0)
                    @foreach($data as $d)
                        <a href="{{ route('seeker#detailJob', [$d->id, $d->company_id]) }}"
                            class="text-decoration-none text-dark ">

                            <div class="job-card shadow-sm  d-flex flex-column border border-1 rounded my-3 p-2 wow  animate__fadeInRight">
                                <div class="job-card-top row justify-content-between">
                                    <div class="col-10 py-2 ms-2" style="height: 70px">
                                        <div class="row">
                                            <div class="col-lg-1 me-4">
                                                @if ($d->logo)
                                                    <img src="{{ asset('storage/company/' . $d->logo) }}"
                                                        class="shadow-sm rounded" height="60" width="60"
                                                        alt="" style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        class="shadow-sm rounded" height="60" width="60"
                                                        alt="" style="object-fit: cover;">
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <h6 class="company-name fw-bold">{{ $d->name }}</h6>
                                                <span class="company-location text-muted fs-13"><i
                                                        class="fa-solid fa-location-dot me-2"></i>{{ $d->township_name }}
                                                    ,
                                                    {{ $d->state_name }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <h5 class="fw-bold my-1 p-0 ms-2">{{ $d->professional_title_name }}</h5>

                                <div class="text-muted fs-13 mb-1 ms-2">
                                    <span class="posted-time me-2"><i
                                            class="fa-solid fa-clock me-2"></i>{{ $d->created_at->diffForHumans() }}</span>
                                </div>


                                {{-- <p class="job-card-description w-80 mb-3 text-break ms-2">
                                    @php
                                        echo Str::words($d->job_description, 40, '...');
                                    @endphp
                                </p> --}}
                                <p class="job-card-description w-80  mb-3  text-break ms-2" >
                                    {{-- {!!$d->job_description!!} --}}
                                    {{-- {!!Str::words($d->job_description,20,'...')!!} --}}
                                    {{-- {{Str::limit($d->job_description,100)}} --}}
                                    @php
                                        // echo  Str::words($d->job_description, 40, '...');
                                        $text = strip_tags($d->job_description);
                                        echo Str::words($text, 40, '...');
                                    @endphp
                                </p>

                                <div class="card-bottom row justify-content-between mt-2 ms-2">
                                    <div class="col-6 p-0">
                                        <span>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            Deadline : <strong>{{ $d->apply_expire_date }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="row">
                        <div
                            class="col-lg-10 offset-1 d-flex justify-content-center align-items-center bg-primary text-light">
                            <h5 class="py-2">There is no job for your searching!</h5 class="py-2">
                        </div>
                    </div>
                @endif
                
            </div>
            {{ $data->appends(request()->query())->links() }}
            {{-- all jobs end --}}
        </div>
    </div>
@endsection

@section('scriptcode')
    <script>
        $(document).ready(function() {
            $('#state').change(function() {
                $current = $(this).val();
                // console.log($current);
                $.ajax({
                    type: 'get',
                    url: '/seeker/ajax/townshipData',
                    dataType: 'json',
                    data: {
                        'status': $current
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#township').html('');
                        $('#township').append('<option value=" ">Choose Township</option>');
                        $.each(response, function(index, item) {
                            $('#township').append('<option value="' + item
                                .township_id + '">' + item.township_name +
                                '</option>');
                        });
                    }
                })
            })
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
