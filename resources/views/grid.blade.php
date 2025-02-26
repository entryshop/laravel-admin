<div class="card" id="{{$_this->id()}}">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center search-form">
            <div class="header-left d-flex gap-1 align-items-center">
                <span class="card-title">
                    {!! $_this->title()  !!}
                </span>
                <form class="d-flex gap-3">
                    @if($_this->get('filters', null))
                        <button class="btn btn-primary position-relative" type="button" data-bs-toggle="collapse"
                                data-bs-transition="false"
                                data-bs-target="#{{$_this->id()}}_filters" aria-expanded="false"
                                aria-controls="filters">
                            <i class="ri-filter-line"></i>
                            @if(!empty(request('filter')) && $filter_count = count(to_json(request('filter'))))
                                <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                {{$filter_count}}
                            </span>
                            @endif
                        </button>
                    @endif
                    @if($_this->searches())
                        <div class="search-box">
                            <input type="text" name="search" value="{{request('search')}}" class="form-control"
                                   placeholder="@lang('admin::base.search')...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    @endif
                </form>
            </div>
            <div class="header-right d-flex gap-1 align-items-center">
                {!! render($_this->tools()) !!}
            </div>
        </div>
        <div class="batch-actions hidden">
            @foreach($_this->batches()??[] as $batch_action)
                {!! render($batch_action->withAttributes(['data-table' => $_this->table->id()])) !!}
            @endforeach
        </div>
    </div>
    @if($_this->get('filters', null))
        @include('admin::partials.filters', [
            'id' => $_this->id(),
            'filters'  =>$_this->filters(),
        ])
    @endif
    <div class="card-body p-0">
        <div class="table-responsive">
            {!! render($_this->table)  !!}
        </div>
    </div>
    <div class="card-footer pb-0">
        {!! $_this->models->links() !!}
    </div>
</div>

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $('#{{$_this->table->id()}}').on('selectedRowsChanged', function (e, count) {
            console.log(count);
            let batch_actions = $('.batch-actions');
            if (batch_actions.length === 0) {
                return;
            }
            let search_form = $('.search-form');
            if (count) {
                batch_actions.removeClass('hidden');
                search_form.addClass('hidden');
            } else {
                batch_actions.addClass('hidden');
                search_form.removeClass('hidden');
            }
        });
    </script>
@endpush
