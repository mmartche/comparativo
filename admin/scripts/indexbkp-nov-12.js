function submitForm(){
	fixFields();
}
$(document).ready(function(){
	$(".resultContent").click(function(){
		openDetails($(this).attr("iddb"));
	});
	$('#colorSelector').ColorPicker({
		color: '#0000ff',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr,qwe) {
			$(colpkr).fadeOut(500);
			//console.log(colpkr);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			//console.log(hex);
			$('#colorSelector div').css('backgroundColor', '#' + hex);
			$("#colorSelected").val(hex);
		},
		onSubmit: function (hsb,hex,rgb,obj) {
			$(".colorpicker").fadeOut(500);
			//console.log(hsb,hex,rgb,obj);
		}
	});
	$("#colorSelected").keyup(function(){
		colorTemp = $("#colorSelected").val();
		$("#colorSelector div").css("backgroundColor", "#" + colorTemp);
		//$(".divColor").ColorPicker({color:colorTemp});
	});
	$("#btnColorAdd").click(function(){
		cName = $("#colorName").val(),
		cColor = $("#colorSelected").val(),
		cApp = $("#colorAplication").val(),
		cType = $("#colorType").val();
		cLength = $("#optionsColor span").length-1;
		if (cColor.length == "6") {
			$("#optionsColor").append('<span><div class="delColor" onclick="deleteColor(this)">X</div><div class="divColor"><div style="background-color: #'+cColor+';"></div></div>'+cName+'-'+cApp+'-'+cType+'<input type="hidden" name="colorInputName'+cLength+'" value="'+cName+'" /><input type="hidden" name="colorInputColor'+cLength+'" value="'+cColor+'" /><input type="hidden" name="colorInputApp'+cLength+'" value="'+cApp+'" /><input type="hidden" name="colorInputType'+cLength+'" value="'+cType+'" /></span>');
			$("#colorLength").val(cLength+1);
			$("#colorName").val(""),
			$("#colorSelected").val(""),
			$("#colorAplication").val(""),
			$("#colorType").val(""),
			$("#colorSelector div").css("backgroundColor", "#ffffff");
		} else {
			alert("Precisa ser 6 números, contei "+cColor.length);
		}
		//$(".delColor").click(function(){
			
		//});
	});
	$("#btnOptionsAdd").click(function(){
		//captura daods
		textTemp = $("#textAreaOptionsAdd").val();
		text = textTemp.split(";");
		optionTemp = $('input[name=rdOptionsAdd]:checked').val();
		l = $("#optionsOptions span").length-2;
		for (i=0;i<text.length;i++){
			if (text[i].length > 0){
				switch(optionTemp){
					case ("s"):
						$("#optionsOptions").append('<span><input type="radio" name="rdOpt'+l+'" checked="true" value="s" /><input type="radio" name="rdOpt'+l+'" value="o" /><input type="radio" name="rdOpt'+l+'" value="n" /><input type="hidden" name="txtOpt'+l+'" value="'+text[i]+'" />'+text[i]+'</span>');
					break;

					case ("o"):
						$("#optionsOptions").append('<span><input type="radio" name="rdOpt'+l+'" value="s" /><input type="radio" name="rdOpt'+l+'" checked="true" value="o" /><input type="radio" name="rdOpt'+l+'" value="n" /><input type="hidden" name="txtOpt'+l+'" value="'+text[i]+'" />'+text[i]+'</span>');
					break;

					case ("n"):
						$("#optionsOptions").append('<span><input type="radio" name="rdOpt'+l+'" value="s" /><input type="radio" name="rdOpt'+l+'" value="o" /><input type="radio" name="rdOpt'+l+'" checked="true" value="n" /><input type="hidden" name="txtOpt'+l+'" value="'+text[i]+'" />'+text[i]+'</span>');
					break;
				}
				l++;
			}
		}
		$("#lengthOptions").val(l);
		//captura opcao global
		//valida se tem varios
		//adiciona na lista + opcao selecionada
	});
});
function fixFields(){
	//fix all inputs // counters // flags before submit
	return true;
}
function deleteColor(obj) {
	$(obj).parent().remove();
	$("#colorLength").val($("#optionsColor span").length-1);
}
function openDetails(idFeature){
	console.log(idFeature);
}
function filterFields(fieldName,obj){
	//se o campo do mesmo class nao tiver o texto digitado, some
	//console.log(fieldName,obj.value);
	$(".resultContent").removeClass("hide");
	lengthFields = $("."+fieldName).length;
	for (i=0;i<lengthFields;i++){
		var tempField = $("."+fieldName)[i].innerText;
		if (tempField.indexOf(obj.value) < 0){
			t = $("."+fieldName)[i].parentElement;
			$(t).addClass("hide");
		}
	}	
}
$(function() {
	function log( message ) {
		$( "<div>" ).text( message ).prependTo( "#log" );
		$( "#log" ).scrollTop( 0 );
	}
	$( "#askInput" ).autocomplete({
		source: "api/index.php?type=askInput",
		minLength: 1,
		select: function( event, ui ) {
			//console.log(ui.item.value+ui.item.id+this.value);
			//console.log(ui);
			log( ui.item ?
				"Selected: " + ui.item.id + " aka " + ui.item.value :
				"Nothing selected, input was " + this.value );
			//console.log('api/index.php?type=terms&term='+ui.item.value+'&idField='+ui.item.id+'&table='+ui.item.table);
			$.getJSON('api/index.php?type=terms&term='+ui.item.value+'&idField='+ui.item.id+'&table='+ui.item.table, function(data) {
				var items = "";
				$(".resultContent").remove();
				$.each(data, function(key, val) {
					//<tr><td id="' + key + '" class="askImg">'+key+'+'+val.value+'</td></tr>');
					items = '<li class="resultContent" idDB="'+val.idFeature+'">'+
									'<div class="rsItems">'+
									'<div class="btnEdit"></div>'+
									'<div class="btnDelete"></div>'+
									'<div class="btnClone"></div>'+
									'<div class="btnActive"></div>'+
									'</div>'+
									'<div class="rsManufacturer">'+val.manufacturerName+'</div>'+
									'<div class="rsModel">'+val.modelName+'</div>'+
									'<div class="rsVersion">'+val.versionName+'</div>'+
									'<div class="rsYear">'+val.yearProduced+'</div>'+
									'<div class="rsYear">'+val.yearModel+'</div>'+
									'<div class="rsPicture"></div>'+
									'<div class="rsSegment"></div>'+
									'<div class="rsGear"></div>'+
									'<div class="rsOil"></div>'+
									'<div class="rsAvaliable">Sim</div>'+
								'</li>';
					$(".resultList").append(items);
				});

				$(".resultContent").click(function(){
					openDetails($(this).attr("iddb"));
				});
			});
		},
		open: function() {
		//$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			//console.log("open");
		},
		close: function() {
		//$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			//console.log("close");
		}
	});
});