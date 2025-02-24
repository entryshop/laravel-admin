<table {!! $_this->getAttributes()->merge(['class' => 'table table-hover mb-0']) !!} id="{{$_this->id()}}">
    <thead>
    @if($_this->selectable())
        <th>
            <input class="form-check-input check-all" type="checkbox">
        </th>
    @endif
    @foreach($_this->get('columns')??[] as $column)
        <th>
            @if($column->sortable())
                @include('admin::table.partials.sort-column', ['label' => $column->label(), 'name' => $column->name()])
            @else
                {!! $column->label() !!}
            @endif
        </th>
    @endforeach
    </thead>
    <tbody>
    @foreach($_this->get('models') as $model)
        <tr>
            @if($_this->selectable())
                <td>
                    <input class="form-check-input check" type="checkbox" data-id="{{data_get($model, 'id')}}">
                </td>
            @endif
            @foreach($_this->get('columns')??[] as $column)
                <td>{!! $column->model($model)->render() !!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $('#{{$_this->id()}} .check-all').on('change', function () {
            $('#{{$_this->id()}} .check').prop('checked', $(this).prop('checked'));
            updateSelectedRows();
        });

        $('#{{$_this->id()}} .check').on('change', function () {
            updateSelectedRows();
        });

        function updateSelectedRows() {
            $('#{{$_this->id()}}').trigger('selectedRowsChanged', [$('#{{$_this->id()}} .check:checked').length]);
        }
    </script>
@endpush
