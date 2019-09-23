@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Template</h4><span class="float-right"><a href="list_template"><i class="fa fa-list" aria-hidden="true"></i></a></span></div>
                <div class="card-body">
                    {{ Form::open(array('url' => 'edit_template')) }}
                        <input type="hidden" name="id" value="{{ $template->id }}">
                        <input type="text" name="name" value="{{ $template->name }}">
                        <input type="text" name="subject" value="{{ $template->subject }}">
                        <textarea name="content">{{ $template->content }}</textarea>
                        <input type="submit" value="Save">
                    {{ Form::close() }}
                    <script src="{{ asset('js/tinymce.min.js') }}"></script>
                    <link rel="stylesheet" type="text/css" href="{{ asset('skin.min.css') }}">
                    <script type="text/javascript">
                        tinymce.init({
                            selector: 'textarea',
                            plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste tinycomments tinydrive tinymcespellchecker',
                            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter insertfile pageembed permanentpen',
                            toolbar_drawer: 'floating',
                            tinycomments_mode: 'embedded',
                        });
                    </script>
                    <span class="errors">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection