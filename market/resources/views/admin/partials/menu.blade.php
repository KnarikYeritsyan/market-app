<li class="dd-item" data-id="{{$item->id}}">
    <div style="display: inline-block" class="dd-handle form-control">{{$item->title}}
        <div class="handle-text-right">
            <span class="">{{($item->group == 'categories' && $item->type == 'category')?__($item->type):__($item->group)}}</span>
        </div>
    </div>
    <div style="float: right;margin-top: -43px;" class="input-group-append">
        <button data-toggle="collapse" href="#collapsedet{{$item->id}}" type="button" class="text-secondary btn open-det"><i class="fas fa-caret-down"></i></button>
    </div>
    <div class="dd-content">
        <form method="post" id="save-menu-form" class="save-menu-form">
            <input hidden name="item_id" value="{{$item->id}}">
            <div id="collapsedet{{$item->id}}" class="collapse">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#home-b2{{$item->id}}" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-lg-block">{{__('Russian')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b2{{$item->id}}" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-lg-block">{{__('English')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings-b2{{$item->id}}" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                <span class="d-lg-block">{{__('Armenian')}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-b2{{$item->id}}">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                <div class="col-sm-10">
                                    <input id="title" name="title_ru" type="text" class="form-control" value="{{isset($item->translations['title']['ru'])?$item->translations['title']['ru']:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show" id="profile-b2{{$item->id}}">
                            <div class="form-group row">
                                <label for="title_en" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                <div class="col-sm-10">
                                    <input id="title_en" name="title_en" type="text" class="form-control" value="{{isset($item->translations['title']['en'])?$item->translations['title']['en']:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings-b2{{$item->id}}">
                            <div class="form-group row">
                                <label for="title_am" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                                <div class="col-sm-10">
                                    <input id="title" name="title_am" type="text" class="form-control" value="{{isset($item->translations['title']['am'])?$item->translations['title']['am']:''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($item->group == 'custom_link')
                    <div class="form-group row">
                        <label for="url" class="col-sm-2 col-form-label">{{__('URL')}}</label>
                        <div class="col-sm-10">
                            <input id="url" name="url" type="text" class="form-control" value="{{$item->url}}">
                        </div>
                    </div>
                    @endif
                    <button type="button" data-id="{{$item->id}}" class="btn btn-sm btn-danger rm-menu"><i class="ti-trash"></i></button>
                    <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </form>
    </div>
    @if (count($item['children']) > 0)
        <ol class="dd-list">
            @foreach($item['children'] as $item)
                @include('admin.partials.menu', $item)
            @endforeach
        </ol>
    @endif
</li>