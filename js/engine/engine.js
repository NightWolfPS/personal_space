$(document).ready(function() {
	var input = document.querySelector('#htags');

	input.addEventListener('keyup', function (event) {
    	// забираем только текст, без тегов
	    var text = this.value;
	    var i = 1;
	    var j = 0;
	    var highlighted = [];
	    var splited = text.split('#');
	    var textplt = text.split(' ');
	    console.log('Просто массив хеш: '+textplt);
	    console.log('Ключи хеш: '+splited);
	    var view = document.querySelector('#htag_view');
	    view.innerHTML = '';
    	// заменяем
    	for(i = 1; i <= splited.length; i++){
    		if(splited[i] != undefined && splited[i] != highlighted[i]){
    			console.log('Значение: '+i);
    			console.log('Хештег номер '+i+' - '+String(splited[i]));
    			console.log('Хешированное: '+encodeURI(splited[i]));
    			console.log(text);
			    highlighted[i] = textplt[j].replace(/(#\w+)/g, '<a href="search.php?hashtag='+splited[i]+'" class="hashtag">'+textplt[i-1]+'</a>');
			    console.log('Хм... '+highlighted[i]);
				j++;

    	// обновляем содержимое
	    		view.innerHTML += highlighted[i] + ' ';
			}else{
				return false;
			}
		}
	    // установка курсора в конец строк
    	//placeCaretAtEnd(this);
	});

	$("button[name='quote']").bind("click", function() {
		var txt = '';
		var node = $('#text').html();
		console.log("Все работает");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		var edited = "<blockquote>" + txt + "</blockquote><br/>";
		var res = node.replace(txt, edited); 
		console.log(node);
		document.getElementById('text').innerHTML = res;
				
	});
	$("button[name='bold']").bind("click", function() {
		var txt = '';
		var node = $('#text').html();
		console.log("Все работает");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		if(document.querySelectorAll('b') == txt){
			var edited = "</b>" + txt + "<b>";
			var res = node.replace(txt, edited); 
			console.log(node);
			document.getElementById('text').innerHTML = res;
		}else{
			var edited = "<b>" + txt + "</b>";
			var res = node.replace(txt, edited); 
			console.log(node);
			document.getElementById('text').innerHTML = res;
	}
				
	});
	$("button[name='italic']").bind("click", function() {
		var txt = '';
		var node = $('#text').html();
		console.log("Все работает");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		var edited = "<i>" + txt + "</i>";
		var res = node.replace(txt, edited); 
		console.log(node);
		document.getElementById('text').innerHTML = res;
				
	});
	$("button[name='underline']").bind("click", function() {
		var txt = '';
		var node = $('#text').html();
		console.log("Все работает");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		var edited = "<u>" + txt + "</u>";
		var res = node.replace(txt, edited); 
		console.log(node);
		document.getElementById('text').innerHTML = res;
				
	});
	$("button[name='link']").bind("click", function() {
		var txt = '';

		var node = $('#text').html();
		console.log("Все работает");
		var dialog = document.querySelector("dialog[id='link']");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		dialog. showModal();
		if(txt != ''){
			document.getElementById('linkname').value = txt;
		}

		
		var button = document.querySelector("#Save");
		var cancel = document.querySelector("#cancel");

		var txtarea = document.querySelector('#text');
		txtarea.focus();
		//ищем первое положение выделенного символа
		var start = txtarea.selectionStart;
		//ищем последнее положение выделенного символа
		var end = txtarea.selectionEnd;
		// текст до + вставка + текст после (если этот код не работает, значит у вас несколько id)

		
  		button.addEventListener("click", function() {

  			
			var url = $('#uri').val();
			document.execCommand('CreateLink', false, url);

  			var linkname = $('#linkname').val();
			var uri = $('#uri').val();
  			var edited = "<a href='"+uri.toString()+"' target='_blank'>" + linkname.toString() + "</a>";
  			var res = node.replace(txt, edited);
			//var res = node.replace(txt, edited);   + txtarea.value.substring(end)
			//txtarea.selectionEnd = ( start == end )? (end + edited.length) : end ;
			//var finText = edited;
			//подмена значения
			//console.log(finText);
			txtarea.innerHTML = res;
			// возвращаем фокус на элемент
			txtarea.focus();
			// возвращаем курсор на место - учитываем выделили ли текст или просто курсор поставили
			


			//console.log(node);
			//document.getElementById('text').innerHTML = finText;
			dialog.close();
    		console.log("Button clicked.");
  		});
		cancel.addEventListener("click", function() {
			dialog.close();
		});
	});

	$("button[name='yout']").bind("click", function() {
		var txt = '';
		var node = $('#text').html();
		console.log("Все работает");
		var dialog = document.querySelector("dialog[id='YTlnk']");
		if (txt = window.getSelection) { // Не IE, используем метод getSelection
			txt = window.getSelection().toString();
		} else { // IE, используем объект selection
			txt = document.selection.createRange().text;
		}
		dialog.showModal();
		// if(txt != ''){
		// 	document.getElementById('YTuri').value = txt;
		// }

		
		var button = document.querySelector("#YTSave");
		var cancel = document.querySelector("#YTcancel");

		//var txtarea = document.querySelector('#text');
		//ищем первое положение выделенного символа
		//var start = txtarea.selectionStart;
		//ищем последнее положение выделенного символа
		//var end = txtarea.selectionEnd;
		// текст до + вставка + текст после (если этот код не работает, значит у вас несколько id)

		
  		button.addEventListener("click", function() {
  			//var linkname = $('#YTuri').val();
			var uri = $('#YTuri').val();
  			const link = new URL(uri);
			const id = link.pathname.slice(1);
			console.log(id);
			// подмена значения
			document.getElementById('YTembed_place').value = '<iframe width="630" height="356,25" src="https://www.youtube.com/embed/'+id+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
			var embed = document.getElementById('YTembed_place').value;
			document.getElementById('embedVideo').innerHTML = '<iframe width="630" height="356,25" src="https://www.youtube.com/embed/'+id+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
			// возвращаем фокус на элемент
			// возвращаем курсор на место - учитываем выделили ли текст или просто курсор поставили
			


			console.log(node);
			//document.getElementById('text').innerHTML = finText;
			dialog.close();
    		console.log("Button clicked.");
  		});
		cancel.addEventListener("click", function() {
			dialog.close();
		});
	});
});




//Каретка

function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined" &&
        typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(true);
        textRange.select();
    }
}

