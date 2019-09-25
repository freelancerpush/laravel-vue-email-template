<template>
  <div>
    <h2>Add Email Template</h2>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" name="name" required v-model="newItem.name" placeholder=" Enter some name">
    </div>
    <div class="form-group">
      <label for="subject">Subject:</label>
      <input type="text" class="form-control" id="subject" name="subject" required v-model="newItem.subject" placeholder=" Enter your subject">
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" v-model="newItem.description" id="description" name="description"></tinymce-editor>
    </div>

    <button class="btn btn-primary" @click.prevent="createItem()" id="name" name="name">
      <span class="glyphicon glyphicon-plus"></span> ADD
    </button>
    <p class="text-center alert alert-danger" v-bind:class="{ hidden: hasError }">Please fill all fields!</p>
    <p class="text-center alert alert-success" v-bind:class="{ hidden: hasDeleted }">Deleted Successfully!</p>
    <div class="form-group">
      <h4>Subject Length {{ subjectLength }}</h4>
      <h4>Description word count {{ descriptionWordCount }}</h4>
      <h4>Question word count {{ questionWordCount }}</h4>
      <h4>Spam word count {{ spamWordCount['count'] }}</h4>
      <h4>Spam word used {{ spamWordCount['word'] }}</h4>
    </div>
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
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.subject }}</td>
          <td>{{ html2text(item.description) }}</td>
          <td id="show-modal" @click="showModal=true; setVal(item.id, item.name, item.subject, item.description)"  class="btn btn-info" >
            <span class="glyphicon glyphicon-pencil"></span>
          </td>&nbsp;&nbsp;&nbsp;
          <td @click.prevent="deleteItem(item)" class="btn btn-danger">
            <span class="glyphicon glyphicon-trash"></span>
          </td>
        </tr>
      </table>
    </div>
    <modal v-if="showModal" @close="showModal=false">
      <h3 slot="header">Edit Item</h3>
      <div slot="body">
        <input type="hidden" disabled class="form-control" id="eId" name="id" required  :value="this.eId">
        Name: <input type="text" class="form-control" id="eName" name="name" required  :value="this.eName">
        Subject: <input type="text" class="form-control" id="eSubject" name="subject" required  :value="this.eSubject">
        Description: <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" :value="this.eDescription" id="eDescription" name="description"></tinymce-editor>
      </div>
      <div slot="footer">
        <button class="btn btn-default" @click="showModal = false">Cancel</button>&nbsp;
        <button class="btn btn-info" @click="editItem()">Update</button>
      </div>
    </modal>
  </div>
</template>
<script>
  var Editor = require('@tinymce/tinymce-vue').default;
  export default {
    components: {
        'tinymce-editor': Editor
      },
    mounted: function() {
      this.getItems();
      this.getSpams();
    },
    data: function() {
      return {
        items: [],
        spamItems: [],
        hasError: true,
        hasDeleted: true,
        hasSubjectError: true,
        showModal: false,
        optionEmailSubject:'',
        selectedTemplateName:'',
        selectedTemplateSubject:'',
        selectedTemplateDescription:'',
        eName: '',
        eSubject: '',
        eId: '',
        eDescription: '',
        newItem: { 'name': '','subject': '','description': '' },
        usedSpamWord:'',
      };
    },
    computed: {
    },
    methods: {
      getItems: function() {
        var thisItme = this;
        axios.get('/items').then(function (response) {
          thisItme.items = response.data;
        });
      },
      getSpams: function() {
        var thisSpam = this;
        axios.get('/spam-items').then(function (response) {
          thisSpam.spamItems = response.data;
        });
      },
      setVal: function(valId, valName, valSubject, valDescription) {
        this.eId = valId;
        this.eName = valName;
        this.eSubject = valSubject;
        this.eDescription = valDescription;
      },
      createItem: function() {
        var thisCreate = this
        var input = thisCreate.newItem;
        if (input['name'] == '' || input['subject'] == '' || input['description'] == '' ) {
          thisCreate.hasError = false;
        }else{
          thisCreate.hasError = true;
          axios.post('/items', input).then(function (response) {
            thisCreate.newItem = { 'name': '', 'subject': '', 'description': '' };
            thisCreate.getItems();
          });
          thisCreate.hasDeleted = true;
        }
      },
      editItem: function(){
        var iVal1 = document.getElementById('eId');
        var nVal1 = document.getElementById('eName');
        var sVal1 = document.getElementById('eSubject');
        var dVal1 = tinyMCE.get('eDescription').getContent();
        console.log(iVal1);
        axios.post('/edit-items/' + iVal1.value, {val1: nVal1.value, val2: sVal1.value,val3: dVal1 })
          .then(response => {
            this.getItems();
            this.showModal=false
          });
        this.hasDeleted = true;
      },
      deleteItem: function(item) {
        var thisDelete = this;
        axios.post('/items/' + item.id).then(function (response) {
          thisDelete.getItems();
          thisDelete.hasError = true, 
          thisDelete.hasDeleted = false
        });
      },
      selectedItem: function(item) {
        var thisSelected = this;
        var selectedTemplate =  thisSelected.items.filter(function(item) {
          return item.id == thisSelected.optionEmailSubject;
        });
        thisSelected.selectedTemplateName = selectedTemplate[0].name;
        thisSelected.selectedTemplateSubject = selectedTemplate[0].subject;
        thisSelected.selectedTemplateDescription = selectedTemplate[0].description;

      },
      html2text:function(html) {
        var tag = document.createElement('div');
        tag.innerHTML = html;
        return tag.textContent || tag.innerText || "";;
      },
      ltrim:function(str) {
        if(str == null) return str;
        return str.replace(/^\s+/g, '');
      }
    },
    computed: {
      subjectLength: function () {
        return this.newItem.subject.length
      },
      descriptionWordCount: function (){
        let descriptionCount = this.newItem.description.trim();
        descriptionCount = this.html2text(descriptionCount);
        if(descriptionCount.length==0){
          return descriptionCount.split(' ').length - 1
        }
        return descriptionCount.split(' ').length
      },
      questionWordCount: function () {
        return this.newItem.description.split('?').length - 1
      },
      spamWordCount: function () {
        let currentDescription = this.newItem.description.trim();
        currentDescription = currentDescription.replace(/\r?\n|\r/g," ");
        currentDescription = this.html2text(currentDescription);
        currentDescription = this.ltrim(currentDescription);
        let currentDescriptionArray = currentDescription.split(" ");
        //var spamCount = 0;
        var spamCal = []
        spamCal['count'] = 0
        spamCal['word'] = []
        for(let i=0;i<this.spamItems.length;i++){
          let out = currentDescriptionArray.filter(word => word.toUpperCase().trim() == this.spamItems[i].toUpperCase());
          if (out.length > 0) {
            //spamCount = spamCount + out.length
            spamCal['count'] = spamCal['count'] + out.length
            //spamCal['word'] = out[0]
            spamCal['word'].push(out[0]);
          }
        }
        return spamCal;
      }
    },
  }
</script>