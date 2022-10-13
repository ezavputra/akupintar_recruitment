@section('css')
    @include('layouts.datatables_css2')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' =>'table table-valign-middle table-hover display']) !!}

@section('scripts')
    @include('layouts.datatables_js2')
    {!! $dataTable->scripts() !!}
@endsection