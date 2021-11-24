function menubtn(item){
	switch(item){
		case 'live':
			document.getElementById('result').innerHTML = '<progress id="progressbar" value="0" max="100">Loading...</progress>'
			var progressBar = document.getElementById('progressbar');
			$.ajax({
						
				url: "../server.php",
				type: "POST",
				data: {listType:'public'},
				dataType: "json",
				xhr: function(){
					var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
					xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
						progressBar.value = evt.loaded;
						progressBar.max = evt.total;
					};
        			return xhr;
      			},
				success: function(result) {
					if (!result.error){
						document.getElementById('result').innerHTML = result.out;
					}else{
						document.getElementById('result').innerHTML = "Fatal Error: Ошибка загрузки записей.";
						console.log('Ошибка.');
					}
				}
			});
		break;

		case 'diary':
			document.getElementById('result').innerHTML = '<progress id="progressbar" value="0" max="100">Loading...</progress>'
			var progressBar = document.getElementById('progressbar');
			$.ajax({
						
				url: "../server.php",
				type: "POST",
				data: {listType:'personal'},
				dataType: "json",
				xhr: function(){
					var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
					xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
						progressBar.value = evt.loaded;
						progressBar.max = evt.total;
					};
    				return xhr;
    			},
				success: function(result) {
					if (!result.error){
						document.getElementById('result').innerHTML = result.out;
					}else{
						document.getElementById('result').innerHTML = "Fatal Error: Ошибка загрузки записей.";
								console.log('Ошибка.');
						}
					}
				});
			break;

		case 'settigs':
		break;

		case 'profile':
		
			$.ajax({
				url: '../server.php',
				type: 'POST',
				data: {login:true},
				dataType: 'json',
				success: function(result){
					if(!result.error){
						document.getElementById('result').innerHTML = "Форма входа/регистрации.";
						console.log('Вход выполнен');
					}else{
						console.log('Вход не выполнен');
					}
				}
			});
		break;
	}
}

function Auth(type){
	var login = document.querySelector('input[name="login"]').value;
	console.log(login);
	var password = document.querySelector('input[name="password"]').value;
	console.log(password);
	$.ajax({
		url: '../server.php',
		type: 'POST',
		data: {authentification: true, type:type, login: login, password: password},
		dataType: 'json',
		success: function(result){
			if(!result.error){
				SesCheck();
				document.querySelector('#result').innerHTML = result.out;
			}else{
				document.querySelector('#notify').innerHTML = result.out;
			}
		}
	});
}



function SesCheck(){
	$.ajax({
		url: '../server.php',
		type: 'POST',
		data: {SesCheck:true},
		dataType: 'json',
		success: function(result){
			if(!result.error){
				document.getElementById('resultAuth').innerHTML = '<div class="posts-editor"><div id="toolbar"></div><div id="editor"></div><textarea name="text2" id="text2" cols="30" rows="10" class="hidden" value placeholder="Что нового?"></textarea><div class="BTNScontainer"><div class="tools-container"><div class="sends" name="sendPost" onclick="SendPost();" title="Запись в дневник">Сохранить</div><div class="sends" name="sendPost" onclick="SendPub();" title="Опубликовать для всех ползователей">Опубликовать</div><div class="sendStatus" name="sendStatus">Напишите что-нибудь.</div></div>';
				QuillGenerate();
				loadingPosts();
			}else{
				
				loadingPosts();
				console.log('Ошибка авторизации!');
			}
		}
	});
}

function loadMore(start, endpoint, postType){
	function Loaded() {
		document.querySelector('div[name="sendStatus"]').innerHTML = "Напишите что-нибудь.";
	}
	document.querySelector('div[id="loadmoreBlock"]').innerHTML = '<progress id="loadmore" value="0" max="100"></progress>';
	var progressBar = document.getElementById('loadmore');
	$.ajax({
			url: "../server.php",
			type: "POST",
			data: {loadMore: true, listType:postType, startpoint:start, endpoint:endpoint},
			dataType: "json",
			xhr: function(){
					var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
					xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
						progressBar.value = evt.loaded;
						progressBar.max = evt.total;
					};
      			return xhr;
    		},
			success: function(result) {
				if (!result.error){
					document.getElementById('loadmoreBlock').parentNode.removeChild(document.getElementById('loadmoreBlock'));
					document.getElementById('result').innerHTML += result.out;
				}else{
					document.querySelector('div[id="loadmoreBlock"]').innerHTML = 'Ошибка загрузки!';
					console.log('Ошибка.');
				}
			}
		});
}

function deletePost(postid, postType){
			console.log(postid);
			function statusSuccessSend() {
				document.querySelector('div[name="sendStatus"]').innerHTML = "Напишите что-нибудь.";
			}
			document.querySelector('div[name="sendStatus"]').innerHTML = '<progress id="progressbar2" value="0" max="100"></progress>Удаление...';
				var progressBar = document.getElementById('progressbar2');
			$.ajax({
					url: "../server.php",
					type: "POST",
					data: {delPost:true, postid:postid, postType: postType},
					dataType: "json",
					xhr: function(){
							var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
							xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
								progressBar.value = evt.loaded;
								progressBar.max = evt.total;
							};
        					return xhr;
      					},
					success: function(result) {
						if (!result.error){
							document.getElementById('result').innerHTML = result.out;
							document.querySelector('.ql-editor').innerHTML = '';
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Пост удален!';
							setTimeout(statusSuccessSend, 1000);

						}
						else{
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Ошибка публикации!';
							console.log('Ошибка.');
						}
					}
				});
}

