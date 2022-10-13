@extends('layouts.app2')

@section('title')
<title>Detail Log - Dashboard Panggil Tukang</title>
@endsection

@section('content')

<div class="content-header">
  <div class="container-fluid">

    <div class="clearfix"></div>
    @include('flash::message')

    <div class="content">
      @include('layouts.button_left_icon', ['route' => "accesslog.index", 'title' => " Kembali ke menu awal",
        'icon' => "fa fa-arrow-left"])

      <div class="row">
        <div class="col-md-4">
          <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
              <h3 class="widget-user-username">{!! $log->user->email !!}</h3>
              <h5 class="widget-user-desc">
                {!! $log->role->role_name !!}
              </h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg"
                alt="User Avatar">
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-12">
                  <strong>Tanggal Akun Dibuat</strong>
                  <p class="text-muted">
                    {!! $log->user->created_at !!}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-network-wired"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Alamat IP</span>
                  <span class='badge badge-success'>{!! $log->IP !!}</span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="far fa-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Akses Tanggal</span>
                  <span class="info-box-number">{!! $log->created_at !!}</span>
                </div>
              </div>
            </div>  
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><b>Detail Akses Log</b></h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p>
                        <b>User-Agent :</b>
                      </p>
                      <p>
                          {!! $log->agent !!} 
                      </p>
                    </div>
                    <div class="col-md-12">
                      <p>
                        <b>Path :</b>
                      </p>
                      <p>
                          {!! $log->path !!} 
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection