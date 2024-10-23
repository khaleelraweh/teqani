@extends('layouts.admin')
@section('style')
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('frontend/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('frontend/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">


                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.add_new_document_template') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                {{-- <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button> --}}
                <a href="" class="btn btn-warning  btn-icon ml-2">
                    <i class="mdi mdi-refresh"></i>
                </a>
            </div>


        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row opened -->
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">
                            <i class="fa fa-plus-square me-3 " style="font-size: 20px;"></i>
                            {{ __('panel.add_new_document_template') }}
                        </h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.document_archives.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-3">
                                <label for="doc_archive_name"> {{ __('panel.document_archive_name') }} </label>
                                <input type="text" id="doc_archive_name" wire:model="doc_archive_name"
                                    name="doc_archive_name" value="{{ old('doc_archive_name') }}" class="form-control"
                                    placeholder="">
                                @error('doc_archive_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- row -->
                        <div class="row" wire:ignore>
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h6 class="card-title mb-1">ارفق مستند هنا </h6>
                                            <p class="text-muted card-sub-title">يجب ان يكون المستند ضمن الصيغ
                                                التالية ( .pdf ,
                                                .docx)</p>
                                        </div>

                                        <div>

                                            <input class="dropify" type="file" name="doc_archive_attached_file"
                                                accept=".pdf, .docx">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="row">
                            <div class="col-sm-12 ">
                                {{-- submit button  --}}
                                <div class="form-group pt-3">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        {{ __('panel.save_data') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- main-content closed -->
@endsection

@section('script')
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('frontend/assets/plugins/fileuploads/js/fileupload.js') }}"></script>w
    <script src="{{ URL::asset('frontend/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
@endsection
