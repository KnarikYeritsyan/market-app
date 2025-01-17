@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.posts',app()->getLocale())}}">{{__('Posts')}}</a></li>
    </ol>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('admin/dist/css/summernote.css')}}"/>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>

                        <a href="{{route('admin.posts',app()->getLocale())}}" class="btn btn-xs btn-link"><h3><i class="fa fa-arrow-left"></i> {{__('Posts')}}</h3></a>
                    @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <h4 class="card-title mb-3">{{__('New Post')}}</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="exampleInputFile" class="col-sm-2 col-form-label">{{__('Image')}}</label>
                        <fieldset class="form-group">
                            <input type="file" class="form-control-file" name="image" id="exampleInputFile" accept="image/*">
                        </fieldset>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-sm-2 col-form-label">{{__('Slug')}}</label>
                            <div class="col-sm-10">
                                <input id="slug" name="slug" type="text" class="form-control" value="{{ $slug ?? old('slug') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">{{__('Status')}}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">{{__('Published')}}</option>
                                    <option value="0">{{__('Not Published')}}</option>
                                </select>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('Russian')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('English')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings-b2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-lg-block">{{__('Armenian')}}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home-b2">
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                    <div class="col-sm-10">
                                        <input id="title" name="title_ru" type="text" class="form-control" value="{{ $title_ru ?? old('title_ru') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_description" class="col-sm-2 col-form-label">{{__('Meta Description')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_description" name="meta_description_ru" type="text" class="form-control">{{ $meta_description_ru ?? old('meta_description_ru') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-2 col-form-label">{{__('Meta Keywords')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_keywords" name="meta_keywords_ru" type="text" class="form-control">{{ $meta_keywords_ru ?? old('meta_keywords_ru') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-sm-2 col-form-label">{{__('Content')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="content" name="content_ru" class="summernote">{{ $content_ru ?? old('content_ru') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show" id="profile-b2">
                                <div class="form-group row">
                                    <label for="title_en" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                    <div class="col-sm-10">
                                        <input id="title_en" name="title_en" type="text" class="form-control" value="{{ $title_en ?? old('title_en') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_description" class="col-sm-2 col-form-label">{{__('Meta Description')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_description" name="meta_description_en" type="text" class="form-control">{{ $meta_description_en ?? old('meta_description_en') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-2 col-form-label">{{__('Meta Keywords')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_keywords" name="meta_keywords_en" type="text" class="form-control">{{ $meta_keywords_en ?? old('meta_keywords_en') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-sm-2 col-form-label">{{__('Content')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="content" name="content_en" class="summernote">{{ $content_en ?? old('content_en') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="settings-b2">
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                    <div class="col-sm-10">
                                        <input id="title" name="title_am" type="text" class="form-control" value="{{ $title_am ?? old('title_am') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_description" class="col-sm-2 col-form-label">{{__('Meta Description')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_description" name="meta_description_am" type="text" class="form-control">{{ $meta_description_am ?? old('meta_description_am') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-2 col-form-label">{{__('Meta Keywords')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="meta_keywords" name="meta_keywords_am" type="text" class="form-control">{{ $meta_keywords_am ?? old('meta_keywords_am') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-sm-2 col-form-label">{{__('Content')}}</label>
                                    <div class="col-sm-10">
                                        <textarea id="content" name="content_am" class="summernote">{{ $content_am ?? old('content_am') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div> <!-- end card-body-->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('admin/dist/js/summernote.js')}}"></script>
    @if(app()->getLocale() == 'ru')
        <script src="{{asset('admin/dist/js/lang/summernote-ru-RU.js')}}"></script>
    @endif
    <script>
        $(function() {
            $('.summernote').summernote({
                height: 300,
                focus: true,
                @if(app()->getLocale() == 'ru')
                lang: 'ru-RU',
                @endif
                onpaste: function() {
                    alert('You have pasted something to the editor');
                }
            });
        });
    </script>
    <script>
        var slug = function(str) {
            var $slug = '';
            var trimmed = $.trim(str);
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
            return $slug.toLowerCase();
        }
        $("#title_en").keyup(function(){
            var text = $(this).val();
            $("#slug").val(slug(text));
        });
    </script>
@endsection
