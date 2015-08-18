<div class="box-header with-border">
    <h3 class="box-title"> New Role </h3>
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
            <li class="active"><a href="#details" data-toggle="tab">Role</a></li>
        </ul>
        {!!Former::vertical_open()
        ->id('formEntry')
        ->method('POST')
        ->files('true')
        ->action(URL::to('admin/user/role'))!!}
        <div class="tab-content">
            <div class="tab-pane active" id="details">
                  <div class="row">

               <div class='col-md-4 col-sm-6'>{!! Former::text('name')
               -> label(trans('user::role.label.name'))
               -> placeholder(trans('user::role.placeholder.name'))!!}
               </div>
        </div>
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
    $('#btnSave').click(function(){
        $('#formEntry').submit();
    });
    $('#btnCancel').click(function(){
        $('#entry').load('{{URL::to('admin/user/role/0')}}');
    });
    $('#formEntry')
    .submit( function( e ) {
        if($('#formEntry').valid() == false) {
            toastr.error('Please enter valid information.', 'Error');
            return;
        }

        $.ajax( {
            url: "{{ URL::to('admin/user/role')}}",
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success:function(data, textStatus, jqXHR)
            {
                toastr.success(data.message, 'Success');
                $('#main_list').DataTable().ajax.reload( null, false );
                $('#entry').load('{{URL::to('admin/user/role')}}/' + data.id);
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