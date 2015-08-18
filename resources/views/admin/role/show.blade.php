<div class="box-header with-border">
    <h3 class="box-title"> View Role  [{!!$example->name or 'New' !!}]  </h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-primary btn-sm" id="btnNew"><i class="fa fa-plus-circle"></i> New</button>
        @if($role->id)
        <button type="button" class="btn btn-primary btn-sm" id="btnEdit"><i class="fa fa-pencil-square"></i> Edit</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btnDelete"><i class="fa fa-times-circle"></i> Delete</button>
        @endif
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
$(document).ready(function(){

    $('#btnNew').click(function(){
        $('#entry').load('{{URL::to('admin/user/role/create')}}', function( response, status, xhr ) {
          if ( status == "error" ) {
            toastr.error(xhr.status + " " + xhr.statusText, 'Error');
          }
        });
    });

    @if($role->id)
    toastr.info('One item selected.', 'Info');
    $('#btnEdit').click(function(){
        $('#entry').load('{{URL::to('admin/user/role')}}/{{$role->id}}/edit');
    });
    @endif
});
</script>