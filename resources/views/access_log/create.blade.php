@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Data Diri Tukang
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'tukang.store','files' => true]) !!}

                        @include('tukang.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getImagePreview(input, $image) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $image.attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        var $photoItem = $('.photo-item2');
        var $fileInput = $('input:file');

        $photoItem.find('.photo').css({ display: 'none' });

        $photoItem.on('click', function (event) {
            var index = $(this).index('.photo-item2');
            $fileInput.eq(index).click();
        });

        $fileInput.on('change', function () {
            var index = $(this).index('.picker');
            var $image = $photoItem.eq(index).find('img');
            var $plus = $photoItem.eq(index).find('span');
            var $photo = $photoItem.eq(index).find('.photo');

            getImagePreview(this, $image);
            $plus.css({ display: 'none' });
            $photo.css({ display: 'inline' });
        });

    </script>
@endsection
