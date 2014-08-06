//global vars
var manufacturerIdGlobal, modelIdGlobal, versionIdGlobal, featureIdGlobal;
var dateTsRandom = Math.floor((Math.random()*1000000)+100);

function submitForm(){
	fixFields();
}
$(document).ready(function(){
	$('input[type=text]').on('keyup', function(e) {
	    if (e.which == 13) {
	        e.preventDefault();
	    }
	});
	
	$("#txtPicture").change(function(e){
        if(typeof FileReader == "undefined") return true;
        var elem = $(this);
        var files = e.target.files;
 
        for (var i = 0, f; f = files[i]; i++) {
            if (f.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                        var image = e.target.result;
                        previewDiv = $('.image-preview', elem.parent());
                        bg_width = previewDiv.width();
                        bg_height = previewDiv.height();
                        previewDiv.css({
                            "background-image":"url("+image+")"
                        });
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
	});
	manufacturerIdGlobal = $("#manufacturerId").val();
	$(".btnNewForm").mouseover(
	function() {
		$(".newChoice").show();
	});
	$(".newChoice").hover(function() {
		//do nothing
	},function(){
		$(this).hide();
	});

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
		/*
		if ($("#featureId").val().length > 0) { 
			cTable = "modelColor"; 
			manufacturerId = $("#featureId").val();
		} else { 
		*/
			cTable = "colorManufacturer"; 
			manufacturerId = $("#manufacturerId").val();
		/*}*/
		cIId = $("#colorId").val(),
		cName = $("input[name=colorName]").val(),
		cNameFull = $("#txtColorName").val();
		cColor = $("#colorSelected").val(),
		// cApp = $("#colorAplication").val(),
		cType = $("#colorType").val(),
		cPrice = $("#colorPrice").val();
		cCode = $("#colorCode").val();
		cLength = $("#optionsColor span[name=liColorItem]").length;
		if (cName == "") {
			alert ('Escolha ou digite um nome');
			return false;
		}
		// console.log('api/index.php?type=addColor&cId='+cIId+'&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ctype='+cType+'&ccode='+cCode+'&table='+cTable+'&cprice='+cPrice);
		if (cColor.length == "6") {
			if (cIId.length > 0 && $(this).val() == "Adicionar") { 
				$("#optionsColor").append('<span name="liColorItem"><div class="delColor" title="Remover" onclick="deleteColor(this,\''+cIId+'\',\''+cTable+'\')">X</div><div class="updateColor" onclick="updateColor(this,\''+cIId+'\',\''+cTable+'\')"><div class="divColor"><div style="background-color: #'+cColor+';"></div></div><span id="textColor">'+cName+' - '+cType+'<br />R$ '+cPrice+'</span><input type="hidden" id="colorInputId" name="colorInputId'+cLength+'" value="'+cIId+'" /><input type="hidden" id="colorInputName" name="colorInputName'+cLength+'" value="'+cName+'" /><input type="hidden" id="colorInputColor" name="colorInputColor'+cLength+'" value="'+cColor+'" /><input type="hidden" id="colorInputType" name="colorInputType'+cLength+'" value="'+cType+'" /><input type="hidden" id="colorInputCode" name="colorInputCode'+cLength+'" value="'+cCode+'" /><input type="hidden" id="colorInputPrice" name="colorInputPrice'+cLength+'" value="'+cPrice+'" /><input type="hidden" id="colorInputTable" name="colorInputTable'+cLength+'" value="'+cTable+'" /></span>');
					$("#colorLength").val(cLength+1);
			} else {
				$.getJSON('api/index.php?type=addColor&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ccode='+cCode+'&ctype='+cType+'&table='+cTable+'&cprice='+cPrice+'&cId='+cIId, function(data) {
					//console.log(data[0].response,data[0].insertId);
					if(data[0].response == "true"){
						//optionTemp = $('input[name=rdOptionsAdd]:checked').val();
						if (cIId.length == 0) {
						$("#optionsColor").append('<span name="liColorItem"><div class="delColor" title="Remover" onclick="deleteColor(this,\''+data[0].insertId+'\',\''+cTable+'\')">X</div><div class="updateColor" onclick="updateColor(this,\''+data[0].insertId+'\',\''+cTable+'\')"><div class="divColor"><div style="background-color: #'+cColor+';"></div></div><span id="textColor">'+cName+' - '+cType+'<br />R$ '+cPrice+'</span><input type="hidden" id="colorInputId" name="colorInputId'+cLength+'" value="'+cIId+'" /><input type="hidden" id="colorInputName" name="colorInputName'+cLength+'" value="'+cName+'" /><input type="hidden" id="colorInputColor" name="colorInputColor'+cLength+'" value="'+cColor+'" /><input type="hidden" id="colorInputType" name="colorInputType'+cLength+'" value="'+cType+'" /><input type="hidden" id="colorInputCode" name="colorInputCode'+cLength+'" value="'+cCode+'" /><input type="hidden" id="colorInputPrice" name="colorInputPrice'+cLength+'" value="'+cPrice+'" /><input type="hidden" id="colorInputTable" name="colorInputTable'+cLength+'" value="'+cTable+'" /></span>');
							$("#colorLength").val(cLength+1);
						} else {
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputName").val(cName);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputColor").val(cColor);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputType").val(cType);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputPrice").val(cPrice);
							$("#optionsColor").find("span[colorId="+cIId+"] #textColor").text(cName+' - '+cType+'\n => R$ '+cPrice);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorSelector div").css("backgroundColor", "#"+cColor);
							$("#optionsColor span").show();
						}
						$("#colorName").val(""),
						$("#txtColorName").val(""),
						$("#colorSelected").val(""),
						$("#colorPrice").val(""),
						//$("#colorAplication").val(""),
						//$("#colorType").val(""),
						$("#colorSelector div").css("backgroundColor", "#ffffff");
						$("#btnColorAdd").val("Adicionar");
					} else {
						alert(data[0].reason);
						//$("#resultOptions").prepend('<label>''</label>');
					}
				});
			}
		} else {
			alert("Precisa ser 6 números na cor hexadecimal e código preenchido");
		}
		//$(".delColor").click(function(){
			
		//});
	});
	/*
	-----antigo addcolor usando como parametro de comparacao idManuf, idVersion, code, yearModel.... impossivel pois existem varios codigos iguais com outras informações nada a ver
	$("#btnColorAdd").click(function(){
			cTable = "colorManufacturer"; 
			manufacturerId = $("#manufacturerId").val();
		cIId = $("#colorId").val(),
		cName = $("input[name=colorName]").val(),
		cNameFull = $("#txtColorName").val();
		cColor = $("#colorSelected").val(),
		// cApp = $("#colorAplication").val(),
		cType = $("#colorType").val(),
		cPrice = $("#colorPrice").val();
		cCode = $("#colorCode").val();
		cLength = $("#optionsColor span[name=liColorItem]").length;
		if (cName == "") {
			alert ('Escolha ou digite um nome');
			return false;
		}
		console.log('api/index.php?type=addColor&cId='+cIId+'&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ctype='+cType+'&ccode='+cCode+'&table='+cTable+'&cprice='+cPrice);
		if (cColor.length == "6" && cCode != "") {
			if (cIId.length > 0 && $(this).val() == "Adicionar") { 
				$("#optionsColor").append('<span name="liColorItem"><div class="delColor" title="Remover" onclick="deleteColor(this,\''+cIId+'\',\''+cTable+'\')">X</div><div class="updateColor" onclick="updateColor(this,\''+cIId+'\',\''+cTable+'\')"><div class="divColor"><div style="background-color: #'+cColor+';"></div></div><span id="textColor">'+cName+' - '+cType+'<br />'+cCode+' => R$ '+cPrice+'</span><input type="hidden" id="colorInputId" name="colorInputId'+cLength+'" value="'+cIId+'" /><input type="hidden" id="colorInputName" name="colorInputName'+cLength+'" value="'+cName+'" /><input type="hidden" id="colorInputColor" name="colorInputColor'+cLength+'" value="'+cColor+'" /><input type="hidden" id="colorInputType" name="colorInputType'+cLength+'" value="'+cType+'" /><input type="hidden" id="colorInputCode" name="colorInputCode'+cLength+'" value="'+cCode+'" /><input type="hidden" id="colorInputPrice" name="colorInputPrice'+cLength+'" value="'+cPrice+'" /><input type="hidden" id="colorInputTable" name="colorInputTable'+cLength+'" value="'+cTable+'" /></span>');
					$("#colorLength").val(cLength+1);
			} else {
				console.log("heueue");
				$.getJSON('api/index.php?type=addColor&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ccode='+cCode+'&ctype='+cType+'&table='+cTable+'&cprice='+cPrice+'&cId='+cIId, function(data) {
					//console.log(data[0].response,data[0].insertId);
					if(data[0].response == "true"){
						//optionTemp = $('input[name=rdOptionsAdd]:checked').val();
						if (cIId.length == 0) {
						$("#optionsColor").append('<span name="liColorItem"><div class="delColor" title="Remover" onclick="deleteColor(this,\''+data[0].insertId+'\',\''+cTable+'\')">X</div><div class="updateColor" onclick="updateColor(this,\''+data[0].insertId+'\',\''+cTable+'\')"><div class="divColor"><div style="background-color: #'+cColor+';"></div></div><span id="textColor">'+cName+' - '+cType+'<br />'+cCode+' => R$ '+cPrice+'</span><input type="hidden" id="colorInputId" name="colorInputId'+cLength+'" value="'+cIId+'" /><input type="hidden" id="colorInputName" name="colorInputName'+cLength+'" value="'+cName+'" /><input type="hidden" id="colorInputColor" name="colorInputColor'+cLength+'" value="'+cColor+'" /><input type="hidden" id="colorInputType" name="colorInputType'+cLength+'" value="'+cType+'" /><input type="hidden" id="colorInputCode" name="colorInputCode'+cLength+'" value="'+cCode+'" /><input type="hidden" id="colorInputPrice" name="colorInputPrice'+cLength+'" value="'+cPrice+'" /><input type="hidden" id="colorInputTable" name="colorInputTable'+cLength+'" value="'+cTable+'" /></span>');
							$("#colorLength").val(cLength+1);
						} else {
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputName").val(cName);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputColor").val(cColor);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputType").val(cType);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorInputPrice").val(cPrice);
							$("#optionsColor").find("span[colorId="+cIId+"] #textColor").text(cName+' - '+cType+'\n'+cCode+' => R$ '+cPrice);
							$("#optionsColor").find("span[colorId="+cIId+"] #colorSelector div").css("backgroundColor", "#"+cColor);
							$("#optionsColor span").show();
						}
						$("#colorName").val(""),
						$("#txtColorName").val(""),
						$("#colorSelected").val(""),
						$("#colorPrice").val(""),
						//$("#colorAplication").val(""),
						//$("#colorType").val(""),
						$("#colorSelector div").css("backgroundColor", "#ffffff");
						$("#btnColorAdd").val("Adicionar");
					} else {
						alert(data[0].reason);
						//$("#resultOptions").prepend('<label>''</label>');
					}
				});
			}
		} else {
			alert("Precisa ser 6 números na cor hexadecimal e código preenchido");
		}
		//$(".delColor").click(function(){
			
		//});
	});
	*/
	$("#btnColorEdit").click(function(){
		$("#blockColorSelector").addClass("hide");
		$("#colorBlockEdit").addClass("hide");
		$("#colorBlockSave").removeClass("hide");
	});
	$("#btnColorSave").click(function(){
		cTable = "colorManufacturer"; 
		manufacturerId = $("#manufacturerId").val();
		/*}*/
		cIId = $("#colorId").val(),
		cName = $("input[name=colorName]").val(),
		cNameFull = $("#txtColorName").val();
		cColor = $("#colorSelected").val(),
		// cApp = $("#colorAplication").val(),
		cType = $("#colorType").val(),
		cPrice = $("#colorPrice").val();
		cCode = $("#colorCode").val();
		cLength = $("#optionsColor span[name=liColorItem]").length;
		if (cName == "") {
			alert ('Escolha ou digite um nome');
			return false;
		}
		// console.log('api/index.php?type=editColor&cId='+cIId+'&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ctype='+cType+'&ccode='+cCode+'&table='+cTable+'&cprice='+cPrice);
		if (cColor.length == "6") {
			if (cIId.length > 0) {
				$.getJSON('api/index.php?type=editColor&manufacturerId='+manufacturerId+'&chexa='+cColor+'&cname='+cName+'&ccode='+cCode+'&ctype='+cType+'&table='+cTable+'&cprice='+cPrice+'&cId='+cIId, function(data) {
					//console.log(data[0].response,data[0].insertId);
					if(data[0].response == "true"){
						//optionTemp = $('input[name=rdOptionsAdd]:checked').val();
							$("#txtColorName").val("");
							$("#blockColorSelector").removeClass("hide");
							$("#colorSelector div").css("backgroundColor", "#fff");
							$("#colorSelected").val("");
							$("#colorId").val("");
							$("#colorPrice").val("");
							$("#colorBlockSave").addClass("hide");
							$("#colorBlockEdit").addClass("hide");
							$("#colorName").parent().find("input[name=colorName]").val("");
							$("#colorName").val("");
							$("#txtOptOldName").val("");
					} else {
						console.log(data[0].reason);
						//$("#resultOptions").prepend('<label>''</label>');
					}
				});
			}
		} else {
			alert("Precisa ser 6 números na cor hexadecimal e código preenchido");
		}
	});
	$("#btnColorCancel").click(function(){
		$("#txtColorName").val("");
		$("#blockColorSelector").removeClass("hide");
		$("#colorSelector div").css("backgroundColor", "#fff");
		$("#colorSelected").val("");
		$("#colorId").val("");
		$("#colorPrice").val("");
		$("#colorBlockSave").addClass("hide");
		$("#colorBlockEdit").addClass("hide");
		$("#colorName").parent().find("input[name=colorName]").val("");
		$("#colorName").val("");
		$("#txtOptOldName").val("");
	});
	$("#btnColorDelete").click(function(){

	});



	$("#btnSerieAdd").click(function(){
		//captura daods
		var flag=false;
		textTemp = $("#textAreaSerieAdd").val();
		text = textTemp.split(",");
		optionTemp = $('input[name=rdOptionsAdd]:checked').val();
		$("#resultSerie input:hidden")
		l = $("#optionsSerie span").length-2;
		for (i=0;i<text.length;i++){
			if (text[i].trim().length > 0){
				if ($("#lengthSerie").val() > 0){
					for (v=1;v<$("#lengthSerie").val();v++){
						if ($("#resultSerie #txtSerie"+v).val()) {
							if ($("#resultSerie #txtSerie"+v).val().length > 0 && text[i].length > 0 && $("#resultSerie #txtSerie"+v).val().toLowerCase() === text[i].toLowerCase()) {
								flag=true;
								alert("O item de nome: '"+text[i]+"' já existe nesta listagem e foi selecionado.");
								document.getElementById("rdSerie"+v).checked = true;
								break;
							}
						}
					}
				}
				if (flag==false){
					$("#resultSerie").prepend('<span><input type="checkbox" name="rdSerie'+l+'" id="rdSerie'+l+'" checked="true" value="s" /><input type="hidden" name="txtSerie'+l+'" id="txtSerie'+l+'" value="'+text[i].trim()+'" />'+text[i].trim()+'</span>');
					flag=false;
				} else {
					flag=false;
				}
				l++;
			}
		}
		$("#lengthSerie").val(l);
		$("#textAreaSerieAdd").val("");
		//captura opcao global
		//valida se tem varios
		//adiciona na lista + opcao selecionada
	});
	$("#btnRemoveAllSeries").click(function(){
		$("#lengthSerie").val("0");
		$("#resultSerie span").remove();
		$("#textAreaSerieAdd").text("");
	});
	$("#btnOptionsAdd").click(function(){
		//dados

		optId = $("#txtOptionsId").val();
		codOpt = $("#txtOptionsCode").val();
		textTemp = $("#textAreaOptionsAdd").val();
		//name = $("#txtOptionsName").val();
		name = $("#txtOptionsName").parent().find("input.custom-combobox-input").val();
		price = $("#txtOptionsPrice").val();
		manufacturerId = $("#manufacturerId").val();
		versionId = $("versionId").val();
		text = textTemp.split(",");
		numCheck = $("#txtOptNumCheck").val();
		console.log("8");
		// console.log("!",optId,"@",codOpt,"#" ,textTemp,"(",name ,"-",price,"+",manufacturerId,"=",text,"/",numCheck);
		//add db
		if (optId != "") {
			if (numCheck != "") {
				//find inputs
				optItem = "#optItem"+numCheck;
				console.log("1",optItem);
				$(optItem+" #optIdOpt").val(optId);
				$(optItem+" #optPrice").val(price);
				$(optItem+" #lblOptPrice").text('R$ '+price);
				$(optItem+" #optCode").val(codOpt);
				$(optItem+" #lblOptions").attr("title",textTemp);
				$(optItem+" #lblOptions").text(name);
				$(optItem).removeClass("hide");
			} else {
				console.log("2");
				l = $("#resultOptions span").length;

				$("#resultOptions").prepend('<span id="optItem'+l+'" title=\''+textTemp+'\' name="spanOptionsList">'+
				'<div class="updateOpt" onclick="updateOpt(this,\''+l+'\')">'+
					'<input type="checkbox" class="hide" id="chOpt'+l+'" name="chOpt'+l+'" value="s" checked="checked" />'+
					'<input type="hidden" id="txtOptIdFeature" value="" />'+
					'<input type="hidden" id="optIdOpt" name="txtOpt'+l+'" value="'+optId+'" />'+
					'<input type="hidden" id="optPrice" name="txtOptPrice'+l+'" value="'+price+'" />'+
					'<input type="hidden" id="optCode" name="txtOptCode'+l+'" value="'+codOpt+'" />'+
					'<label id="lblOptions">'+name+'</label><br />'+
					'<label id="lblOptPrice">R$ '+price+'</label>'+
				'</div>'+
				'<label for="chOpt'+l+'" class="removeOpt" onclick="removeOpt(this,'+l+')">X</label>'+
			'</span>');
				// l++;
				$("#lengthOptions").val(l+1);
			}
			console.log("3");
			$("#txtOptionsId").val("");
			$("#txtOptionsCode").val("");
			$("#textAreaOptionsAdd").val("");
			$("#textAreaOptionsAdd").text("");
			$("#txtOptionsName").val("");
			$("#txtOptOldName").val("");
			$("#txtOptionsName").parent().find("input[name=txtOptionsName]").val("");
			$("#txtOptionsPrice").val("");
			$("#txtOptNumCheck").val("");
		} else {
			console.log("14");
			// console.log('api/index.php?type=addOption&manufacturerId='+manufacturerId+'&codopt='+codOpt+'&name='+encodeURIComponent(name)+'&text='+encodeURIComponent(textTemp)+'&price='+encodeURIComponent(price));
			$.getJSON('api/index.php?type=addOption&manufacturerId='+manufacturerId+'&codopt='+codOpt+'&name='+encodeURIComponent(name)+'&text='+encodeURIComponent(textTemp)+'&price='+encodeURIComponent(price), function(data) {
				if(data[0].response == "true"){
					newId = data[0].insertId;
					l = $("#resultOptions span").length;
					$("#resultOptions").prepend('<span id="optItem'+l+'" title=\''+textTemp+'\'>'+
						'<div class="updateOpt" onclick="updateOpt(this,\''+l+'\')" title=\''+textTemp+'\'>'+
							'<input type="checkbox" id="chOpt'+l+'" name="chOpt'+l+'" value="s" checked="checked" class="hide" />'+
							'<input type="hidden" id="txtOptIdFeature" value="" />'+
							'<input type="hidden" id="optIdOpt" name="txtOpt'+l+'" value="'+newId+'" />'+
							'<input type="hidden" id="optPrice" name="txtOptPrice'+l+'" value="'+price+'" />'+
							'<input type="hidden" id="optCode" name="txtOptCode'+l+'" value="'+codOpt+'" />'+
							'<label id="lblOptions">'+name+'</label><br />'+
							'<label>R$ '+price+'</label>'+
						'</div>'+
						'<label for="chOpt'+l+'" class="removeOpt" onclick="removeOpt(this,'+l+')">X</label>'+
					'</span>');
					// l++;
					$("#lengthOptions").val(l+1);
				}
				$("#txtOptionsId").val("");
				$("#txtOptionsCode").val("");
				$("#textAreaOptionsAdd").val("");
				$("#textAreaOptionsAdd").text("");
				$("#txtOptionsName").val("");
				$("#txtOptOldName").val("");
				$("#txtOptionsName").parent().find("input[name=txtOptionsName]").val("");
				$("#txtOptionsPrice").val("");
				$("#txtOptNumCheck").val("");
			});
		}
		$("#btnOptionsAdd").attr("disabled",true);
		//add form


		//captura opcao global
		//valida se tem varios
		//adiciona na lista + opcao selecionada
	});
	$("#btnOptionsEdit").click(function(){
		//ativar inputs
		$("#txtOptionsCode").attr("disabled",false);
		$("#textAreaOptionsAdd").attr("disabled",false);
		// $("#btnOptionsEdit").addClass("btnSave");
		$("#optBlockSave").removeClass("hide");
		$("#optBlockEdit").addClass("hide");
		//muda bota pra salvar
		//salva
		//muda se tiver na lista
		//muda se tiver check
		//apaga inputs
		//volta botao
	});
	$("#btnOptionsSave").click(function(){
		optId = $("#txtOptionsId").val();
		codOpt = $("#txtOptionsCode").val();
		textTemp = $("#textAreaOptionsAdd").val();
		//name = $("#txtOptionsName").val();
		name = $("#txtOptionsName").parent().find("input.custom-combobox-input").val();
		price = $("#txtOptionsPrice").val();
		manufacturerId = $("#manufacturerId").val();
		versionId = $("versionId").val();
		text = textTemp.split(",");
		numCheck = $("#txtOptNumCheck").val();
		// console.log("!",optId,"@",codOpt,"#" ,textTemp,"(",name ,"-",price,"+",manufacturerId,"=",text,"/",numCheck);
		//add db
		if (optId != "") {
			// console.log('api/index.php?type=editOption&optId='+optId+'&manufacturerId='+manufacturerId+'&codopt='+codOpt+'&name='+encodeURIComponent(name)+'&text='+encodeURIComponent(textTemp)+'&price='+encodeURIComponent(price));
			$.getJSON('api/index.php?type=editOption&optId='+optId+'&manufacturerId='+manufacturerId+'&codopt='+codOpt+'&name='+encodeURIComponent(name)+'&text='+encodeURIComponent(textTemp)+'&price='+encodeURIComponent(price), function(data) {
				if(data[0].response == "true"){
					if (numCheck != "") {
						//find inputs
						optItem = "#optItem"+numCheck;
						$(optItem+" #optIdOpt").val(optId);
						$(optItem+" #optPrice").val(price);
						$(optItem+" #lblOptPrice").text('R$ '+price);
						$(optItem+" #optCode").val(codOpt);
						$(optItem+" #lblOptions").attr("title",textTemp);
						$(optItem+" #lblOptions").text(name);
						$(optItem).removeClass("hide");
					} else {
						// newId = data[0].insertId;
						// l = $("#resultOptions span").length;
						// $("#resultOptions").prepend('<span id="optItem'+l+'" title=\''+textTemp+'\'>'+
						// 	'<div class="updateOpt" onclick="updateOpt(this,\''+l+'\')" title=\''+textTemp+'\'>'+
						// 		'<input type="checkbox" id="chOpt'+l+'" name="chOpt'+l+'" value="s" checked="checked" class="hide" />'+
						// 		'<input type="hidden" id="txtOptIdFeature" value="" />'+
						// 		'<input type="hidden" id="optIdOpt" name="txtOpt'+l+'" value="'+newId+'" />'+
						// 		'<input type="hidden" id="optPrice" name="txtOptPrice'+l+'" value="'+price+'" />'+
						// 		'<input type="hidden" id="optCode" name="txtOptCode'+l+'" value="'+codOpt+'" />'+
						// 		'<label id="lblOptions">'+name+'</label><br />'+
						// 		'<label>R$ '+price+'</label>'+
						// 	'</div>'+
						// 	'<label for="chOpt'+l+'" class="removeOpt" onclick="removeOpt(this,'+l+')">X</label>'+
						// '</span>');
						// // l++;
						// $("#lengthOptions").val(l+1);
					}
				}
				$("#txtOptionsId").val("");
				$("#txtOptionsCode").val("");
				$("#textAreaOptionsAdd").val("");
				$("#textAreaOptionsAdd").text("");
				var oldNameOpt = $("#txtOptOldName").val();
				$('#txtOptionsName option:contains("'+oldNameOpt+'")').text(name);
				$("#txtOptionsName").val("");
				$("#txtOptionsName").parent().find("input[name=txtOptionsName]").val("");
				$("#txtOptOldName").val("");
				$("#txtOptionsPrice").val("");
				$("#txtOptNumCheck").val("");
				$("#btnOptionsAdd").attr("disabled",true);
			});
		}
		$("#optBlockEdit").removeClass("hide");
		$("#optBlockSave").addClass("hide");
	});
	$("#btnOptionsDelete").click(function(){

	});
	$("#btnOptionsCancel").click(function(){
		$("#txtOptionsId").val("");
		$("#txtOptionsCode").val("");
		$("#textAreaOptionsAdd").val("");
		$("#textAreaOptionsAdd").text("");
		$("#txtOptionsName").parent().find("input[name=txtOptionsName]").val("");
		$("#txtOptionsName").val("");
		$("#txtOptOldName").val("");
		$("#txtOptionsPrice").val("");
		$("#txtOptNumCheck").val("");
		$("#txtOptionsCode").attr("disabled",true);
		$("#textAreaOptionsAdd").attr("disabled",true);
		// $("#btnOptionsEdit").addClass("btnSave");
		$("#btnOptionsAdd").attr("disabled",true);
		$("#optBlockSave").addClass("hide");
		$("#optBlockEdit").removeClass("hide");
	});
	$("#btnPictureAdd").click(function(){
		picUrl = $("#txtPicture").val();
		picName = $("#txtPicName").val();
		$("#listPictures").html('<li><div class="btnDeletePicture"></div><label>'+picName+'</label><img src="'+picUrl+'" /></li>');
	});
	$("#btnDelForm").click(function(){
		//check where we are (category whatever)
		featureId = $("#featureId").val(), yearProduced = $("#txtYearProduced").val(), yearModel = $("#txtYearModel").val(), manufacturerId = $("#manufacturerId").val(), manufacturerName = $("#manufacturerName").val(), modelId = $("#modelId").val(), modelName = $("#modelName").val(), versionId = $("#versionId").val(), versionName = $("#versionName").val(), category = $("#category").val();
		if (category != ""){
			fieldTemp = "#"+category+"Id";
			idForm = $(fieldTemp).val();
			msg = "Tem certeza que deseja excluir o veículo";
			if (featureId){
				msg+=" Ano: "+yearModel+"/"+yearProduced;
			}
			if (versionId){
				msg+=" Versão:"+versionName;
			}
			if (modelId){
				msg+=" Modelo:"+modelName;
			}
			if (manufacturerId){
				msg+=" Montadora:"+manufacturerName;
			}
			//show confirm  ... then
			var r = confirm(msg);
			if (r == true) {
				if (idForm && category) {
					$.getJSON('api/index.php?type=deleteForm&idField='+idForm+'&table='+category, function(data) {
						if(data[0].response == "true"){
							//go to index
							//console.log("foi");
							return true;
						} else {
							console.log(data[0].error);
							return false;
							//alert error
						}
					});
				}
			} else {
				return false;
			}
		}
	});
});
function fixFields(){
	//fix all inputs // counters // flags before submit
	return true;
}
function removeTempImg() {
	$("#txtPicture").val("");
	$(".image-preview").attr("style","");
	return false;
}
function updateOpt(obj,numCheck) {
	console.log($(obj));
	optIdOpt = $(obj).children("#optIdOpt").val(),
	code = $(obj).children("#optCode").val(),
	price = $(obj).children("#optPrice").val(),
	nameOpt = $(obj).children("#lblOptions").text(),
	optValue = $(obj).parent("span").attr("title"),
	optIdFeature = $(obj).children("#txtOptIdFeature").val();
	$("#txtOptionsCode").val(code);
	$("#txtOptionsPrice").val(price);
		// var find = ',';
		// var re = new RegExp(find, 'g');
		// optValue = optValue.replace(re, ',\n');
	$("#textAreaOptionsAdd").text(optValue.replace(';',';\n'));
	$("#textAreaOptionsAdd").val(optValue);
	$("#txtOptNumCheck").val(numCheck);
	$("#txtOptionsName").val(optIdOpt);
	$("#txtOptOldName").val(nameOpt);
	$("#txtOptionsName").parent().find("input[name=txtOptionsName]").val(nameOpt);
	$("#txtOptionsPrice").attr("disabled",false);
	$("#btnOptionsAdd").attr("disabled",false);
	// $("#textAreaOptionsAdd").attr("disabled",false);
	// $("#txtOptionsCode").attr("disabled",false);
	$("#optBlockSave").addClass("hide");
	$("#optBlockEdit").removeClass("hide");
	$("#txtOptionsId").val(optIdOpt);
	$("#txtOptionsPrice").focus();

}
function removeOpt (obj,numCheck){
	// $(obj).parent("span").toggleClass("hide");
	$(obj).parent("span").remove();
	$("#lengthOptions").val($("#resultOptions span[name=spanOptionsList]").length);
}
function updateColor(obj,idColor,table) {
	cIId = $(obj).children("#colorInputId").val();
	cIName = $(obj).children("#colorInputName").val();
	cISelect = $(obj).children("#colorInputColor").val();
	cIPrice = $(obj).children("#colorInputPrice").val();
	cCode = $(obj).children("#colorInputCode").val();
	cIApp = $(obj).children("#colorInputApp").val();
	cIType = $(obj).children("#colorInputType").val();
	$("#colorId").val(cIId);
	$("#colorName").val(cIName),
	$("#txtColorName").val(cIName),
	$("#colorName").parent().find("input[name=colorName]").val(cIName),
	$("#colorSelected").val(cISelect),
	$("#colorPrice").val(cIPrice),
	$("#colorCode").val(cCode),
	$("#colorAplication").val(cIApp),
	$("#colorAplication").parent().find("input[name=colorAplication]").val(cIApp),
	$("#colorType").val(cIType),
	$("#colorType").parent().find("input[name=colorType]").val(cIType);
	$("#colorSelector div").css("backgroundColor", "#"+cISelect);
	$("#btnColorAdd").val("Editar");
	$("#optionsColor span").show();
	$(obj).parent("span").hide();
}
function deleteColor(obj,idColor,table) {
//	console.log(obj,idColor,table);
	// $.getJSON('api/index.php?type=removeColor&table='+table+'&idColor='+idColor, function(data) {
	// 	if(data[0].response == "true"){
	// 		//optionTemp = $('input[name=rdOptionsAdd]:checked').val();
	// 		$(obj).parent().remove();
	// 		$("#colorLength").val($("#optionsColor span[name=liColorItem]").length);
	// 	} else {
	// 		console.log(data[0].reason);
	// 	}
	// });
	$(obj).parent().remove();
	$("#colorLength").val($("#optionsColor span[name=liColorItem]").length);
}
function openDetails(featureId){
	console.log(featureId);
}
function filterFields(fieldName,obj){
	return true;
	//se o campo do mesmo class nao tiver o texto digitado, some
	$(".resultItem").removeClass("hide");
	lengthFields = $("."+fieldName).length;
	for (i=0;i<lengthFields;i++){
		var tempField = $("."+fieldName)[i].innerHTML;
		if (tempField.toLowerCase().indexOf(obj.value.toLowerCase()) < 0){
			t = $("."+fieldName)[i].parentElement.parentElement;
			$(t).addClass("hide");
		}
	}	
}
function checkFields(e) {
	//valida o que vai ser
	console.log(e.which,e.keyCode);
	if (e.keyCode == 13) {
        // var tb = document.getElementById("scriptBox");
        // eval(tb.value);
        alert("A");
        return false;
    }
	// return false;
}
function activeItem (item,table,obj) {
	console.log(item,table,obj);
	console.log('api/index.php?type=activeItem&idItem='+item+'&category='+table+'&timestamp='+Math.floor((Math.random()*1000000)+100));
	$.getJSON('api/index.php?type=activeItem&idItem='+item+'&category='+table+'&timestamp='+Math.floor((Math.random()*1000000)+100), function(data) {
		console.log(data[0].status);
		console.log($(obj).parents("li.resultItem"));
		console.log("Item:  "+data[0].reason);
		if(data[0].response == "true"){
			if (data[0].reason == "active") {
				$(obj).parents("li.resultItem").removeClass("desactive");
			} else if (data[0].reason == "desactive") {
				$(obj).parents("li.resultItem").addClass("desactive");
			}
		} else {
			console.log("Item não desativado "+data[0].reason);
		}
	});
}
function checkSearch(id,text,field,table) {
	console.log("checking...",id,text,field,table);
	console.log('api/index.php?type=checkSearch&idItem='+id+'&table='+table+'&field='+field+'&text='+text);
	$.getJSON('api/index.php?type=checkSearch&idItem='+id+'&table='+table+'&field='+field+'&text='+text, function(data) {
		console.log(data[0].response);
		if(data[0].response == "true"){
			//console.log("true");
			return true;
		} else {
			//console.log("fala");
			return false;
		}
	});
}
function updateInput(value,target) {
	$("input[name=txt"+target+"]").val(value);
}
//onKeyPress="return(formata_valor(this,'.',',',8,2,event))";
function format_price(fld, milSep, decSep, qtint, qtdec, e){
	//desativando a funcao
	return true;
	// fld = campo receptor da digita
	// milsep = caracter para separar de milhar: "." ou ","
	// decsep = caracter para separar decimal: "," ou "."
	// qtint = quantidade de caracteres inteiros
	// qtdec = quantidade de caracteres decimais
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '-0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;
	if (whichCode == 13)
		return true;  // Enter
	key = String.fromCharCode(whichCode);  // Get key value from key code
	if (strCheck.indexOf(key) == -1)
		return false;  // Not a valid key
	len = fld.value.length;
	for(i = 0; i < len; i++)
		if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep))
			break;
	aux = '';
	for(; i < len; i++)
		if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
	aux += key;
	len = aux.length;
	
	if (len > (qtint + qtdec)) 
		return true; // digitou o m ximo de caracteres permitido

	if (len <= qtdec)
	{  // monta caracteres decimais
		fld.value = '0' + decSep;
		for (j = (qtdec - len - 1); j >= 0; j--)
  			fld.value = fld.value + '0';
		fld.value = fld.value + aux;
	}	
	else   // está digitando a parte inteira
	{  
		aux2 = '';
	  	for (j = 0, i = len - (qtdec + 1) ; i >= 0; i--)
		{
    		if (j == 3) // checa separação de milhares
			{  
      			aux2 += milSep;
      			j = 0;
   			}
    		aux2 += aux.charAt(i);
    		j++;
  		}
	  	fld.value = '';
  		len2 = aux2.length;  // só a parte inteira
  		for (i = len2 - 1; i >= 0; i--)
  			fld.value += aux2.charAt(i);
  		fld.value += decSep + aux.substr((len - qtdec), len);
  	}
	return false;
}
//  End -->

