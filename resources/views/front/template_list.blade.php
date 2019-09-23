@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Template List</h4><span class="float-right"><a href="create_template"><i class="fa fa-plus" aria-hidden="true"></i></a></span></div>
                <div class="card-body">
                    <table border="1px solid" width="100%" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>
                                    <h5>Template Name</h5>
                                </th>
                                <th>
                                    <h5>Subject</h5>
                                </th>
                                <th>
                                    <h5>View</h5>
                                </th>
                                <th>
                                    <h5>Edit</h5>
                                </th>
                                <th>
                                    <h5>Delete</h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="submit-none">
                        @foreach ($list_template as $template)
                            <tr>
                                <td align="left">{{ $template->name }}</td>
                                <td align="left">{{ $template->subject }}</td>   
                                <td><i class="fa fa-eye" aria-hidden="true" data-id="{{ $template->id }}"></i></td>
                                <td><a href="edit_template?id={{ $template->id }}"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                                <td>
                                    {{ Form::open(array('url' => 'delete_template','id'=>'form-'.$template->id)) }}
                                    <input type="hidden" name="id" value="{{ $template->id }}">
                                    <input type="submit" value="" data-id="{{ $template->id }}" data-name="{{ $template->name }}" data-subject="{{ $template->subject }}"><i class="fa fa-trash delete_template" aria-hidden="true"></i></a>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            <tr class="content-eye content-{{ $template->id }}" id="content-{{ $template->id }}">
                                <td align="left" colspan="5">{{ strip_tags($template->content) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ Form::open(array('url' => 'list_template')) }}
                        
                    {{ Form::close() }}
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