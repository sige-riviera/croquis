


function listeCroquis(){
	$("#files").html('<img id="loading" src="img/loading.gif">');
	
	var commune = $('#commune').val();
	var format = $('input[name=radioformat]:checked').val();
	var filter = $('#filter').val();
	if (filter=="Recherche..."){filter = "";}
	//alert(commune + ' ' + format + ' ' + filter);
	$.ajax({ 	
		type: "GET",
		data: "commune="+commune+'&format='+format+'&filter='+filter,
		url: "listecroquis.php",	
		contentType: "application/x-www-form-urlencoded",
		success: function(data){ $("#loading").remove(); printList(data); },	
		error: function(xhr,text){alert('Une erreur s\'est produite. Info: ' + xhr + ' / ' + text);}
	});
}


function printList(docXML){
	// DISPLAY RESULT
	var files = docXML.getElementsByTagName("file");
	var html = "<ul>";
	for (var i=0;i<files.length;i++) { 
		var links = files[i].getElementsByTagName("link");
		var abonne = files[i].getElementsByTagName("abonne")[0].textContent;
		var nLinks = links.length;

		for (var j=0;j<nLinks;j++) { 
			var link = links[j].textContent;		
			html += '<li>';
			html += '<a href="'+link+'" target="croquis_frame">';
			html += abonne;
			if (nLinks > 1){
				html += ' (' + (j+1) + '/' + nLinks + ')';
			}
			html += '</a>';
			html += '</li>';
		}
	}
	html += "</ul>";
	$( "#files" ).html( html );	
	
	sizeContent();
}