$.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
		var that = this,
		currentCategory = "";
		$.each( items, function( index, item ) {
			if ( item.category != currentCategory ) {
				ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
        		currentCategory = item.category;
        	}
        	that._renderItemData( ul, item );
		});
	}
});
$.widget( "custom.combobox", {
  _create: function() {
    this.wrapper = $( "<span>" )
      .addClass( "custom-combobox" )
      .insertAfter( this.element );

    this.element.hide();
    this._createAutocomplete();
    this._createShowAllButton();
  },

  _createAutocomplete: function() {
    var selected = this.element.children( ":selected" ),
      value = selected.val() ? selected.text() : "",
      nameInput = (selected.context.id);
    this.input = $( "<input>" )
      .attr("name",nameInput)
      .appendTo( this.wrapper )
      .val( value )
      .attr( "title", "" )
      .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
      .autocomplete({
        delay: 0,
        minLength: 0,
        source: $.proxy( this, "_source" )
      })
      .tooltip({
        tooltipClass: "ui-state-highlight"
      });
    this._on( this.input, {
      autocompleteselect: function( event, ui ) {
      	//WHEN WORK
      	//TODO: change next input value
      	
        ui.item.option.selected = true;
        this._trigger( "select", event, {
          item: ui.item.option
        });
        switch ($(ui.item.option.parentElement).attr("id")) {
      		case "manufacturerName":
	      		var optTemp, optOptMan, optManufacturerName, optColorMan;
	      		console.log('api/index.php?type=askModel&mainId='+ui.item.option.value);
	  			$.getJSON('api/index.php?type=askModel&mainId='+ui.item.option.value, function(data) {
					$.each(data, function(key, val) {
						optTemp += '<option value="'+val.id+'" >'+val.label+'</option>';
					});
					$("#modelName option").remove();
					$("#modelName").append(optTemp);
					$("#modelName").parent().find("input").val("");
					$("#modelId").val("");

					$("#versionName option").remove();
					$("#versionName").parent().find("input").val("");
					$("#versionId").val("");
				});
				$("#manufacturerId").val(ui.item.option.value);
				//TODO: change opts
				// console.log("api/index.php?type=askOption&manufacturerId="+ui.item.option.value);
				$.getJSON("api/index.php?type=askOption&manufacturerId="+ui.item.option.value, function(data) {
					$.each(data, function(key, val) {
						optOptMan += '<option value="'+val.id+'" >'+val.label+'</option>';
						optManufacturerName = val.manufacturerName;
					});
					$("#txtOptionsName option").remove();
					$("#txtOptionsName").append(optOptMan);
					//$("#txtOptionsName").parent().find("input").val("Opcionais de "+optManufacturerName);
				});
				$.getJSON("api/index.php?type=askColor&manufacturerId="+ui.item.option.value, function(data) {
					$.each(data, function(key, val) {
						optColorMan += '<option value="'+val.id+'" >'+val.label+'</option>';
						optManufacturerName = val.manufacturerName;
					});
					$("#colorName option").remove();
					$("#colorName").append(optColorMan);
					//$("#colorName").parent().find("input").val("Opcionais de "+optManufacturerName);
				});
	      		break;
      		case "modelName":
      			var optTemp;
	  			$.getJSON('api/index.php?type=askVersion&mainId='+ui.item.option.value, function(data) {
					$.each(data, function(key, val) {
						// console.log(val.label,"====",ui.item.option.value,"_----"+val.idSegment1);
						optTemp += '<option value="'+val.id+'" >'+val.label+'</option>';
						$("#idSegment1").parent().find("input").val(val.idSegment1);
						$("input[name=idSegment1]").val(val.segmentName1);
						$("#idSegment2").parent().find("input").val(val.idSegment2);
						$("input[name=idSegment2]").val(val.segmentName2);
						$("#idSegment3").parent().find("input").val(val.idSegment3);
						$("input[name=idSegment3]").val(val.segmentName3);
					});
					$("#versionName option").remove();
					$("#versionName").append(optTemp);
					$("#versionName").parent().find("input").val("");
				});
				$("#modelId").val(ui.item.option.value);
	      		break;
      		case "versionName":
      			//change modelName 
      			$("#versionId").val(ui.item.option.value);
	      		break;
			case "txtOptionsName":
				var optTemp;
				// console.log('api/index.php?type=askOptionValue&optId='+ui.item.option.value+'&rand='+Math.floor((Math.random()*1000000)+100));
	  			$.getJSON('api/index.php?type=askOptionValue&optId='+ui.item.option.value+'&rand='+Math.floor((Math.random()*1000000)+100), function(data) {
					$.each(data, function(key, val) {
						$("#txtOptOldName").val(decodeURIComponent(val.value.replace(/\+/g,' ')));
						$("#txtOptionsCode").val(val.code);
						$("#txtOptionsCode").attr("disabled",true);
						$("#txtOptionsPrice").val(val.price);
						$("#txtOptionsPrice").attr("disabled",false);
						$("#textAreaOptionsAdd").val(decodeURIComponent(val.optValue.replace(',',';\n').replace(/\+/g,' ')));
						$("#textAreaOptionsAdd").text(decodeURIComponent(val.optValue).replace(/\+/g,' '));
						$("#textAreaOptionsAdd").attr("disabled",true);
						$("#btnOptionsAdd").attr("disabled",false);
						$("#optBlockSave").addClass("hide");
						$("#optBlockEdit").removeClass("hide");
						$("#txtOptNumCheck").val("");
					});
				});
				$("#txtOptionsId").val(ui.item.option.value);
	    		break;
	    	case "idSegment1":
	    		updateInput(ui.item.option.value,'idSegment1');
	    		break;
	    	case "idSegment2":
	    		updateInput(ui.item.option.value,'idSegment2');
	    		break;
	    	case "idSegment3":
	    		updateInput(ui.item.option.value,'idSegment3');
	    		break;
	    	case "colorName":
	    		var optTemp;
				// console.log('api/index.php?type=askColorValue&optId='+ui.item.option.value);
	  			$.getJSON('api/index.php?type=askColorValue&optId='+ui.item.option.value+'&rand='+Math.floor((Math.random()*1000000)+100), function(data) {
					$.each(data, function(key, val) {
						$("#colorId").val(val.id),
						$("#txtColorName").val(val.value);
						// $("#colorName").parent().find("input[name=colorName]").val(val.value);
						$("#colorSelected").val(val.hexa);
						$("#colorSelected").attr("disabled",true);
						$("#colorPrice").val(val.price);
						// $("#colorPrice").attr("disabled",false);
						$("#colorCode").val(val.code);
						$("#colorCode").attr("disabled",true);
						$("#colorType").val(val.type),
						$("#colorType").parent().find("input[name=colorType]").val(val.type);
						$("#colorSelector div").css("backgroundColor", "#"+val.hexa);
					});
				});
				$("#txtOptionsId").val(ui.item.option.value);
				$("#blockColorSelector").removeClass("hide");
				$("#colorBlockEdit").removeClass("hide");
	    		break;


      	}
      },
      autocompletechange: "_removeIfInvalid",
      focus: "_focus"
    });
  },

  _createShowAllButton: function() {
    var input = this.input,
      wasOpen = false;

    $( "<a>" )
      .attr( "tabIndex", -1 )
      .attr( "title", "Mostrar todas as opções" )
      .tooltip()
      .appendTo( this.wrapper )
      .button({
        icons: {
          primary: "ui-icon-triangle-1-s"
        },
        text: false
      })
      .removeClass( "ui-corner-all" )
      .addClass( "custom-combobox-toggle ui-corner-right" )
      .mousedown(function() {
        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
      })
      .click(function() {
        input.focus();

        // Close if already visible
        if ( wasOpen ) {
          return;
        }

        // Pass empty string as value to search for, displaying all results
        input.autocomplete( "search", "" );
      });
  },

  _source: function( request, response ) {
    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
    response( this.element.children( "option" ).map(function() {
      var text = $( this ).text();
      if ( this.value && ( !request.term || matcher.test(text) ) )
        return {
          label: text,
          value: text,
          option: this
        };
    }) );
  },

  _removeIfInvalid: function( event, ui ) {
  	//TODO: apagar o campo id se o que for digitado nao bater - ok
    //return;

    ////////////////--------IF OPTION DONT MATCH, CLEAR THE FIELD ---------///////////////
    ////////////---------- BEGIN CLEAR INVALID FIELD
    
    // Selected an item, nothing to do
    if ( ui.item ) {
    	//console.log(ui.item.option.value,$(ui.item.option.parentElement).attr("name"))
    	//$(ui.item.option.parentElement).attr("name")
      return;
    }
    // Search for a match (case-insensitive)
    var value = this.input.val(),
      valueLowerCase = value.toLowerCase(),
      valid = false;
    this.element.children( "option" ).each(function() {
      if ( $( this ).text().toLowerCase() === valueLowerCase ) {
        this.selected = valid = true;
        return false;
      }
    });

    // Found a match, nothing to do
    if ( valid ) {
      return;
    }
    	// console.log($(this.input),this.input[0].name);


	switch (this.input[0].name) {
    	case "manufacturerName":
    		if ($("#action").val() == "new" || $("#action").val() == "clone") {
	    		$("#manufacturerId").val("");
	    		$("#modelId").val("");
	    		$("#versionId").val("");
	    	}
	    	break;
    	case "modelName":
	    	if ($("#action").val() == "new" || $("#action").val() == "clone") {
	    		$("#modelId").val("");
    			$("#versionId").val("");
	    	}
    		break;
		case "versionName":
			if ($("#action").val() == "new" || $("#action").val() == "clone") {
				$("#versionId").val("");
			}
			break;
		case "txtOptionsName":
			if ($("#optBlockSave").is(".hide")) {
				$("#txtOptionsId").val("");
				$("#textAreaOptionsAdd").attr("disabled",false);
				$("#textAreaOptionsAdd").val("");
				$("#textAreaOptionsAdd").text("");
				$("#txtOptionsCode").attr("disabled",false);
				$("#txtOptionsCode").val("");
				$("#txtOptionsPrice").attr("disabled",false);
				$("#txtOptionsPrice").val("");
				$("#optBlockSave").addClass("hide");
				$("#optBlockEdit").addClass("hide");
				$("#txtOptionsCode").focus();
			}
			break;
		case "idSegment1":
			//add no bd
			updateInput('','idSegment1');
			break;
		case "idSegment2":
			updateInput('','idSegment2');
			break;
		case "idSegment3":
			updateInput('','idSegment3');
			break;
		case "colorName":
			$("#colorId").val("");
			$("#txtColorName").val("");
			$("#colorSelected").val("");
			$("#colorSelected").attr("disabled",false);
			$("#colorPrice").val("");
			$("#colorPrice").attr("disabled",false);
			$("#colorCode").val("");
			$("#colorCode").attr("disabled",false);
			// $("#colorType").val(val.type),
			// $("#colorType").parent().find("input[name=colorType]").val(val.type);
			$("#colorSelector div").css("backgroundColor", "#fff");
			break;
    }
    /*
    // Remove invalid value
    this.input
      .val( "" )
      .attr( "title", value + " nenhum item encontrado" )
      .tooltip( "open" );
    this.element.val( "" );
    this._delay(function() {
      this.input.tooltip( "close" ).attr( "title", "" );
    }, 2500 );
    this.input.data( "ui-autocomplete" ).term = "";
    */
    //////////////---------- END CLEAR INVALID FIELD
  },
  _focus: function( event, ui ) {
	/*
  	console.log(event,ui);
		$("#textAreaOptionsAdd").val(ui.item.optValue);
		$("#txtOptionsId").val(ui.item.id);
		$("#txtOptionsPrice").val(ui.item.price);
		$("#txtOptionsCode").val(ui.item.code);
*/
	},

  _destroy: function() {
    this.wrapper.remove();
    this.element.show();
  }
});
$(function() {
	function log( message ) {
		$( "<div>" ).text( message ).prependTo( "#log" );
		$( "#log" ).scrollTop( 0 );
	}
	$( "#askInput" ).catcomplete({
		source: "api/index.php?type=askInput",
		delay:5,
		minLength: 0,
		select: function( event, ui ) {
			log( ui.item ?
				"Selected: " + ui.item.id + " aka " + ui.item.value + " category " + ui.item.category:
				"Nothing selected, input was " + this.value );
			//each category will print a diferent result w/ links
			//console.log('api/index.php?type=terms&term='+ui.item.value+'&idField='+ui.item.id+'&table='+ui.item.table);
			$.getJSON('api/index.php?type=terms&term='+ui.item.value+'&idField='+ui.item.id+'&table='+ui.item.table, function(data) {
				$(".resultData ul li").remove();
					$.each(data, function(key, val) {
						if (val.active == "n") {
							data = '<li class="resultItem desactive" idDB="'+val.featureId+'">';
						} else {
							data = '<li class="resultItem " idDB="'+val.featureId+'">';
						}
						data += '<div class="rsItems">';
						switch (val.category) {
							case "manufacturer":
								data += '<a class="btnClone btnButton" href="formDetails.php?category=model&action=new&vehicle='+val.idItem+'" title="Incluir Modelo para esta Montadora" alt="Incluir Modelo para esta Montadora">Novo modelo</a>';
								data += '<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem('+val.idItem+',\'manufacturer\',this)"></div>';
							break;
							case "model":
								data += '<a class="btnClone btnButton" href="formDetails.php?category=version&action=new&vehicle='+val.idItem+'" title="Incluir Versão para este Modelo" alt="Incluir Versão para este Modelo">Nova versão</a>';
								data += '<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem('+val.idItem+',\'model\',this)"></div>';
							break;
							case "version":
								data += '<a class="btnClone btnButton" href="formDetails.php?category=feature&action=new&vehicle='+val.idItem+'" title="Incluir Ficha Técnica para esta Versão" alt="Incluir Ficha Técnica para esta Versão">Nova Ficha</a>';
								data += '<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem('+val.idItem+',\'version\',this)"></div>';
							break;
							case "feature":
								data += '<a class="btnClone btnButton" href="formDetails.php?category=feature&action=clone&vehicle='+val.idItem+'" title="Copiar todos os dados para um novo cadastro" alt="Copiar todos os dados para um novo cadastro">Clonar</a>';
								data += '<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem('+val.idItem+',\'feature\',this)"></div>';
							break;
						}
						data += '</div>'+
						'<a href="formDetails.php?vehicle='+val.idItem+'&category='+val.category+'&search=" class="resultContent">'+
							'<div class="rsManufacturer" title="'+val.manufacturerName+'">'+val.manufacturerName+'</div>';
						if (val.category == "model" || val.category == "version" || val.category == "feature") {
						data += '<div class="rsModel" title="'+val.modelName+'">'+val.modelName+'</div>';
						}
						if (val.category == "feature" || val.category == "version") {
						data += '<div class="rsVersion" title="'+val.versionName+'">'+val.versionName+'</div>';
						}
						if (val.category == "feature") {
						data +='<div class="rsYearModel" title="'+val.yearModel+'">'+val.yearModel+'</div>'+
							'<div class="rsYearProduced" title="'+val.yearProduced+'">'+val.yearProduced+'</div>'+
							'<div class="rsEngine" title="'+val.engine+'">'+val.engine+'</div>'+
							'<div class="rsGear" title="'+val.gear+'">'+val.gear+'</div>'+
							'<div class="rsFuel" title="'+val.fuel+'">'+val.fuel+'</div>'+
							'<div class="rsSteering" title="'+val.steering+'">'+val.steering+'</div>'+
							'<div class="rsSegment" title="'+val.segment1+'">'+val.segment1+'</div>'+
							'<div class="rsSegment" title="'+val.segment2+'">'+val.segment2+'</div>'+
							'<div class="rsSegment" title="'+val.segment3+'">'+val.segment3+'</div>';
						}
						data+='</a>'+
						'</li>';
						$(".resultData ul").append(data);
					});

				$(".resultContent").click(function(){
					openDetails($(this).attr("iddb"));
				});
			});
		},
		open: function(event,ui) {
			console.log("open");
		},
		close: function() {
			//console.log("close");
		}
	});

	$( "#manufacturerName" ).catcomplete({
		source: "api/index.php?type=askManuf",
		delay:1,
		minLength: 0,
		autoFocus: true,
		select: function( event, ui ) {
			//change id
			$("#manufacturerId").val(ui.item.id);
			manufacturerIdGlobal = ui.item.id;
		}
	});
	$("#modelName").focusin(function() {
		$( "#modelName" ).catcomplete({
			source: "api/index.php?type=askModel&mainId="+$("#manufacturerId").val(),
			delay:1,
			minLength: 0,
			select: function( event, ui ) {
				//change id
				$("#modelId").val(ui.item.id);
			}
		});
	});
	$("#versionName").focusin(function() {
		$( "#versionName" ).catcomplete({
			source: "api/index.php?type=askVersion&mainId="+$("#modelId").val(),
			delay:1,
			minLength: 0,
			select: function( event, ui ) {
				//change id
				$("#versionId").val(ui.item.id);
			}
		});
	});
	$( "#colorType" ).catcomplete({
		source: "json/colorAplication.json",
		delay:1,
		minLength: 0,
		select: function( event, ui ) {
			//change id
			//$("#versionId").val(ui.item.id);
		}
	});
	$("#txtOptionsName").focusin(function(){
		console.log("JIJIJIJIJI");
		$( "#txtOptionsName" ).catcomplete({
			source: "api/index.php?type=askOption&manufacturerId="+$("#manufacturerId").val(),
			delay:1,
			minLength: 0,
			select: function( event, ui ) {
				//change id
				//$("#versionId").val(ui.item.id);
			},
			focus: function( event, ui ) {
				$("#textAreaOptionsAdd").val(ui.item.optValue);
				$("#textAreaOptionsAdd").text(ui.item.optValue);
				$("#txtOptionsId").val(ui.item.id);
				$("#txtOptionsPrice").val(ui.item.price);
				$("#txtOptionsCode").val(ui.item.code);
			}
		});
	});
	$( "#manufacturerName" ).combobox();
	$( "#modelName" ).combobox();
	$( "#versionName" ).combobox();
	$( "#idSegment1" ).combobox();
	$( "#idSegment2" ).combobox();
	$( "#idSegment3" ).combobox();
	$( "#txtFuel" ).combobox();
	// $( "#txtGear").combobox();
	$( "#txtOptionsName" ).combobox();
	$("#colorName").combobox();
	$( "#colorAplication" ).combobox();
	$( "#colorType" ).combobox();
	$("#countryOrigin").combobox();
	
//	codOpt = $("#txtOptionsCode").val();
//		name = $("#txtOptionsName").val();
//		manufacturerId = $("#manufacturerId").val();
});


























