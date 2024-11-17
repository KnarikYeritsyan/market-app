@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.products',app()->getLocale())}}">{{__('Products')}}</a></li>
    </ol>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('admin/dist/css/summernote.css')}}"/>
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet">
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

                        <a href="{{route('admin.products',app()->getLocale())}}" class="btn btn-xs btn-link"><h3><i class="fa fa-arrow-left"></i> {{__('Products')}}</h3></a>
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
                    <h4 class="card-title mb-3">{{__('New Product')}}</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">{{__('Image')}}</label>
                                    <input type="file" class="form-control-file" name="image" id="exampleInputFile" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Other Images')}}</label>
                                    <input type="file" class="form-control-file" name="images[]" id="exampleInputFile" multiple accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_id" class="col-sm-2 col-form-label">{{__('Category')}}</label>
                            <div class="col-sm-10">
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="brand_id" class="col-sm-2 col-form-label">{{__('Brand')}}</label>
                            <div class="col-sm-10">
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="">{{__('Choose')}}</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tag_id" class="col-sm-2 col-form-label">{{__('Tag')}}</label>
                            <div class="col-sm-10">
                                <select name="tag_id" id="tag_id" class="form-control">
                                    <option value="">{{__('Choose')}}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">{{__('Price')}}</label>
                            <div class="col-sm-10">
                                <input id="price" name="price" type="number" class="form-control" value="{{ $price ?? old('price') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">{{__('Quantity')}}</label>
                            <div class="col-sm-10">
                                <input id="quantity" name="quantity" type="number" class="form-control" value="{{$quantity ?? old('quantity')}}">
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">{{__('Options')}}</label>
                                <div class="col-sm-10 float-right">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="number" id="volume1" class="form-control" name="volumes[]" placeholder="{{__('Volume')}}" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" id="price1" class="form-control" name="prices[]" placeholder="{{__('Price')}}" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" id="quantity1" class="form-control" name="quantities[]" placeholder="{{__('Quantity')}}" required>
                                    </div>
                                    <button type="button" id="plus" class="btn btn-light btn-circle ml-1"><i class="fa fa-plus"></i></button>
                                </div>
                                </div>
                            </div>
                            <div id="cloned" class="mt-2">
                            </div>
                        <div class="form-group row">
                            <label for="volume" class="col-sm-2 col-form-label">{{__('Volume')}}</label>
                            <div class="col-sm-10">
                                <input id="volume" name="volume" type="number" class="form-control" value="{{ $volume ?? old('volume') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sale" class="col-sm-2 col-form-label">{{__('Sale')}}</label>
                            <div class="col-sm-10">
                                <input id="sale" name="sale" type="number" class="form-control" value="{{ $sale ?? old('sale') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aroma" class="col-sm-2 col-form-label">{{__('Aroma')}}</label>
                            <div class="col-sm-10">
                                <select name="aroma" id="aroma" class="form-control">
                                    <option value="universal">{{__('Universal')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-sm-2 col-form-label">{{__('For Who')}}</label>
                            <div class="col-sm-10">
                                <select name="type" id="type" class="form-control">
                                    <option value="women">{{__('Women')}}</option>
                                    <option value="man">{{__('Man')}}</option>
                                    <option value="unisex">{{__('Unisex')}}</option>
                                </select>
                            </div>
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
                                <label for="name" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-10">
                                    <input id="name" name="name_ru" type="text" class="form-control" value="{{ $name_ru ?? old('name_ru') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_ru" class="form-control summernote">{{ $description_ru ?? old('description_ru') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show" id="profile-b2">
                            <div class="form-group row">
                                <label for="name_en" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-10">
                                    <input id="name_en" name="name_en" type="text" class="form-control" value="{{ $name_en ?? old('name_en') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_en" class="form-control summernote">{{ $description_en ?? old('description_en') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings-b2">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-10">
                                    <input id="name" name="name_am" type="text" class="form-control" value="{{ $name_am ?? old('name_am') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_am" class="form-control summernote">{{ $description_am ?? old('description_am') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-header" >
                            <h5 class="mb-0">
                                <label style="color: #007bff;font-weight: 400" for="products">{{__('Related Products')}}</label>
                                <select class="js-select2 form-control" id="products" name="products[]" multiple>
                                    @foreach($products as $prod)
                                        <option value="{{$prod->id}}">{{$prod->name}}</option>
                                    @endforeach
                                </select>
                            </h5>
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
    <script type="text/javascript" src="{{ asset('admin/js/select2.full.js') }}"></script>
    @if(app()->getLocale() == 'ru')
        <script src="{{asset('admin/dist/js/lang/summernote-ru-RU.js')}}"></script>
    @endif
    <script>
        $(function() {
          $(".js-select2").select2({
          });
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
        $("#name_en").keyup(function(){
            var text = $(this).val();
            $("#slug").val(slug(text));
        });
        $(document).on("wheel", "input[type=number]", function (e) {
          $(this).blur();
        });
        $('#plus').on('click',function (event) {
          event.preventDefault();
          $('#cloned').append(
              '<div class="form-group row">' +
              '<label class="col-sm-2 col-form-label"></label>' +
              '<div class="col-sm-10">' +
              '    <div class="form-row">' +
              '        <div class="col">' +
              '            <input type="number" class="form-control" name="volumes[]" placeholder="{{__('Volume')}}" required>' +
              '        </div>' +
              '        <div class="col">' +
              '            <input type="number" class="form-control" name="prices[]" placeholder="{{__('Price')}}" required>' +
              '        </div>' +
              '        <div class="col">' +
              '            <input type="number" class="form-control" name="quantities[]" placeholder="{{__('Quantity')}}" required>' +
              '        </div>' +
              '        <button type="button" id="minus" class="btn btn-light btn-circle ml-1 minus"><i class="fa fa-minus"></i></button>' +
              '    </div>' +
              '</div>' +
              '</div>'
          )
        });
        $(document).on("click", ".minus", function (e) {
          $(this).parent().parent().parent().remove();
        });
    </script>
@endsection
