var toolbarOptions = {
              container: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                [{ 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],
                [{ 'color': [] }],          // dropdown with defaults from theme
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['emoji'],
                ['clean'],                                        // remove formatting button
                ],
                handlers: {
                        'emoji': function () {}
                    }
                  };
            var quill = new Quill('#editor', {
                    modules: {
                    toolbar: toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": true,
                          "emoji-textarea": true        
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow'  // or 'bubble'
                  });
            $("#toolbar").append($(".ql-toolbar"));
document.getElementById('result').innerHTML = "<h1>Loading...</h1>";
          $.ajax({
            crossOrigin: true,
            url: "server.php",
            type: "POST",
            data: {generatePost:true},
            dataType: "json",
            success: function(result) {
              if (!result.error){
                document.getElementById('result').innerHTML = result.out;
              }
              else{
                document.getElementById('result').innerHTML = "Fatal Error: Ошибка загрузки записей.";
                console.log('Ошибка.');
              }
            }
          });
function SendPost(){
      if (document.querySelector('.ql-editor') != '') 
      {
        var text = document.querySelector('.ql-editor').innerHTML;
        document.getElementById('text2').value = text;
        var text2 = document.getElementById('text2').value;
        console.log(text2);
        $.ajax({
          crossOrigin: true,
          url: "server.php",
          type: "POST",
          data: {sendPost:true, text2:text2},
          dataType: "json",
          success: function(result) {
            if (!result.error){
              document.getElementById('result').innerHTML = result.out;
              document.querySelector('.ql-editor').innerHTML = '';
            }
            else{
              console.log('Ошибка.');
            }
          }
        });
      }else{
        alert('Поле должно быть заполнено!');
      }
    }