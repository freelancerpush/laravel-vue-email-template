<template>
  <div>
    <h2>View counts</h2>
    <div class="form-group">
      <label for="description">Select Template:</label>
      <select v-model="optionEmailSubject" class="form-control" v-on:change="selectedItem">
        <option style="display: none;">Select Template</option>
        <option v-for="item in items" v-bind:value="item.id">
          {{ item.name }}
        </option>
      </select>
    </div>
    <h1>{{ selectedTemplateName }}</h1>
    <div class="form-group">
      <label for="selectedTemplateSubject">Subject:</label>
      <input type="text" class="form-control" id="selectedTemplateSubject" name="selectedTemplateSubject" required v-model="selectedTemplateSubject" placeholder="">
    </div>
    <div class="form-group">
      <label for="selectedTemplateDescription">Description:</label>
      <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: ''}" v-model="selectedTemplateDescription" id="selectedTemplateDescription" name="selectedTemplateDescription"></tinymce-editor>
    </div>
    <div class="form-group">
      <h4>Subject Length {{ subjectLength }}</h4>
      <h4>Description word count {{ descriptionWordCount }}</h4>
      <h4>Question word count {{ questionWordCount }}</h4>
      <h4>Spam word count {{ spamWordCount }}</h4>
    </div>
    <hr/>
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
      };
    },
    computed: {
      subjectLength: function () {
        return this.selectedTemplateSubject.length
      },
      descriptionWordCount: function (){
        let descriptionCount = this.selectedTemplateDescription.trim();
        descriptionCount = this.html2text(descriptionCount);
        if(descriptionCount.length==0){
          return descriptionCount.split(' ').length - 1
        }
        return descriptionCount.split(' ').length
      },
      questionWordCount: function () {
        return this.selectedTemplateDescription.split('?').length - 1
      },
      spamWordCount: function () {
        let currentDescription = this.selectedTemplateDescription.trim();
        currentDescription = currentDescription.replace(/\r?\n|\r/g," ");
        currentDescription = this.html2text(currentDescription);
        currentDescription = this.ltrim(currentDescription);
        let currentDescriptionArray = currentDescription.split(" ");
        var spamCount = 0;
        for(let i=0;i<this.spamItems.length;i++){
          let out = currentDescriptionArray.filter(word => word.toUpperCase().trim() == this.spamItems[i].toUpperCase());
          if (out.length > 0) {
            spamCount = spamCount + out.length
          }
        }
        return spamCount;
      }
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
    }
  }
</script>