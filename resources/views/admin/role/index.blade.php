@extends('admin::curd.index')
@section('heading')
<i class="fa fa-file-text-o"></i> {!! trans('user::role.name') !!} <small> {!! trans('cms.manage') !!} {!! trans('user::role.names') !!}</small>
@stop

@section('title')
{!! trans('user::role.names') !!}
@stop

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{!! URL::to('admin') !!}"><i class="fa fa-dashboard"></i> {!! trans('cms.home') !!} </a></li>
    <li class="active">{!! trans('user::role.names') !!}</li>
</ol>
@stop

@section('entry')
<div class="box box-warning" id='entry'>
</div>
@stop

@section('tools')
@stop

@section('content')
<table id="main_list" class="table table-striped table-bordered">
    <tr>
        <th width="20"><input type="checkbox" name="checkall" id="checkall" class="checkbox" value="all"></th>
        <th>{!! trans('user::role.label.name')!!}</th>
    </tr>
</table>
@stop
@section('script')
<script type="text/javascript">
var oTable;
$(document).ready(function(){
    $('#entry').load('{{URL::to('admin/user/role/0')}}');
    oTable = $('#main_list').dataTable( {
        "ajax": '{{ URL::to('/admin/user/role/list') }}',
        "columns": [
        { "data": "id" },
        { "data": "name" },],
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            $('td:eq(0)', nRow).html( '<input type="checkbox" name="ids[]" id="ids_'+ aData.id +'" class="checkRow" value="'+ aData.id+'">');
        },
        "aoColumnDefs": [
              { 'bSortable': false, 'aTargets': [0] }
           ],
        "order": [[ 1, "asc" ]],
        "roleLength": 50
    });

    $('#main_list tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');

        var d = $('#main_list').DataTable().row( this ).data();

        $('#entry').load('{{URL::to('admin/user/role')}}' + '/' + d.id, function( response, status, xhr ) {
          if ( status == "error" ) {
            toastr.error(xhr.status + " " + xhr.statusText, 'Error');
          }
        });

        if ( $(this).hasClass('selected') ) {
            $("#ids_"+d.id).prop('checked', true);
        } else {
            $("#ids_"+d.id).prop('checked', false);
        }

    });

    $("#checkall").click(function(e){
      $("#main_list :checkbox").prop('checked', $("#checkall").is(':checked'));

      if ($("#checkall").is(':checked')){
        $("#main_list tr").addClass('selected');
        $.each($("#main_list :checkbox"), function(){
          arrayids.push(parseInt($(this).val()));
          id = parseInt($(this).val());
        });
        $('#form-div').load('/role/'+id);

      } else {
        arrayids = [];
        id = 0;
        $("#main_list tr").removeClass('selected');
        $('#form-div').load('/role/0');
      }
    });

    $('#btnDelete').click(function(){
        toastr.warning('Are you shure you want to delete the roles? <br><div class="pull-right"><button type="button" id="confirmDelete" class="btn btn-danger btn-xs">Yes</button> <button type="button" id="btnClose" class="btn btn-danger btn-xs">No</button></div>', 'Delete role(s)!');
    });

});
</script>
@stop

@section('style')
@stop






