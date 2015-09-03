<div class="box-header with-border">
    <h3 class="box-title"> New User </h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-primary btn-sm" id="btn-save"><i class="fa fa-floppy-o"></i> Save</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
</div>
<div class="box-body" >
    <div class="nav-tabs-custom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs primary">
                @include('user::admin.users.partial.tabs')
        </ul>
        {!!Former::vertical_open()
        ->id('create-user-user')
        ->method('POST')
        ->files('true')
        ->action(URL::to('admin/user/user'))!!}
        <div class="tab-content">
                @include('user::admin.users.partial.entry')
        </div>
    {!! Former::close() !!}
    </div>
</div>
<div class="box-footer" >
    &nbsp;
</div>
<script type="text/javascript">
(function ($) {
    $('#btn-save').click(function(){
        $('#create-user-user').submit();
    });
    $('#btn-cancel').click(function(){
        $('#entry-user').load('{{URL::to('admin/user/user/0')}}');
    });
    $('#create-user-user')
    .submit( function( e ) {
        if($('#create-user-user').valid() == false) {
            toastr.error('Unprocessable entry.', 'Warning');
            return false;
        }
        var url  = $(this).attr('action');
        var formData = new FormData( this );

        $.ajax( {
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend:function()
            {
            },
            success:function(data, textStatus, jqXHR)
            {
                $('#main-list').DataTable().ajax.reload( null, false );
                $('#entry-user').load('{{URL::to('admin/user/user')}}/' + data.id);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });
        e.preventDefault();
    });
}(jQuery));
</script>