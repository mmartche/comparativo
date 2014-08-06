$(document).ready(function(){
	// $( "#itemListEdit" ).combobox();
	$("#itemListEdit").change(function(){
		var txtCat = $("#category").val();
		itemListEdit(this.value,txtCat);
	});
});
function itemListEdit (option,catOpt) {
	if (catOpt == "color") {
	console.log('api/index.php?type=askColorValue&optId='+option+'&rand='+Math.floor((Math.random()*1000000)+100));
		$.getJSON('api/index.php?type=askColorValue&optId='+option+'&rand='+Math.floor((Math.random()*1000000)+100), function(data) {
			$.each(data, function(key, val) {
				$("#txtId").val(val.id);
				$("#txtName").val(val.value);
				$("#txtCode").val(val.code);
				$("#txtPrice").val(val.price);
				$("#txtHexa").val(val.hexa);
				$("#txtType").val(val.type);
			});
		});
	} else if (catOpt == "options") {
		console.log('api/index.php?type=askOptionValue&optId='+option+'&rand='+Math.floor((Math.random()*1000000)+100));
		$.getJSON('api/index.php?type=askOptionValue&optId='+option+'&rand='+Math.floor((Math.random()*1000000)+100), function(data) {
			$.each(data, function(key, val) {
				console.log(decodeURIComponent(val.optValue));
				$("#txtId").val(val.id),
				$("#txtName").val(decodeURIComponent(val.value)),
				$("#txtOptValue").text(decodeURIComponent(val.optValue)),
				$("#txtPrice").val(val.price),
				$("#txtCode").val(val.code);
			});
		});
	}
}
