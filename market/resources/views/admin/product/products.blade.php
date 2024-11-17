@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Products')}}</li>
    </ol>
@endsection
@section('css')
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.css') }}">
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.js') }}"></script>
@endsection
@section('script')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex;justify-content: space-between">
                        <a href="{{route('admin.product-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>
                        <form class="col-md-4">
                            <div class="input-group">
                                <input hidden name="search_term" value="{{request()->get('search_term')?request()->get('search_term'):''}}">
                                <select class="custom-select" name="category">
                                    <option selected="" value="">{{__('Choose Category...')}}</option>
                                    @foreach($categories as $category)
                                    <option {{request()->get('category') == $category->id?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">{{__('Filter')}}</button>
                                </div>
                            </div>
                        </form>
                        <form method="get" action="" class="input-group col-md-4 search-group">
                            <input hidden name="category" value="{{request()->get('category')?request()->get('category'):''}}">
                            <input name="search_term" class="form-control py-2 border-right-0 border" type="search" id="product-search-input" value="{{request()->get('search_term')?request()->get('search_term'):''}}">
                            <span class="input-group-append">
                <button class="btn btn-outline-secondary border-left-0 border" type="submit">
                    <i class="fa fa-search"></i>
                </button>
              </span>
                        </form>
                    </div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
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
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{__('Image')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            {{--<th scope="col"><a style="color:#fff;" href="{{request()->fullUrlWithQuery(['sort'=>request()->get('sort')?(request()->get('sort')=='price:asc'?'price:desc':'price:asc'):'price:asc','search_term'=>request()->get('search_term')?request()->get('search_term'):'','category'=>request()->get('category')?request()->get('category'):''])}}">{{__('Price')}} <i class="fa fa-arrow-down {{request()->get('sort')?(request()->get('sort')!='price:desc'?'text-secondary':''):'text-secondary'}}"></i><i class="fa fa-arrow-up {{request()->get('sort')?(request()->get('sort')!='price:asc'?'text-secondary':''):'text-secondary'}}"></i></a></th>--}}
                            <th scope="col">
                                <a style="color:#fff;" href="{{add_query_params(['sort'=>(request()->get('sort') && request()->get('sort')=='price:asc')?'price:desc':'price:asc'])}}">
                                    {{__('Price')}}
                                    <i class="fa fa-arrow-down {{(request()->get('sort') && request()->get('sort')=='price:desc')?'':'text-secondary'}}"></i>
                                    <i class="fa fa-arrow-up {{(request()->get('sort') && request()->get('sort')=='price:asc')?'':'text-secondary'}}"></i>
                                </a>
                            </th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <th scope="row">
                                @if($product->image_name_resize !='')
                                <a data-fancybox="del" href="{{asset($product->image_name)}}"><img src="{{asset($product->image_name_resize)}}" style="width: 40px;border-radius: 4px;"></a>
                                @endif
                            </th>
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                @if($product->status)
                                    <small class="badge badge-default badge-success form-text text-white">
                                        {{__('Published')}}
                                    </small>
                                @else
                                    <small class="badge badge-default badge-danger form-text text-white">
                                        {{__('Not Published')}}
                                    </small>
                                @endif
                            </td>
                            <td>
                            <a href="{{route('admin.product',['locale'=>app()->getLocale(),'id'=>$product->id])}}"><button type="button" class="btn btn-secondary"><i class="ti-pencil-alt"></i></button></a>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.product-delete',['locale'=>app()->getLocale(),'id'=>$product->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?php echo e($products->appends($_GET)->links()); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
