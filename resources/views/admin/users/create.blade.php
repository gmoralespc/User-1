<div class="box-header with-border">
    <h3 class="box-title"> New User </h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-primary btn-sm" id="btnSave"><i class="fa fa-floppy-o"></i> Save</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="btnCancel"><i class="fa fa-times-circle"></i> Cancel</button>
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
        ->method('POST')
        ->files('true')
        ->action(URL::to('admin/user/user'))!!}
        <div class="tab-content">
          @include('user::admin.users.partials.contents')
        </div>
    </div>
    {!! Former::close() !!}
</div>
<div class="box-footer" >
    &nbsp;
</div>
<script type="text/javascript">
(function ($) {
    $('#btnSave').click(function(){
        $('#formEntry').submit();
    });
    $('#btnCancel').click(function(){
        $('#entry').load('{{URL::to('admin/user/user/0')}}');
    });
    $('#formEntry')
    .submit( function( e ) {
        if($('#formEntry').valid() == false) {
            toastr.error('Please enter valid information.', 'Error');
            return;
        }
        $.ajax( {
            url: "{{ URL::to('admin/user/user')}}",
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success:function(data, textStatus, jqXHR)
            {
                toastr.success(data.message, 'Success');
                $('#main_list').DataTable().ajax.reload( null, false );
                $('#entry').load('{{URL::to('admin/user')}}/' + data.id);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                toastr.error(data.message, 'Error');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
        e.preventDefault();
    });
}(jQuery));
</script>