<div class="box-header with-border">
    <h3 class="box-title"> New Permission </h3>
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
            <li class="active"><a href="#details" data-toggle="tab">Permission</a></li>
        </ul>
        {!!Former::vertical_open()
        ->id('create-user-permission')
        ->method('POST')
        ->files('true')
        ->action(URL::to('admin/user/permission'))!!}
        <div class="tab-content">
            <div class="tab-pane active" id="details">
                @include('user::admin.permission.partial.entry')
            </div>
        </div>
    </div>
    {!! Former::close() !!}
</div>
<div class="box-footer" >
    &nbsp;
</div>
<script type="text/javascript">
(function ($) {
    $('#btn-save').click(function(){
        $('#create-user-permission').submit();
    });
    $('#btn-cancel').click(function(){
        $('#entry-permission').load('{{URL::to('admin/user/permission/0')}}');
    });
    $('#create-user-permission')
    .submit( function( e ) {
        if($('#create-user-permission').valid() == false) {
            toastr.error('Please enter valid information.', 'Error');
            return;
        }

        $.ajax( {
            url: "{{ URL::to('admin/user/permission')}}",
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success:function(data, textStatus, jqXHR)
            {
                $('#main-list').DataTable().ajax.reload( null, false );
                $('#entry-permission').load('{{URL::to('admin/user/permission')}}/' + data.id);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });
        e.preventDefault();
    });
}(jQuery));
</script>