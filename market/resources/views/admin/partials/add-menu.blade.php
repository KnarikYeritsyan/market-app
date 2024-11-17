<script>
$(document).ready(function(){
  $('.add-menu-form').on('submit',function (event) {
    event.preventDefault();
    $.ajax({
      type:'post',
      contentType:false,
      processData:false,
      url: $(this).attr('action'),
      data:new FormData(this),
      success:function (data) {
        console.log(data)
        $.each(data.data,function(index, value) {
          $('#dd-list-id').append(
              '<li class="dd-item" data-id="'+value.id+'">' +
              '    <div style="display: inline-block" class="dd-handle form-control">'+value.show_title +
              '        <div class="handle-text-right">' +
              '            <span class="">'+value.show_group+'</span>' +
              '        </div>' +
              '    </div>' +
              '    <div style="float: right;margin-top: -43px;" class="input-group-append">' +
              '        <button data-toggle="collapse" href="#collapsedet'+value.id+'" type="button" class="text-secondary btn open-det"><i class="fas fa-caret-down"></i></button>' +
              '    </div>' +
              '    <div class="dd-content">' +
              '        <form method="post" id="save-menu-form" class="save-menu-form" action="{{route('admin.menu-save',app()->getLocale())}}">' +
                  '@csrf'+
                  '<input hidden name="item_id" value="'+value.id+'">'+
              '            <div id="collapsedet'+value.id+'" class="collapse">' +
              '                <div class="card-body">' +
              '                    <ul class="nav nav-tabs nav-justified nav-bordered mb-3">' +
              '                        <li class="nav-item">' +
              '                            <a href="#home-b2'+value.id+'" data-toggle="tab" aria-expanded="false" class="nav-link active">' +
              '                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>' +
              '                                <span class="d-lg-block">{{__('Russian')}}</span>' +
              '                            </a>' +
              '                        </li>' +
              '                        <li class="nav-item">' +
              '                            <a href="#profile-b2'+value.id+'" data-toggle="tab" aria-expanded="true" class="nav-link">' +
              '                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>' +
              '                                <span class="d-lg-block">{{__('English')}}</span>' +
              '                            </a>' +
              '                        </li>' +
              '                        <li class="nav-item">' +
              '                            <a href="#settings-b2'+value.id+'" data-toggle="tab" aria-expanded="false" class="nav-link">' +
              '                                <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>' +
              '                                <span class="d-lg-block">{{__('Armenian')}}</span>' +
              '                            </a>' +
              '                        </li>' +
              '                    </ul>' +
              '                    <div class="tab-content">' +
              '                        <div class="tab-pane active" id="home-b2'+value.id+'">' +
              '                            <div class="form-group row">' +
              '                                <label for="title" class="col-sm-2 col-form-label">{{__('Title')}}</label>' +
              '                                <div class="col-sm-10">' +
              '                                    <input id="title" name="title_ru" type="text" class="form-control" value="'+value.title.ru+'">' +
              '                                </div>' +
              '                            </div>' +
              '                        </div>' +
              '                        <div class="tab-pane show" id="profile-b2'+value.id+'">' +
              '                            <div class="form-group row">' +
              '                                <label for="title_en" class="col-sm-2 col-form-label">{{__('Title')}}</label>' +
              '                                <div class="col-sm-10">' +
              '                                    <input id="title_en" name="title_en" type="text" class="form-control" value="'+value.title.en+'">' +
              '                                </div>' +
              '                            </div>' +
              '                        </div>' +
              '                        <div class="tab-pane" id="settings-b2'+value.id+'">' +
              '                            <div class="form-group row">' +
              '                                <label for="title_am" class="col-sm-2 col-form-label">{{__('Title')}}</label>' +
              '                                <div class="col-sm-10">' +
              '                                    <input id="title" name="title_am" type="text" class="form-control" value="'+value.title.am+'">' +
              '                                </div>' +
              '                            </div>' +
              '                        </div>' +
              '                    </div>' +
                  (value.group == 'custom_link' ?
                    '                     <div class="form-group row">' +
                    '                        <label for="url" class="col-sm-2 col-form-label">{{__('URL')}}</label>' +
                    '                        <div class="col-sm-10">' +
                    '                            <input id="url" name="url" type="text" class="form-control" value="' + value.url + '">' +
                    '                        </div>' +
                    '                    </div>'
                  : '' )+
              '                    <button type="button" data-id="'+value.id+'" class="btn btn-sm btn-danger"><i class="ti-trash rm-menu"></i></button>' +
              '                    <button style="float: right" type="submit" class="btn btn-sm btn-primary">{{__('Save')}}</button>' +
              '                </div>' +
              '            </div>' +
              '        </form>' +
              '    </div>' +
              '</li>'
          )
        })
        $('input:checkbox').prop('checked',false);
        toastr.options.timeOut = "false";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr['success']("{{__('Done!')}}");
      },
      error: function(data) {
        console.log('Error');
        toastr.options.timeOut = "false";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr['error']("{{__('Error!')}}");
      }

    })
  })

  $('.save-menu-form').on('submit',function (event) {
    event.preventDefault();
    $.ajax({
      method:'POST',
      contentType:false,
      processData:false,
      url: "{{route('admin.menu-save',app()->getLocale())}}",
      data:new FormData(this),
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success:function (data) {
        toastr.options.timeOut = "false";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr['success']("{{__('Done!')}}");
      },
      error: function(data) {
        console.log('Error');
        toastr.options.timeOut = "false";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr['error']("{{__('Error!')}}");
      }
      })
      });

  $('.rm-menu').on('click',function () {
    if(confirm('{{__('Are you sure?')}}')) {
      var id = $(this).attr("data-id");
      var that = this;
      $(this).closest("li").remove();
      var ids = window.JSON.stringify($('.dd').nestable('serialize'))
      console.log(ids)
      $.ajax({
        url: "{{route('admin.menu-delete',['locale'=>app()->getLocale(),'menu_id'=>$menu->id])}}",
        method: "POST",
        data: {item_id: id, ids: ids},
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
          location.reload()
        }
      })
    }else {
      return false;
    }
  })
});
</script>