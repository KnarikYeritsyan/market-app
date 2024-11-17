@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Tags')}}</li>
    </ol>
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
                        <a href="{{route('admin.tag-create',app()->getLocale())}}" class="btn btn-primary">{{__('Add new')}} <i class="fas fa-plus"></i></a>
                        <form method="get" action="" class="input-group col-md-4 search-group">
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
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Color')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{$tag->name}}</td>
                            <td>
                                <small style="background-color: {{$tag->color}}" class="badge badge-default form-text text-white">
                                    {{$tag->color}}</small>
                                </td>
                            <td>
                                @if($tag->status)
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
                            <a href="{{route('admin.tag',['locale'=>app()->getLocale(),'id'=>$tag->id])}}"><button type="button" class="btn btn-secondary"><i class="ti-pencil-alt"></i></button></a>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.tag-delete',['locale'=>app()->getLocale(),'id'=>$tag->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?php echo e($tags->appends($_GET)->links()); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
