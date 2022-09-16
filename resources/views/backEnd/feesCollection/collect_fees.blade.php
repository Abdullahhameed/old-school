@extends('backEnd.master')
@section('title') 
@lang('fees.collect_fees')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees.collect_fees')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees_collection')</a>
                <a href="#">@lang('fees.collect_fees')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'collect_fees', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="col-lg-3 mt-30-md infix_up_mt">
                                    <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') " value="">@lang('common.select_class') </option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}"  {{( old("class") == $class->id ? "selected":"")}}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-30-md infix_up_mt" id="select_section_div">
                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('current_section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('common.select_section')" value="">@lang('common.select_section')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-30-md infix_up_mt">
                                    <div class="input-effect">
                                        <input class="primary-input form-control" type="text" name="keyword">
                                        <label>@lang('fees.search_by_name'), @lang('student.admission'), @lang('student.roll'), @lang('student.national_id'), @lang('student.local_id_number')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                                                

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('common.search')
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            
        @if(isset($students))
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data'])}}
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('fees.fees_collection_list') (@lang('common.class'): {{$search_info['class_name']}}, @lang('common.section'): {{@$search_info['section_name']}}, @lang('fees.keyword'): {{@$search_info['keyword']}})</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                   
                                    <tr>
                                        <th>@lang('common.class')</th>
                                        <th>@lang('common.section')</th>
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('student.father_name')</th>
                                        <th>@lang('common.date_of_birth')</th>
                                        <th>@lang('common.phone')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->class->class_name}}</td>
                                        <td>{{$student->section->section_name}}</td>
                                        <td>{{$student->admission_no}}</td>
                                        <td>{{$student->first_name.' '.$student->last_name}}</td>
                                        <td>{{$student->parents != ""? $student->parents->fathers_name:""}}</td>
                                        <td  data-sort="{{strtotime($student->date_of_birth)}}" >
                                           
                                            {{$student->date_of_birth != ""? dateConvert($student->date_of_birth):''}}

                                        </td>
                                        <td>{{$student->mobile}}</td>

                                        @if(userPermission(110))

                                        <td>
                                            <a href="{{route('fees_collect_student_wise', [$student->id])}}" class="primary-btn small tr-bg">
                                                @lang('fees.collect_fees')
                                            </a>
                                        </td>

                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

@endif

    </div>
</section>


@endsection
