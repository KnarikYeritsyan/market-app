@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('All Contact Messages')}}</li>
    </ol>
@endsection
@section('css')
@endsection
@section('script')
    <script>
      $('.show-button').on('click',function () {
        $('#text-p-for-text').text($(this).attr('data-value'))
      })    </script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.new-messages',app()->getLocale())}}" class="btn btn-primary">{{__('New messages')}}</a>
                    <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.clear-messages',app()->getLocale())}}" class="btn btn-danger float-right">{{__('Clear All')}}</a>
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
                            <th scope="col">{{__('IP')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Email')}}</th>
                            <th scope="col">{{__('Subject')}}</th>
                            <th scope="col">{{__('Message')}}</th>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{$message->ip}}</td>
                            <td>{{$message->name}}</td>
                            <td>{{$message->email}}</td>
                            <td>{{$message->subject}}</td>
                            <td>
                                <button data-value = "{{$message->message}}" data-toggle="modal" data-target="#TextModal" class="btn btn-info show-button">{{__('See message')}}</button>
                            </td>
                            <td>{{$message->created_at->format('d.m.Y')}}</td>
                            <td>
                            <a href="{{route('admin.message-delete',['locale'=>app()->getLocale(),'id'=>$message->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?php echo e($messages->appends($_GET)->links()); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <div id="TextModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Contact Message')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p id="text-p-for-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

