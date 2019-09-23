<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel Vue.js Email Template Task</title>
<!-- Fonts -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- Styles -->
</head>
<body>
    <div class="container">
        <div id="vue-wrapper">
            <div class="content">
              <!-- Section for email counting start -->
              <div class="form-group">
                <label for="description">Select Template:</label>
                <select v-model="option_email_subject" class="form-control" v-on:change="selectedItem">
                  <option style="display: none;">Select Template</option>
                  <option v-for="item in items" v-bind:value="item.id">
                    @{{ item.name }}
                  </option>
                </select>
              </div>
              <h1>@{{ selected_template_name }}</h1>
              <div class="form-group">
                <label for="selected_template_subject">Subject:</label>
                <input type="text" class="form-control" id="selected_template_subject" name="selected_template_subject" 
                    required v-model="selected_template_subject" placeholder="">
              </div>
              <div class="form-group">
                <label for="selected_template_description">Description:</label>
                <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" v-model="selected_template_description" id="selected_template_description" name="selected_template_description"></tinymce-editor>
              </div>
              <div class="form-group">
                <h4>Subject Length @{{ subjectLength }}</h4>
                <h4>Description word count @{{ descriptionWordCount }}</h4>
                <h4>Question word count @{{ questionWordCount }}</h4>
                <h4>Spam word count @{{ spamWordCount }}</h4>
              </div>
              <!-- Section for email counting end -->

                <!-- <div class="form-group row"> -->
                    <!-- <div class="col-md-8"> -->
                  <hr/>
                  <h2>Add Email Template</h2>
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" 
                        required v-model="newItem.name" placeholder=" Enter some name">
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" class="form-control" id="subject" name="subject" 
                        required v-model="newItem.subject" placeholder=" Enter your subject">
                  </div>
                  <div class="form-group">
                    <label for="description">Description:</label>
                    <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" v-model="newItem.description" id="description" name="description"></tinymce-editor>
                  </div>

                 <button class="btn btn-primary" @click.prevent="createItem()" id="name" name="name">
                    <span class="glyphicon glyphicon-plus"></span> ADD
                 </button>

                <p class="text-center alert alert-danger"
                    v-bind:class="{ hidden: hasError }">Please fill all fields!</p>
                {{ csrf_field() }}
                <p class="text-center alert alert-success"
                    v-bind:class="{ hidden: hasDeleted }">Deleted Successfully!</p>
                <hr/>
                <h2>Manage Template</h2>
                <div class="table table-borderless" id="table">
                    <table class="table table-borderless" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tr v-for="item in items">
                            <td>@{{ item.id }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.subject }}</td>
                            <td>@{{ html2text(item.description) }}</td>
                            
                            <td id="show-modal" @click="showModal=true; setVal(item.id, item.name, item.subject, item.description)"  class="btn btn-info" ><span
                            class="glyphicon glyphicon-pencil"></span></td>&nbsp;&nbsp;&nbsp;
                            <td @click.prevent="deleteItem(item)" class="btn btn-danger"><span
                                class="glyphicon glyphicon-trash"></span></td>
                        </tr>
                    </table>
                </div>
                <modal v-if="showModal" @close="showModal=false">
                    <h3 slot="header">Edit Item</h3>
                    <div slot="body">
                        
                        <input type="hidden" disabled class="form-control" id="e_id" name="id" required  :value="this.e_id">
                        Name: <input type="text" class="form-control" id="e_name" name="name" required  :value="this.e_name">
                        Subject: <input type="text" class="form-control" id="e_subject" name="subject" required  :value="this.e_subject">
                        Description: <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" :value="this.e_description" id="e_description" name="description"></tinymce-editor>
                    </div>
                    <div slot="footer">
                        <button class="btn btn-default" @click="showModal = false">
                        Cancel
                      </button>&npsp;
                      <button class="btn btn-info" @click="editItem()">
                        Update
                      </button>
                    </div>
                </modal>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/x-template" id="modal-template">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  default header
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                    
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">

                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </script>
</body>
</html>
