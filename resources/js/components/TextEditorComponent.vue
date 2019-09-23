<template>
    <div>
        <h1>Email Analysis Report</h1>
        <form action="javascript:void(0)">
          <div class="form-group">
            <label for="exampleInputEmail1">Email Subject</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Subject" v-model="subject">
            <small id="emailHelp" class="form-text text-muted">Subject of email should be relative.</small>
          </div>
          <tinymce-editor api-key="9chzhvjvxuayuknsvnv46z8hikbbnoal9t5fff853edk9kz8" :init="{plugins: 'wordcount'}" v-model="discription"></tinymce-editor>
          <div class="form-group">
            <h4>Subject Length {{ subjectLength }}</h4>
            <h4>Description word count {{ descriptionWordCount }}</h4>
            <h4>Question word count {{ questionWordCount }}</h4>
            <h4>Spam word count {{ spamWordCount }}</h4>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    var Editor = require('@tinymce/tinymce-vue').default;
    export default {
        components: {
            'tinymce-editor': Editor
          },
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
              subject:"",
              discription:"",
              spams:['abc','bcd','cde','def','efg']
            }
        },
        computed: {
            subjectLength: function () {
              // `this` points to the vm instance
              return this.subject.length
            },
            descriptionWordCount: function (){
                let descriptionCount = this.discription.trim();
                // descriptionCount = this.descriptionCount.replace(/\r?\n|\r/g," ");
                if(descriptionCount.length==0){
                    return descriptionCount.split(' ').length - 1
                }
              return descriptionCount.split(' ').length
            },
            questionWordCount: function () {
              return this.discription.split('?').length - 1
            },
            spamWordCount: function () {
                let currentDescription = this.discription.replace(/\r?\n|\r/g," ");
                
                var temporalDivElement = document.createElement("div");
                // Set the HTML content with the providen
                temporalDivElement.innerHTML = currentDescription;
                // Retrieve the text property of the element (cross-browser support)
                currentDescription = temporalDivElement.textContent || temporalDivElement.innerText || "";

                let currentDescriptionArray = currentDescription.split(" ");
                console.log(currentDescriptionArray);
                let spams = ['Hello','Hi','Where',"?"]
                //console.log(arrayL)
                //const result = words.filter(word => word == 'limit');
                const resultMatch = [];
                var spamCount = 0;
                for(let i=0;i<spams.length;i++){
                    let out = currentDescriptionArray.filter(word => word == spams[i]);
                    if (out.length > 0) {
                        spamCount = spamCount + out.length
                    }
                    
                    //console.log(spams[i]);
                    //console.log(out);
                }
                return spamCount;
                //console.log(resultMatch);
            }
        }
    }
</script>
