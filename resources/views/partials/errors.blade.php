<!--  errors -->
@if(!empty($errors) && $errors->any())
    <div class="alert alert-danger">
        <div class="d-flex flex-column">
            @foreach ($errors->all() as $error)
                <span>{!! $error !!}</span>
            @endforeach
        </div>
    </div>
@endif
