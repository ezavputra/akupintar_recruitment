@extends('layouts.app2')

@section('title')
<title>Access Log - Dashboard Panggil Tukang</title>
@endsection

@section('content')

<div class="content">
  <div class="container-fluid">

    <div class="clearfix"></div>
    @include('flash::message')

    <div class="row">
      <div class="col-md-4" id="form_add_pelanggan">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Pencarian Data</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clipboard"></i></span>
                  </div>
                  <input type="text" id="email" class="form-control" placeholder="Email">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clipboard"></i></span>
                  </div>
                  <select class="form-control" id="role" name="role">
                    <option value=''>Pilih Role</option>
                    @foreach ($role as $item)
                      <option value='{!! $item->id !!}'>{!! $item->role_name !!}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group">
                  <label>
                    <input type="checkbox" class="flat-red" id="filterchk"> Filter tanggal
                  </label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clipboard"></i></span>
                  </div>
                  <input type="text" id="rangetanggal" class="form-control" placeholder="Tanggal Order">
                </div>
              </div>
              <div class="col-md-12">
                <button id="caridata" class="btn btn-primary btn-block margin-bottom">
                  <span style="margin-right: 5px"><i class="fa fa-search"></i></span> Cari Data</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="data">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Data Access Log</b></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                {!! Form::open(['route' => 'accesslog.exportlogexcel','files' => true, 'id'=>"form"]) !!}
                  <input type="hidden" id="form_email" name="form_email" value="" />
                  <input type="hidden" id="form_role" name="form_role" value="" />
                  <input type="hidden" id="form_rangetanggal" name="form_rangetanggal" value="" />
                {!! Form::close() !!}
                <button id="export" class="btn btn-success">
                  <i class="far fa-file-excel" style="margin-right: 5px"></i> Export Excel
                </button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                @include('access_log.table')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .dataTables_filter {
    display: none;
  }
</style>
<script>
  $(document).ready(function () {    
      var filterBox = document.getElementById("filterchk");
      var rangetanggal = document.getElementById("rangetanggal");

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      rangetanggal.disabled = true;

      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-blue'
      });

      $('.flat-red').on('ifChecked', function(event){
        rangetanggal.disabled = false;
      });

      $('.flat-red').on('ifUnchecked', function(event){
        rangetanggal.disabled = true;
      });

      $('#export').on('click', function(e){
        var range = "";
        if (!rangetanggal.disabled) {
          range = $('#rangetanggal').val();
        } else {
          range = "";
        }
      
        $("#form_email").val($('#email').val());
        $("#form_role").val($('#role').val());
        $("#form_rangetanggal").val(range);

        $("#form").submit();
      });

      $('#caridata').on('click', function(e){
         window.LaravelDataTables["dataTableBuilder"].draw();
         $("html, body").animate({
            scrollTop: $("#data").offset().top-60
         }, 400);
      });
      
      $('#dataTableBuilder').on('preXhr.dt', function ( e, settings, data ) {
        data.email = $('#email').val();
        data.role = $('#role').val();
        if (!rangetanggal.disabled) {
          data.rangetanggal = $('#rangetanggal').val();
        }     
      });
      
      $('#rangetanggal').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )
    });
</script>
@endsection