{!! Form::open(['route' => ['histori_order.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('accesslog.show', $id) }}" class='btn btn-info btn-xs'>
        <i class="far fa-eye"></i> Detail
    </a>
</div>
{!! Form::close() !!}
