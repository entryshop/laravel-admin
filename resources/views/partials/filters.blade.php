<div class="collapse" id="{{$id}}_filters" data-bs-transition="false">
    <div class="filter-container">
        <div id="filterRows">
            <!-- filter rows will be added here -->
        </div>
        <div class="d-flex justify-content-between mt-2">
            <div class="d-flex">
                <div class="input-group">
                    <select class="form-select" name="add-filter">
                        @foreach($_this->filters()??[] as $filter)
                            <option value="{{$filter->name()}}">{{$filter->label()}}</option>
                        @endforeach
                    </select>
                    <button id="addFilter" class="flex-shrink-0 btn btn-outline-primary">
                        <i class="ri-add-line"></i> @lang('admin::base.add')
                    </button>
                </div>
            </div>
            <div class="d-flex gap-3">
                <button id="resetFilters" class="btn btn-light">@lang('admin::base.reset')</button>
                <button id="applyFilters" class="btn btn-primary">@lang('admin::base.apply')</button>
            </div>
        </div>
    </div>
    <form action="{{request()->fullUrl()}}" class="filters">
        <input type="hidden" name="filter">
    </form>
</div>

@pushonce('styles')
    <style nonce="{{admin()->csp()}}">

        .filter-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .filter-container {
            padding: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        table td {
            vertical-align: middle;
        }

        .filter-label {
            min-width: 60px;
        }
    </style>
@endpushonce

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $(document).ready(function () {
            const fields = [
                    @foreach($filters ?? [] as $filter)
                {
                    'name': '{{$filter->name()}}',
                    'label': "{{$filter->label()}}",
                    'operators': @json($filter->operators()),
                },
                @endforeach
            ]

            function createFilterRow(filter) {

                if (!filter) {
                    filter = {};
                }

                let add_filter_name = filter.field || $('select[name="add-filter"]').val();
                const field = fields.find(f => f.name === add_filter_name);

                const row = $('<div>').addClass('filter-row').attr('data-name', add_filter_name);

                // Delete button
                const deleteBtn = $('<button>')
                    .addClass('btn btn-outline-danger')
                    .html('<i class="ri-delete-bin-line"></i>')
                    .click(function () {
                        $(this).closest('.filter-row').remove();
                    });

                // Field select
                const fieldSelect = $('<span>').addClass('flex-shrink-0 filter-label').html(field.label);

                // Operator select
                const operatorSelect = $('<select>')
                    .addClass('form-select')
                    .css('width', '200px');
                field.operators.forEach(op => {
                    let operator_option = $('<option>').text(op.label).val(op.name);
                    if (filter.operator === op.name) {
                        operator_option.prop('selected', true);
                    }
                    operatorSelect.append(operator_option);
                });

                // Value input
                const valueInput = $('<input>')
                    .addClass('form-control')
                    .attr('type', 'text')
                    .css('width', '200px');

                if (filter.value) {
                    valueInput.val(filter.value);
                }

                row.append(fieldSelect, operatorSelect, valueInput, deleteBtn);
                return row;
            }

            $('#addFilter').click(function () {
                $('#filterRows').append(createFilterRow());
            });

            $('#resetFilters').click(function () {
                $('form.filters [name=filter]').val('');
                $('form.filters').submit();
            });

            $('#applyFilters').click(function () {
                const filters = [];
                $('.filter-row').each(function () {
                    const row = $(this);
                    filters.push({
                        field: row.data('name'),
                        operator: row.find('select').eq(0).val(),
                        value: row.find('input').val()
                    });
                });
                $('form.filters [name=filter]').val(JSON.stringify(filters));
                $('form.filters').submit();
            });

            @if(request('filter'))
            @php
                $filters = to_json(request('filter'));
            @endphp
            @if(!empty($filters))
            $('#{{$id}}_filters').collapse();
            const filters = @json(to_json(request('filter')));
            for (const filter of filters) {
                $('#filterRows').append(createFilterRow(filter));
            }
            @endif
            @endif
        });
    </script>
@endpush
