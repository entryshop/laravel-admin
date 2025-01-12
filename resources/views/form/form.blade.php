<form action="{{$_this->action()}}" id="{{$_this->id()}}"
      {!! $_this->attributes !!}
      method="{{$_this->method() === 'get' ? 'get' : 'post'}}"
      enctype="multipart/form-data">
    @include('admin::partials.errors')
    <div class="errors d-none alert alert-danger"></div>
    @if($_this->method() !== 'get')
        @method($_this->method())
        @csrf
    @endif
    <div
        @if($_this->flex())
            class="d-flex gap-3 flex-wrap"
        @endif

        @if($_this->row())
            class="row gap-3"
        @endif
    >
        @foreach($_this->fields() ?? []  as $field)
            @if(empty($field))
                @dump($field)
            @endif
            @php
                $field->withAttributes(['class'=>'form-control']);
                if($model = $_this->model()) {
                    $field->model($model);
                }
            @endphp
            <div @if($field->full()) class="w-full col-12" @endif>
                @if(!$_this->get('hideLabel', false))
                    <label class="form-label" for="{{$field->id()}}">{{$field->label()}}</label>
                @endif
                <div>
                    {!! render($field) !!}
                </div>
            </div>
        @endforeach
    </div>
    @if($_this->hideSubmitButton() !== true)
        <div class="mt-3">
            {!! render($_this->submitButton()) !!}
        </div>
    @endif
</form>
