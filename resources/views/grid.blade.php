<div class="card">
    <div class="card-header">
        <!-- search form -->
        <div class="search-form">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-1">
                    @if($_this->get('filters', null))
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{$_this->id()}}_filters" aria-expanded="false"
                                aria-controls="filters">
                            <i class="ri-filter-line"></i>
                        </button>
                    @endif
                    @if($search_form = $_this->get('search_form'))
                        {{render($search_form)}}
                    @endif
                </div>
                <div>
                    @foreach($_this->tools()??[] as $tool)
                        {!! render($tool) !!}
                    @endforeach
                </div>
            </div>
            @if($_this->get('filters', null))
                <div class="collapse mt-3" id="{{$_this->id()}}_filters">
                    <div class="filter-container">
                        <div id="filterRows">
                            <!-- filter rows will be added here -->
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-1">
                                <select class="form-select" name="add-filter">
                                    @foreach($_this->filters()??[] as $filter)
                                        <option value="{{$filter->name()}}">{{$filter->label()}}</option>
                                    @endforeach
                                </select>
                                <button id="addFilter" class="flex-shrink-0 btn btn-light">
                                    + @lang('admin::base.add')</button>
                            </div>
                            <div class="d-flex gap-3">
                                <button id="resetFilters" class="btn btn-light">@lang('admin::base.reset')</button>
                                <button id="applyFilters" class="btn btn-primary">@lang('admin::base.apply')</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="batch-actions hidden">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @foreach($_this->batch()??[] as $action)
                        {!! render($action->withAttributes(['data-table' => $_this->table()->id()])) !!}
                    @endforeach
                </div>
                <div>
                    取消选择
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($table = $_this->get('table'))
            <div class="table-responsive">
                {{render($table)}}
            </div>
        @endif
        {!! $_this->models()->links() !!}
    </div>
</div>

@push('styles')
    <style nonce="{{admin()->csp()}}">
        .hidden {
            display: none;
        }

        .filter-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .filter-container {
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
    </style>
@endpush

@push('scripts')
    <script nonce="{{admin()->csp()}}">

        $('#{{$_this->table()->id()}}').on('selectedRowsChanged', function (e, count) {
            if (count) {
                $('.batch-actions').show();
                $('.search-form').hide();
            } else {
                $('.batch-actions').hide();
                $('.search-form').show();
            }
        });

        $(document).ready(function () {

            const fields = [
                    @foreach($_this->filters()??[] as $filter)
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
                const fieldSelect = $('<span>').addClass('flex-shrink-0').html(field.label);

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
                let params = new URLSearchParams(window.location.search);
                params.set('filter', '');
                window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                window.location.search = params;
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

                let params = new URLSearchParams(window.location.search);
                params.set('filter', JSON.stringify(filters));
                window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                window.location.search = params;
            });

            @if(request('filter'))
            @php
                $filters = to_json(request('filter'));
            @endphp
            @if(!empty($filters))
            const bsCollapse = new bootstrap.Collapse('#{{$_this->id()}}_filters', {
                show: true, animation: false
            });
            const filters = @json(to_json(request('filter')));

            for (const filter of filters) {
                $('#filterRows').append(createFilterRow(filter));
            }
            @endif
            @endif
        });
    </script>
@endpush
