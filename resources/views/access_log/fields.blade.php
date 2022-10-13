<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fullname', 'Nama Lengkap:') !!}
    {!! Form::text('fullname', null, ['class' => 'form-control', 'maxlength' => 50, 'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('ktp_number', 'No KTP:') !!}
    {!! Form::text('ktp_number', null, ['class' => 'form-control', 'maxlength' => 50,'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('birth_place', 'Tempat Lahir:') !!}
    {!! Form::text('birth_place', null, ['class' => 'form-control', 'maxlength' => 50, 'required' => true]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('birth_date', 'Tanggal Lahir:') !!}
    {!! Form::text('birth_date', null, ['class' => 'form-control', 'id'=>'datepicker','maxlength' => 50, 'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'id'=>'datepicker','maxlength' => 12, 'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'No. Telp:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'id'=>'datepicker','maxlength' => 12, 'required' => true]) !!}
</div>
<div class="row col-sm-12">
<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Jenis Kelamin:') !!}
    {!! Form::select('gender', ['L' => 'Laki-laki','P'=> 'Perempuan'], null, ['class' => 'form-control', 'required' => true]) !!}
</div>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Alamat:') !!}
    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3, 'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('family', 'Keluarga Dekat/Kerabat :') !!}
    {!! Form::textarea('family', null, ['class' => 'form-control', 'rows' => 3, 'required' => true]) !!}
</div>
<!--
<div class="box-header with-border">
<h3 class="box-title">Tambah Data</h3>
</div>
-->

<!-- News Category Id Field -->


<!-- Photo Field -->


<div class="form-group col-sm-8" >

    <!--{!! Form::file('photo', null, ['class' => 'form-control']) !!}-->
    <!-- This wraps the whole cropper -->
  
   
    <div class="photo-list2">
          <div class="photo-item2">
            @if (isset($photo[0]))
                <img src="{{ url('attachments/products/' . $photo[0]) }}" class="photo" />
            @else
                <img src="" class="photo" />
            @endif
            <span>+</span>
        </div>
        <div class="photo-item2">
            @if (isset($photo[0]))
                <img src="{{ url('attachments/products/' . $photo[0]) }}" class="photo" />
            @else
                <img src="" class="photo" />
            @endif
            <span>+</span>
        </div>
        <div class="photo-item2">
            @if (isset($photo[1]))
                <img src="{{ url('attachments/products/' . $photo[1]) }}" class="photo" />
            @else
                <img src="" class="photo" />
            @endif
            <span>+</span>
        </div>
        <div class="photo-item2">
            @if (isset($photo[1]))
                <img src="{{ url('attachments/products/' . $photo[1]) }}" class="photo" />
            @else
                <img src="" class="photo" />
            @endif
            <span>+</span>
        </div>  
    </div>
      <div class="file-upload">
        <input type="file" name="photo_1" class="picker" />
        <input type="file" name="photo_2" class="picker" />
        <input type="file" name="photo_3" class="picker" />
        <input type="file" name="photo_4" class="picker" />
    </div>
</div>
<div class="form-group col-sm-4" >
    <label>
   <p style="color:red;"> Petunjuk Upload </p>
        1. Foto Profile <br>
        2. Foto KTP <br>
        3. Foto KK  <br>
        4. Foto Sertifikat <br>
    </label>           
</div>

  
</div>
<div class="form-group col-sm-6">
         {!! Form::label('kategori_layanan', 'Kategori Layanan :') !!}


               {!! Form::select('category_id[]', $categories, null, ['class' => 'form-control select2','multiple'=>'multiple', 'required' => true]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area:') !!}
    {!! Form::select('area_id', $area, null, ['class' => 'form-control', 'required' => true, 'placeholder' => '-- Choose one --']) !!}
</div>
<!-- Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password_confirmation', 'Password Confirmation:') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', ['member' => 'customer','sales'=> 'sales', 'mechanic'=>'mechanic','admin' => 'admin'], null, ['class' => 'form-control', 'required' => true, 'placeholder' => '--Choose one--']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary cropit-trigger']) !!}
    <a href="{!! route('tukang.index') !!}" class="btn  btn-default">Cancel</a>
</div>
