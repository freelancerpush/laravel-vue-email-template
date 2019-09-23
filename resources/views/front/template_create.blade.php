<!DOCTYPE html>
<html>
<head>
    <title></title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container" id="app">
        <div class="container">
            <div class="content" >
                <div class="form-group">
                    <select class="form-control" @change="onTemplateChange($event)">
                        <option style="display: none;">Select Template</option>
                        <?php foreach ($templates as $template): ?>
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        <?php endforeach ?>
                    </select>
                </div>
                <email-component></email-component>
            </div>
        </div>
    </div>

</body>
    <script type="text/javascript">
        const spams = JSON.parse('{{ json_encode($spams) }}');
    </script>
    <script typse="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>