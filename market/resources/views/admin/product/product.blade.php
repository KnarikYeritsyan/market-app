@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.products',app()->getLocale())}}">{{__('Products')}}</a></li>
    </ol>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('admin/dist/css/summernote.css')}}"/>
    <link href="/admin/dist/css/jquery-ui.css" rel="stylesheet">
    <link href="/admin/css/file-upload.css" rel="stylesheet">
    <link href="/admin/css/sortable-images.css" rel="stylesheet">
    <link href="/admin/dist/toastr/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .file_manager .hover {
            position: absolute;
            margin-left: 150px;
            margin-top: -25px;
            /*display: none;*/
            transition: all 0.2s ease-in-out;
        }
    </style>
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
                        <a href="{{route('admin.product-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>
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
                    <h4 class="card-title mb-3">{{$product->name}}</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="exampleInputFile" class="col-sm-2 col-form-label">{{__('Image')}}</label>
                            <fieldset class="form-group">
                                <input type="file" class="form-control-file" name="image" id="exampleInputFile" accept="image/*">
                            </fieldset>
                        </div>
                        <div class="form-group">
                            @if($product->image_name_resize != '')
                            <img width="300px" src="{{$product->image_name_resize}}" alt="{{$product->name}}">
                            @endif
                        </div>
                        <div class="form-group row">
                            <label for="category_id" class="col-sm-2 col-form-label">{{__('Category')}}</label>
                            <div class="col-sm-10">
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        <option <?php if($product->category_id == $category->id) echo 'selected' ?> value="{{$category->id}}">{{$category->name}}</option>
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
                                        <option <?php if($product->brand_id == $brand->id) echo 'selected' ?> value="{{$brand->id}}">{{$brand->name}}</option>
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
                                        <option <?php if($product->tag_id == $tag->id) echo 'selected' ?> value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">{{__('Price')}}</label>
                            <div class="col-sm-10">
                                <input id="price" name="price" type="number" class="form-control" value="{{$product->price}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">{{__('Quantity')}}</label>
                            <div class="col-sm-10">
                                <input id="quantity" name="quantity" type="number" class="form-control" value="{{$product->quantity}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">{{__('Options')}}</label>
                            <div class="col-sm-10">
                            <button type="button" id="plus" class="btn btn-light btn-circle ml-1"><i class="fa fa-plus"></i></button>
                            </div>
                            </div>
                        <div id="cloned" class="mt-2">
                        @foreach($product->options as $option)
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10 float-right">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="number" id="volume1" value="{{$option->type}}" class="form-control" name="volumes[]" placeholder="{{__('Volume')}}" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" id="price1" value="{{$option->price}}" class="form-control" name="prices[]" placeholder="{{__('Price')}}" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" id="quantity1" value="{{$option->quantity}}" class="form-control" name="quantities[]" placeholder="{{__('Quantity')}}" required>
                                    </div>
                                    <button type="button" id="minus" class="btn btn-light btn-circle ml-1 minus"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                        <div class="form-group row">
                            <label for="volume" class="col-sm-2 col-form-label">{{__('Volume')}}</label>
                            <div class="col-sm-10">
                                <input id="volume" name="volume" type="number" class="form-control" value="{{ $product->volume}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sale" class="col-sm-2 col-form-label">{{__('Sale')}}</label>
                            <div class="col-sm-10">
                                <input id="sale" name="sale" type="number" class="form-control" value="{{ $product->sale }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aroma" class="col-sm-2 col-form-label">{{__('Aroma')}}</label>
                            <div class="col-sm-10">
                                <select name="aroma" id="aroma" class="form-control">
                                    <option <?php if($product->aroma == 'universal') echo 'selected' ?> value="universal">{{__('Universal')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-sm-2 col-form-label">{{__('For Who')}}</label>
                            <div class="col-sm-10">
                                <select name="type" id="type" class="form-control">
                                    <option <?php if($product->type == 'woman') echo 'selected' ?> value="woman">{{__('Woman')}}</option>
                                    <option <?php if($product->type == 'man') echo 'selected' ?> value="man">{{__('Man')}}</option>
                                    <option <?php if($product->type == 'unisex') echo 'selected' ?> value="unisex">{{__('Unisex')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-sm-2 col-form-label">{{__('Slug')}}</label>
                            <div class="col-sm-10">
                                <input id="slug" name="slug" type="text" class="form-control" value="{{$product->slug}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">{{__('Status')}}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option <?php if($product->status) echo 'selected' ?> value="1">{{__('Published')}}</option>
                                    <option <?php if(!$product->status) echo 'selected' ?> value="0">{{__('Not Published')}}</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="upd_id" value="{{$product->id}}">
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
                                    <input id="name" name="name_ru" type="text" class="form-control" value="{{isset($product->translations['name']['ru'])?$product->translations['name']['ru']:''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_ru" class="form-control summernote">{{isset($product->translations['description']['ru'])?$product->translations['description']['ru']:''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show" id="profile-b2">
                            <div class="form-group row">
                                <label for="name_en" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-10">
                                    <input id="name_en" name="name_en" type="text" class="form-control" value="{{isset($product->translations['name']['en'])?$product->translations['name']['en']:''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_en" class="form-control summernote">{{isset($product->translations['description']['en'])?$product->translations['description']['en']:''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings-b2">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                                <div class="col-sm-10">
                                    <input id="name" name="name_am" type="text" class="form-control" value="{{isset($product->translations['name']['am'])?$product->translations['name']['am']:''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{__('Description')}}</label>
                                <div class="col-sm-10">
                                    <textarea id="description" name="description_am" class="form-control summernote">{{isset($product->translations['description']['am'])?$product->translations['description']['am']:''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-header" >
                            <h5 class="mb-0">
                                <label style="color: #007bff;font-weight: 400" for="products">{{__('Related Products')}}</label>
                                <select class="js-select2 form-control" id="products" name="products[]" multiple>
                                    @foreach($products as $prod)
                                        <option @foreach($product->related_products as $related) @if($related->id == $prod->id) selected @endif @endforeach value="{{$prod->id}}">{{$prod->name}}</option>
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
                        <div class="row" style="display: inline-block">
                            <ul id="sortable">
                                @if(!empty($product->images))
                                    @foreach($product->images as $image)
                                        <li class="ui-state-default file_manager" id="{{$image->id}}">
                                            <div class="hover">
                                                <button type="button" data-id="{{$image->id}}" class="btn btn-danger rm-image"><i class="ti-trash"></i></button>
                                            </div>
                                            <img width="200px" height="200px" src="{{$image->image_name_resize}}" alt="">
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <ul id="non-sortable">
                                <li class="ui-state-default" id="1">
                                    <form method="post" action="{{route('admin.product-images-add',['locale'=>app()->getLocale(),'id'=>$product->id])}}" enctype="multipart/form-data" novalidate="" class="box has-advanced-upload">
                                        @csrf
                                        <div class="box__input">
                                            <svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path></svg>
                                            <input hidden type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} {{__('files selected')}}" multiple="" accept="image/*">
                                            <label for="file"><strong>{{__('Choose a file')}}</strong><span class="box__dragndrop"> {{__('or drag it here')}}</span>.</label>
                                            <button type="submit" class="box__button">{{__('Upload')}}</button>
                                        </div>
                                        <div class="box__uploading">{{__('Uploading…')}}</div>
                                        <div class="box__success">{{__('Done!')}} <a href="{{request()->url()}}" class="box__restart" role="button">{{__('Upload more?')}}</a></div>
                                        <div class="box__error">{{__('Error!')}} <span></span>. <a href="{{request()->url()}}" class="box__restart" role="button">{{__('Try again!')}}</a></div>
                                        <input type="hidden" name="ajax" value="1"></form>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="/admin/dist/js/jquery-ui.js"></script>
    <script src="/admin/js/file-upload.js"></script>
    <script src="/admin/dist/toastr/toastr.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/select2.full.js') }}"></script>
    <script>
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
        $( function() {
          $(".js-select2").select2({
          });
            $( "#sortable" ).sortable({
                stop: function (event, ui) {
                    var order = $(this).sortable('serialize');
                    var ids = $(this).children().get().map(function(el) {
                        return el.id
                    })
                    // .join(",");
                    // console.log(JSON.parse(ids));
                    if(ids) {
                        $.ajax({
                            url: "{{route('admin.product-images-sort',['locale'=>app()->getLocale(),'id'=>$product->id])}}",
                            method: "POST",
                            data: {ids: ids},
                            beforeSend: function (request) {
                                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                            },
                            success: function (data) {
                                // alert('done')
                                toastr.options.timeOut = "false";
                                toastr.options.closeButton = true;
                                toastr.options.positionClass = 'toast-bottom-right';
                                toastr['success']("{{__('Done!')}}");
                            },
                            error: function () {
                                alert('error');
                            }
                        })
                    }
                }
            });
            $( "#sortable" ).disableSelection();

            $('.rm-image').on('click',function () {
                if(confirm('{{__('Are you sure?')}}')) {
                    var id = $(this).attr("data-id");
                    var that = this;
                    that.parentNode.parentNode.remove();
                    var ids = $("#sortable").children().get().map(function (el) {
                        return el.id
                    })
                    $.ajax({
                        url: "{{route('admin.product-delete-image',app()->getLocale())}}",
                        method: "POST",
                        data: {image_id: id, ids: ids},
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (data) {
                            toastr.options.timeOut = "false";
                            toastr.options.closeButton = true;
                            toastr.options.positionClass = 'toast-bottom-right';
                            toastr['success']("{{__('Done!')}}");
                        },
                        error: function () {
                            alert('error');
                        }
                    })
                }else {
                    return false;
                }
            });
        });
    </script>
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
        $("#name_en").keyup(function(){
            var text = $(this).val();
            $("#slug").val(slug(text));
        });
    </script>
@endsection
