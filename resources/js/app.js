
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var Editor = require('@tinymce/tinymce-vue').default;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('modal', {
  template: '#modal-template'
})

var app = new Vue({
  el: '#vue-wrapper',
  components: {
      'tinymce-editor': Editor, // <- Important part
    },

  data: {
    items: [],
    spamitems: [],
    hasError: true,
    hasDeleted: true,
    hasSubjectError: true,
    showModal: false,
    option_email_subject:'',
    selected_template_name:'',
    selected_template_subject:'',
    selected_template_description:'',
    e_name: '',
    e_subject: '',
    e_id: '',
    e_description: '',
    newItem: { 'name': '','subject': '','description': '' },
   },
  mounted: function mounted() {
    this.getVueItems();
    this.getVueSpams();
  },
  methods: {
    getVueItems: function getVueItems() {
      var _this = this;
      axios.get('/vueitems').then(function (response) {
        _this.items = response.data;
      });
    },
    getVueSpams: function getVueSpams() {
      var _this = this;
      axios.get('/vuespamitems').then(function (response) {
        _this.spamitems = response.data;
      });
    },
    setVal(val_id, val_name, val_subject, val_description) {
        this.e_id = val_id;
        this.e_name = val_name;
        this.e_subject = val_subject;
        this.e_description = val_description;
    },

    createItem: function createItem() {
      var _this = this;
      var input = this.newItem;
      
      if (input['name'] == '' || input['subject'] == '' || input['description'] == '' ) {
        this.hasError = false;
      } else {
        this.hasError = true;
        axios.post('/vueitems', input).then(function (response) {
          _this.newItem = { 'name': '', 'subject': '', 'description': '' };
          _this.getVueItems();
        });
        this.hasDeleted = true;
      }
    },
    editItem: function(){
         var i_val_1 = document.getElementById('e_id');
         var n_val_1 = document.getElementById('e_name');
         var s_val_1 = document.getElementById('e_subject');
         //var d_val_1 = document.getElementById('e_description');
         var d_val_1 = tinyMCE.get('e_description').getContent();
         console.log(d_val_1);

          axios.post('/edititems/' + i_val_1.value, {val_1: n_val_1.value, val_2: s_val_1.value,val_3: d_val_1 })
            .then(response => {
              this.getVueItems();
              this.showModal=false
            });
          this.hasDeleted = true;
    },
    deleteItem: function deleteItem(item) {
      var _this = this;
      axios.post('/vueitems/' + item.id).then(function (response) {
        _this.getVueItems();
        _this.hasError = true, 
        _this.hasDeleted = false
        
      });
    },
    selectedItem: function selectedItem(item) {
      var _this = this;
      var selectedTemplate =  _this.items.filter(function(item) {
        return item.id == _this.option_email_subject;
      });
      debugger;
      _this.selected_template_name = selectedTemplate[0].name;
      _this.selected_template_subject = selectedTemplate[0].subject;
      _this.selected_template_description = selectedTemplate[0].description;

    },
    html2text:function html2text(html) {
      var tag = document.createElement('div');
      tag.innerHTML = html;
      return tag.textContent || tag.innerText || "";;
    }
  },
  computed: {
      subjectLength: function () {
        // `this` points to the vm instance
        return this.selected_template_subject.length
      },
      descriptionWordCount: function (){
          let descriptionCount = this.selected_template_description.trim();
          if(descriptionCount.length==0){
              return descriptionCount.split(' ').length - 1
          }
        return descriptionCount.split(' ').length
      },
      questionWordCount: function () {
        return this.selected_template_description.split('?').length - 1
      },
      spamWordCount: function () {
          let currentDescription = this.selected_template_description.replace(/\r?\n|\r/g," ");
          currentDescription = this.html2text(currentDescription);

          let currentDescriptionArray = currentDescription.split(" ");

          const resultMatch = [];
          var spamCount = 0;
          for(let i=0;i<this.spamitems.length;i++){
              let out = currentDescriptionArray.filter(word => word == this.spamitems[i]);
              if (out.length > 0) {
                  spamCount = spamCount + out.length
              }
          }
          return spamCount;
      }
  }
});