function SendPost(){
			function statusSuccessSend() {
				document.querySelector('div[name="sendStatus"]').innerHTML = "Напишите что-нибудь.";
			}
			var text = document.querySelector('.ql-editor').innerHTML;
			document.getElementById('text2').value = text;
			console.log(document.getElementById('text2').value);
			if (document.querySelector('#text2') != '<p><br></p>') 
			{
				
				var text2 = document.getElementById('text2').value;
				console.log(text2);
				document.querySelector('div[name="sendStatus"]').innerHTML = '<progress id="progressbar2" value="0" max="100"></progress>Публикация...';
				var progressBar = document.getElementById('progressbar2');
				$.ajax({
					crossOrigin: true,
					url: "../server.php",
					type: "POST",
					data: {sendPost:true, text2:text2},
					dataType: "json",
					xhr: function(){
							var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
							xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
								progressBar.value = evt.loaded;
								progressBar.max = evt.total;
							};
        					return xhr;
      					},
					success: function(result) {
						if (!result.error){
							document.getElementById('result').innerHTML = result.out;
							document.querySelector('.ql-editor').innerHTML = '';
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Опубликовано!';
							setTimeout(statusSuccessSend, 1000);

						}
						else{
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Ошибка публикации!';
							console.log('Ошибка.');
						}
					}
				});
			}else{
				alert('Поле должно быть заполнено!');
			}
}

function SendPub(){
			function statusSuccessSend() {
				document.querySelector('div[name="sendStatus"]').innerHTML = "Напишите что-нибудь.";
			}

			function showWall(id){
				window.location.replace('../threads/?type=pub&id='+id);
			}
			var text = document.querySelector('.ql-editor').innerHTML;
			document.getElementById('text2').value = text;
			console.log(document.getElementById('text2').value);
			if (document.querySelector('#text2') != '<p><br></p>') 
			{
				
				var text2 = document.getElementById('text2').value;
				console.log(text2);
				document.querySelector('div[name="sendStatus"]').innerHTML = '<progress id="progressbar2" value="0" max="100"></progress>Публикация...';
				var progressBar = document.getElementById('progressbar2');
				$.ajax({
					crossOrigin: true,
					url: "../server.php",
					type: "POST",
					data: {sendPub:true, text2:text2},
					dataType: "json",
					xhr: function(){
							var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
							xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
								progressBar.value = evt.loaded;
								progressBar.max = evt.total;
							};
        					return xhr;
      					},
					success: function(result) {
						if (!result.error){
							
							document.querySelector('.ql-editor').innerHTML = '';
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Опубликовано! ' + result.id;
							setTimeout(statusSuccessSend, 1000);

							setTimeout(showWall(result.id), 5000);

						}
						else{
							document.querySelector('div[name="sendStatus"]').innerHTML = 'Ошибка публикации!';
							console.log('Ошибка.');
						}
					}
				});
			}else{
				alert('Поле должно быть заполнено!');
			}
}

function loadingPosts(){
	document.querySelector('#result').innerHTML = '<progress id="progressbar" value="0" max="100">Loading...</progress>'
					var progressBar = document.getElementById('progressbar');
					$.ajax({
						
						url: "../server.php",
						type: "POST",
						data: {listType:'public'},
						dataType: "json",
						xhr: function(){
							var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
							xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
								progressBar.value = evt.loaded;
								progressBar.max = evt.total;
							};
        					return xhr;
      					},
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
}

function showPost(){
	document.querySelector('#result').innerHTML = '<progress id="progressbar" value="0" max="100">Loading...</progress>'
					var progressBar = document.getElementById('progressbar');

					$.ajax({
						
						url: "../server.php",
						type: "POST",
						data: {showPost:true},
						dataType: "json",
						xhr: function(){
							var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
							xhr.onprogress = function(evt){ // добавляем обработчик события progress (onprogress)
								progressBar.value = evt.loaded;
								progressBar.max = evt.total;
							};
        					return xhr;
      					},
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
}

function QuillGenerate(){
	var toolbarOptions = {
							container: [
								['bold', 'italic', 'underline', 'strike'],        // toggled buttons
								['blockquote', 'code-block'],

								[{ 'header': 2 }],               // custom button values
								[{ 'list': 'ordered'}, { 'list': 'bullet' }],
								[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
								[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
								[{ 'direction': 'rtl' }],                         // text direction

								[{ 'color': [] }],          // dropdown with defaults from theme
								[{ 'align': [] }],
								['link', 'image', 'video'],

								// ['emoji'],
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
									  placeholder: 'Что нового?',
									  theme: 'snow'  // or 'bubble'
									});
						$("#toolbar").append($(".ql-toolbar"));
}