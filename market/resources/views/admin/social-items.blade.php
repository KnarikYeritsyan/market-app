@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{route('admin.home',app()->getLocale())}}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active">{{__('Social Media')}}</li>
    </ol>
@endsection
@section('css')
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery-3.3.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.css') }}">
    <script type="text/javascript" src="{{ asset('admin/assets/libs/fans/jquery.fancybox.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <style>
        .select2-container {
            min-width: 200px;
        }
    </style>
@endsection
@section('script')
    <script>
        function upd_media(data) {
            document.getElementById('title1').value = data.title;
            document.getElementById('link1').value = data.link;
            document.getElementById('status1').value = data.status;
            document.getElementById('hid_inp_for_upd').value = data.id;
            document.getElementById('type1').value = data.type;
            document.getElementById('type1').dispatchEvent(new Event('change'));
        }
        function format(state) {
            if (!state.id) return state.text;
            return '<img width="20px" class="flag" src="/admin/image/icon/'+state.element.value+'.svg" /> ' + state.text;
        }
        function formatState (state) {
            if (!state.id) { return state; }
            var $state = $(
                '<span ><img class="flag" src="/admin/image/icon/'+state.element.value+'.svg" /> ' + state.text + '</span>'
            );
            return $state;
        }
        $(document).ready(function() {
            $(".js-select2").select2({
                templateResult: format,
                templateSelection: format,
                escapeMarkup: function(m) { return m; }
            });
        });
    </script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddInfoModal">{{__('Add new')}} <i class="fas fa-plus"></i></button>
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
                            <th scope="col">{{__('Type')}}</th>
                            <th scope="col">{{__('Title')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($medias as $media)
                        <tr>
                            <th scope="row">
                                @if($media->type !='')
                                <a data-fancybox="del" href="{{asset('/admin/image/icon/'.$media->type.'.svg')}}"><img src="{{asset('/admin/image/icon/'.$media->type.'.svg')}}" style="width: 40px;border-radius: 4px;"></a>
                                @endif
                            </th>
                            <td>{{$media->title}}</td>
                            <td>
                                @if($media->status)
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
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#EditSocialModal" onclick='upd_media({{$media}})'><i class="ti-pencil-alt"></i></button>
                            <a onclick="return confirm('{{__('Are you sure?')}}')" href="{{route('admin.media-delete',['locale'=>app()->getLocale(),'id'=>$media->id])}}"><button type="button" class="btn btn-danger"><i class="ti-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$medias->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <div id="EditSocialModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{route('admin.media-update',app()->getLocale())}}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Update Social media')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title1">{{__('Title')}}</label>
                        <input id="title1" name="title" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type1">{{__('Type')}}</label>
                        <select class="js-select2 form-control" id="type1" name="type">
                            <option value="viber">
                                Viber
                            </option>
                            <option value="envelope">
                                Gmail
                            </option>
                            <option value="telegram">
                                Telegram
                            </option>
                            <option value="facebook-f">
                                Facebook
                            </option>
                            <option value="instagram">
                                Instagram
                            </option>
                            <option value="youtube">
                                Yuotube
                            </option>
                            <option value="linkedin">
                                Linkedin
                            </option>
                            <option value="whatsapp">
                                Whatsapp
                            </option>
                            <option value="pinterest">
                                Pinterest
                            </option>
                            <option value="skype">
                                Skype
                            </option>
                            <option value="twitter">
                                Twitter
                            </option>
                            <option value="facebook-messenger">
                                Messenger
                            </option>
                            <option value="google-plus">
                                Google Plus
                            </option>
                            <option value="vk">
                                Vkontakte
                            </option>
                            <option value="odnoklassniki">
                                Odnoklassniki
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="link1">{{__('Link')}}</label>
                        <input id="link1" name="link" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status1">{{__('Status')}}</label>
                        <select id="status1" class="form-control" name="status" required>
                            <option value="1">{{__('Published')}}</option>
                            <option value="0">{{__('Not Published')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="hid_inp_for_upd" name="upd_id">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div id="AddInfoModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="{{route('admin.media-create',app()->getLocale())}}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Create Social media')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">{{__('Title')}}</label>
                        <input id="title" name="title" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="type">{{__('Type')}}</label>
                        <select class="js-select2 form-control" id="type" name="type">
                            <option value="viber">
                                Viber
                            </option>
                            <option value="envelope">
                                Gmail
                            </option>
                            <option value="telegram">
                                Telegram
                            </option>
                            <option value="facebook-f">
                                Facebook
                            </option>
                            <option value="instagram">
                                Instagram
                            </option>
                            <option value="youtube">
                                Yuotube
                            </option>
                            <option value="linkedin">
                                Linkedin
                            </option>
                            <option value="whatsapp">
                                Whatsapp
                            </option>
                            <option value="pinterest">
                                Pinterest
                            </option>
                            <option value="skype">
                                Skype
                            </option>
                            <option value="twitter">
                                Twitter
                            </option>
                            <option value="facebook-messenger">
                                Messenger
                            </option>
                            <option value="google-plus">
                                Google Plus
                            </option>
                            <option value="vk">
                                Vkontakte
                            </option>
                            <option value="odnoklassniki">
                                Odnoklassniki
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="link">{{__('Link')}}</label>
                        <input id="link" name="link" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status">{{__('Status')}}</label>
                        <select id="status" class="form-control" name="status" required>
                            <option value="1">{{__('Published')}}</option>
                            <option value="0">{{__('Not Published')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
