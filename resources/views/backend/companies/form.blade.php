@extends('backend/layout')
@section('content')
<section class="content-header">
    <h1>Companies</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $company->page_title }}</li>
    </ol>
</section>

<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $company->page_title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{-- Name --}}
                    {{ Form::open(array('route' => $company->form_action, 'method' => 'POST', 'files' => true, 'id' => 'company-form')) }}
                    {{ Form::hidden('id', $company->id, array('id' => 'company_id')) }}
                    <div id="form-name" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Name</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('name', $company->name, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Email --}}
                    <div id="form-email" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Email</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('email', $company->email, array('placeholder' => '', 'class' => 'form-control validate[required, email, multiEmail,maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Postcode --}}
                    <div id="form-postcode" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Postcode</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-2 col-content">
                            {{ Form::text('postcode', $company->postcode, array('placeholder' => '', 'class' => 'form-control validate[required, zip]',  'id' => 'postcode', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                        <div id="get_address" class="form-group no-border">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="button" id="get_addr" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>

                    {{-- Prefecture --}}
                    <div id="form-prefecture" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Prefecture</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::select('prefecture_id', App\Models\Prefecture::selectlist(), old('prefecture_id', $company->prefecture_id), ['class' => 'form-control validate[required, maxSize[100]]', "selected" => old('prefecture_id', $company->prefecture_id) ? "selected" : "", 'id' => 'prefecture', 'data-prompt-position' => 'bottomLeft:0,11']) }}
                        </div>
                    </div>

                    {{-- City --}}
                    <div id="form-city" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">City</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('city', $company->city, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'id' => 'city', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Local --}}
                    <div id="form-local" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Local</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('local', $company->local, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'id' => 'local', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>
                    

                    {{-- Street Address --}}
                    <div id="form-street-address" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Street Address</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('street_address', $company->street_address, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Business Hour --}}
                    <div id="form-business-hour" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Business Hour</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('business_hour', $company->business_hour, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Regular Holiday --}}
                    <div id="form-regular-holiday" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Regular Holiday</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('regular_holiday', $company->regular_holiday, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div id="form-phone" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Phone</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('phone', $company->phone, array('placeholder' => '', 'class' => 'form-control validate[phone, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Fax --}}
                    <div id="form-fax" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Fax</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('fax', $company->fax, array('placeholder' => '', 'class' => 'form-control validate[fax, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- URL --}}
                    <div id="form-url" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">URL</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('url', $company->url, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- License Number --}}
                    <div id="form-license-number" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">License Number</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('license_number', $company->license_number, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{-- Image --}}
                    @if($company->page_type == 'create')
                    <div id="form-image" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Image</strong>
                        </div>
                        <div class="image-preview-area">
                            {{ Form::hidden('MAX_FILE_SIZE', '5242880') }}
                            {{ Form::file('image', array('placeholder' => '', 'class' => 'validate[required, checkFileType]', 'data-prompt-position' => 'bottomLeft:0,14')) }}
                            <label class="image-upload-label">画像をアップロードして下さい（推奨サイズ：1280px × 720px・容量は5MBまで）</label>
                            <div class="image-preview">
                                <img id="preview" src="https://www.shoshinsha-design.com/wp-content/uploads/2020/05/noimage-1024x898.png">
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="form-image" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Image</strong>
                        </div>
                        <div class="image-preview-area">
                            {{ Form::hidden('MAX_FILE_SIZE', '5242880') }}
                            {{ Form::file('image', array('accept' => 'image/*', 'placeholder' => '', 'class' => 'validate[checkFileType]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            <label class="image-upload-label">画像をアップロードして下さい（推奨サイズ：1280px × 720px・容量は5MBまで）</label>
                            <div class="image-preview">
                                <img id="preview" src="{{ Storage::url($company->image) }}">
                            </div>
                        </div>
                    </div>
                    @endif

                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                            <button type="submit" name="submit" id="send" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('title', 'Company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
<!-- validationEngine -->
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<script src="{{ asset('js/backend/companies/form.js') }}"></script>
@endsection
