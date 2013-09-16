function generateota(pid,product,revs) {
	var request = $.ajax({
		type : 'post',
		url : "ota.php",
		data : {
			id : pid,
			product: product,
			revs : revs
		},
		dataType : 'html'
	});

	request.done(function(msg) {
		alert(msg);
	});
	request.fail(function(jqXHR, textStatus) {
		alert("Request failed: " + textStatus);
	});
}