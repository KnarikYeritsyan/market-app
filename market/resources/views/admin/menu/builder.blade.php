@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.menus',app()->getLocale())}}">{{__('Menus')}}</a></li>
    </ol>
@endsection
@section('css')
    <link href="/admin/dist/nestable/jquery-nestable.css" rel="stylesheet">
    <link href="/admin/dist/toastr/toastr.min.css" rel="stylesheet">
    <style>
        .accordion .fa{
            margin-right: 0.5rem;
        }
        .accordion .card, .accordion .card .collapse .card-body{
            border: 1px solid #ccd0d4;
        }
        .accordion .card .card-header{
            padding: 5px;
        }
        .accordion .card .card-header:hover{
            cursor: pointer;
        }
        .accordion .card .card-body{
            padding-bottom: 40px;
        }
        .accordion{
            padding-left: 0;
        }
        .accordion li{
            margin-bottom: 0;
        }
        .accordion-scroll-body{
            max-height: 130px;
            overflow-y: auto;
            margin-bottom: 10px;
        }
        .text-secondary1{
            color: #23282d;
        }
        .text-secondary1:hover{
            color: #23282d;
        }
        .dd-item > button {
            top: 37px;
            display: none;
        }
        .open-det{
            border: solid #ccc;
            border-width:1px 1px 1px 0;
            background: #fafafa;
        }
        .handle-text-right{
            float: right;
            margin-right: 25px;
        }
        .dd-empty{
            display: none;
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
{{--                        <a href="{{route('admin.menus',app()->getLocale())}}" class="btn btn-xs btn-link"><h3><i class="fa fa-arrow-left"></i> {{__('Menus')}}</h3></a>--}}
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
                    <h4 class="card-title mb-3">{{$menu->name }}</h4>
                        <div class="row">
                    <div class="col-md-6">
                        <div class="bs-example">
                            <ul class="accordion" id="accordionExample">
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="page-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="page">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne">
                                        <h2 class="mb-0">
                                            <button type="button" class="text-secondary1 btn collapsed"><i class="fas fa-caret-down"></i> {{__('Pages')}}</button>
                                        </h2>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="accordion-scroll-body">
                                            @foreach($pages as $page)
                                            <div class="custom-control custom-checkbox">
                                                <input name="conn_ids[]" value="{{$page->id}}" type="checkbox" class="custom-control-input" id="customCheckpage{{$page->id}}">
                                                <label class="custom-control-label" for="customCheckpage{{$page->id}}">{{$page->title}}</label>
                                            </div>
                                            @endforeach
                                            </div>
                                                <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </li>
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="cat-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="categories">
                                        <input hidden name="menu-type" value="category">
                                    <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo">
                                        <h2 class="mb-0">
                                            <button type="button" class="text-secondary1 btn"><i class="fas fa-caret-down"></i> {{__('Categories')}}</button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                       <div class="card-body">
                                           <div class="accordion-scroll-body">
                                           <div class="custom-control custom-checkbox">
                                               <input name="conn_ids[]" value="null" type="checkbox" class="custom-control-input" id="customCheckcatall">
                                               <label class="custom-control-label" for="customCheckcatall">{{__('All Categories list')}}</label>
                                           </div>
                                           @foreach($categories as $category)
                                               <div class="custom-control custom-checkbox">
                                                   <input name="conn_ids[]" value="{{$category->id}}" type="checkbox" class="custom-control-input" id="customCheckcat{{$category->id}}">
                                                   <label class="custom-control-label" for="customCheckcat{{$category->id}}">{{$category->name}}</label>
                                               </div>
                                           @endforeach
                                           </div>
                                           <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                       </div>
                                    </div>
                                    </form>
                                </li>
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="cat-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="shop">
                                        <input hidden name="menu-type" value="category">
                                        <div class="card-header" id="headingSix" data-toggle="collapse" data-target="#collapseSix">
                                            <h2 class="mb-0">
                                                <button type="button" class="text-secondary1 btn"><i class="fas fa-caret-down"></i> {{__('Shop')}}</button>
                                            </h2>
                                        </div>
                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="accordion-scroll-body">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="conn_ids[]" value="null" type="checkbox" class="custom-control-input" id="customCheckshopall">
                                                        <label class="custom-control-label" for="customCheckshopall">{{__('Shop')}}</label>
                                                    </div>
                                                </div>
                                                <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="brand-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="brand">
                                        <input hidden name="menu-type" value="brand">
                                    <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree">
                                        <h2 class="mb-0">
                                            <button type="button" class="text-secondary1 btn collapsed"><i class="fas fa-caret-down"></i> {{__('Brands')}}</button>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="accordion-scroll-body">
                                            <div class="custom-control custom-checkbox">
                                                <input name="conn_ids[]" value="null" type="checkbox" class="custom-control-input" id="customCheckbrandall">
                                                <label class="custom-control-label" for="customCheckbrandall">{{__('All Brands list')}}</label>
                                            </div>
                                            @foreach($brands as $brand)
                                                <div class="custom-control custom-checkbox">
                                                    <input name="conn_ids[]" value="{{$brand->id}}" type="checkbox" class="custom-control-input" id="customCheckbrand{{$brand->id}}">
                                                    <label class="custom-control-label" for="customCheckbrand{{$brand->id}}">{{$brand->name}}</label>
                                                </div>
                                            @endforeach
                                            </div>
                                            <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </li>
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="tag-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="tag">
                                        <input hidden name="menu-type" value="tag">
                                    <div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour">
                                        <h2 class="mb-0">
                                            <button type="button" class="text-secondary1 btn collapsed"><i class="fas fa-caret-down"></i> {{__('Tags')}}</button>
                                        </h2>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="accordion-scroll-body">
                                            <div class="custom-control custom-checkbox">
                                                <input name="conn_ids[]" value="null" type="checkbox" class="custom-control-input" id="customChecktagall">
                                                <label class="custom-control-label" for="customChecktagall">{{__('All Tags list')}}</label>
                                            </div>
                                            @foreach($tags as $tag)
                                                <div class="custom-control custom-checkbox">
                                                    <input name="conn_ids[]" value="{{$tag->id}}" type="checkbox" class="custom-control-input" id="customChecktag{{$tag->id}}">
                                                    <label class="custom-control-label" for="customChecktag{{$tag->id}}">{{$tag->name}}</label>
                                                </div>
                                            @endforeach
                                            </div>
                                            <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </li>
                                <li class="card">
                                    <form class="add-menu-form" action="{{route('admin.add-menu',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}" method="post" id="url-menu-form">
                                        @csrf
                                        <input hidden name="menu-group" value="custom_link">
                                    <div class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive">
                                        <h2 class="mb-0">
                                            <button type="button" class="text-secondary1 btn collapsed"><i class="fas fa-caret-down"></i> {{__('Custom Links')}}</button>
                                        </h2>
                                    </div>
                                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="form-group row" style="margin-right: -25px;margin-left: -25px;">
                                                <label for="custommenuurl" class="col-md-2 col-form-label">{{__('URL')}}</label>
                                                <div class="col-md-10">
                                                    <input id="custommenuurl" type="text" class="form-control " name="url" value="" autofocus="" placeholder="https://">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-right: -25px;margin-left: -25px;">
                                                <label for="custommenuurltext" class="col-md-2 col-form-label">{{__('Link Text')}}</label>
                                                <div class="col-md-10">
                                                    <input id="custommenuurltext" type="text" class="form-control " name="url_text" value="" autofocus="" required>
                                                </div>
                                            </div>
                                            <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Add to menu')}} <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                            <div class="col-md-6">
                                <div class="clearfix m-b-20">
                                    <div class="dd" id="nestable">
                                        <ol class="dd-list" id="dd-list-id">
                                            @each('admin.partials.menu', $items, 'item')
                                        {{--@foreach($items as $item)
                                           @include('admin.partials.menu', $item)
                                        @endforeach--}}
                                        </ol>
                                    </div>
                                </div>
                                <textarea hidden id="jsonoutput" cols="30" rows="3" class="form-control no-resize" readonly></textarea>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="/admin/dist/nestable/jquery.nestable.min.js"></script>
    <script src="/admin/dist/toastr/toastr.js"></script>
    <script>
      $(document).ready(function(){
        $('.dd').nestable({
          callback: function () {
          var serializedData = window.JSON.stringify($('.dd').nestable('serialize'));
          $('#jsonoutput').val(serializedData);
          $.ajax({
            url: "{{route('admin.menu-sort',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}",
            method: "POST",
            data: {ids: serializedData},
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
        }});
        $(".collapse.show").each(function(){
          $(this).prev(".card-header").find(".fas").addClass("fa-caret-up").removeClass("fa-caret-down");
        });
        $(".collapse").on('show.bs.collapse', function(){
          $(this).prev(".card-header").find(".fas").removeClass("fa-caret-down").addClass("fa-caret-up");
          $(this).parent().parent().prev().find('.fas').removeClass("fa-caret-down").addClass("fa-caret-up");
        }).on('hide.bs.collapse', function(){
          $(this).prev(".card-header").find(".fas").removeClass("fa-caret-up").addClass("fa-caret-down");
          $(this).parent().parent().prev().find('.fas').removeClass("fa-caret-up").addClass("fa-caret-down");
        });
      });
    </script>
    @include('admin.partials.add-menu')
@endsection
