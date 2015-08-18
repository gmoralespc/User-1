<div class="box-header with-border">
    <h3 class="box-title"> Edit  role [{!!$role->name!!}] </h3>
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
            <li class="active"><a href="#details" data-toggle="tab">Role</a></li>
        </ul>
        {!!Former::vertical_open()
        ->id('formEntry')
        ->method('PUT')
        ->enctype('multipart/form-data')
        ->action(URL::to('admin/user/role/'. $role['id']))!!}
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
        {!!Former::close()!!}
    </div>
</div>
<div class="box-footer" >
    &nbsp;
</div>
<script type="text/javascript">
        (function ($) {
            $('#btnClose').click(function(){
                $('#entry').load('{{URL::to('admin/user/role')}/{{$role->id}}');
            });
            $('#btnSave').click(function(){
                $('#formEntry').submit();
            });
            $('#formEntry')
            .submit( function( e ) {
                var formURL  = "{{ URL::to('admin/user/role/')}}/{{@$role->id}}";
                $.ajax( {
                    url: formURL,
                    type: 'POST',
                    data: new FormData( this ),
                    processData: false,
                    contentType: false,
                    success:function(data, textStatus, jqXHR)
                    {
                        toastr.success('{Role} updated successfuly.', 'Success');
                        $('#entry').load('{{URL::to('admin/user/role')}/{{$role->id}}');
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