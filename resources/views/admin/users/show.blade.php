<div class="box-header with-border">
    <h3 class="box-title"> View User  [{!!$user->first_name or 'New' !!}]  </h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-primary btn-sm" id="btnNew"><i class="fa fa-plus-circle"></i> New</button>
        @if($user->id)
        <button type="button" class="btn btn-primary btn-sm" id="btnEdit"><i class="fa fa-pencil-square"></i> Edit</button>
        @endif
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
$(document).ready(function(){
    $("input, select, textarea").attr('disabled', 'disabled');
    $('#btnNew').click(function(){
        $('#entry').load('{{URL::to('admin/user/user/create')}}', function( response, status, xhr ) {
        if ( status == "error" ) {
            toastr.error(xhr.status + " " + xhr.statusText, 'Error');
        }
        });
    });
    @if($user->id)
    toastr.info('One item opened.', 'Info');
    $('#btnEdit').click(function(){
        $('#entry').load('{{URL::to('admin/user/user')}}/{{$user->id}}/edit');
    });
    @endif
});
</script>