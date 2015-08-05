<div class="box-header with-border">
    <h3 class="box-title"> Edit  user [{!!$user->first_name . ' ' . $user->last_name!!}] </h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-primary btn-sm" id="btnSave"><i class="fa fa-floppy-o"></i> Save</button>
        <button type="button" class="btn btn-default btn-sm" id="btnClose"><i class="fa fa-times-circle"></i> Close</button>
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
</div>
<div class="box-body" >
    <div class="nav-tabs-custom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs primary">
          @include('user::admin.users.partials.tabs')
        </ul>
        {!!Former::vertical_open()
        ->id('formEntry')
        ->method('PUT')
        ->enctype('multipart/form-data')
        ->action(URL::to('admin/user/user/'. $user['id']))!!}
        <div class="tab-content">
          @include('user::admin.users.partials.contents')
        </div>
        {!!Former::close()!!}
    </div>
</div>
<div class="box-footer" >
    &nbsp;
</div>
<script type="text/javascript">
        (function ($) {
            $('#btnClose').click(function(){
                $('#entry').load('{!!URL::to('admin/user/user')!!}/{!!$user->id!!}');
            });

            $('#btnSave').click(function(){
                $('#formEntry').submit();
            });

            $('#formEntry')
            .submit( function( e ) {
                var formURL  = "{!!URL::to('admin/user/user')!!}/{!!@$user->id!!}";
                $.ajax( {
                    url: formURL,
                    type: 'POST',
                    data: new FormData( this ),
                    processData: false,
                    contentType: false,
                    success:function(data, textStatus, jqXHR)
                    {
                        toastr.success('{User} updated successfuly.', 'Success');
                        $('#entry').load('{!!URL::to('admin/user')!!}/{!!$user->id!!}');
                        $('#main_list').DataTable().ajax.reload( null, false );
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        toastr.error(errorThrown, 'Error');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
                e.preventDefault();
            });
        }(jQuery));
</script>