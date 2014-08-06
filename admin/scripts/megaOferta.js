$(document).ready(function(){
  $("#manufacturerName").combobox();
  $("#modelName").combobox();
  $("#versionName").combobox();

  $(".addMegaDate").focusin(function(){
    if ($(this).is(".hasDatepicker") == false) {
      $(this).datepicker();
      $(this).datepicker( "option", "dateFormat", "yy-mm-dd" );
    }
  });
  
  $("#picture").change(function(e){
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

  $("#btnAddMegaOferta").click(function(){
    // TODO: validar da onde que vem a imagem, se tiver .jpg é do server novo, senao adicionar o _p
    manufacturerId = $("#manufacturerId").val(), 
    modelId = $("#modelId").val(),
    versionId = $("#versionId").val(), 
    featureId = $("#featureId").val(), 
    price = $("#price").val(), 
    yearModel = $("#yearModel").val(), 
    place = $("#place:checked").val(), 
    description = $("#description").val(), 
    picture = $("#picture").val(), 
    dateIni = $("#dateIni").val(),
    dateLimit = $("#dateLimit").val(),
    name = $("input[name=manufacturerName]").val()+" - "+$("input[name=modelName]").val()+" - "+$("input[name=versionName]").val();

   console.log('api/index.php?type=megaAdd&manufacturerId='+manufacturerId+'&modelId='+modelId+'&versionId='+versionId+'&featureId='+featureId+'&price='+price+'&yearModel='+yearModel+'&place='+place+'&description='+description+'&picture='+picture+'&dateIni='+dateIni+'&dateLimit='+dateLimit);
    $.getJSON('api/index.php?type=megaAdd&manufacturerId='+manufacturerId+'&modelId='+modelId+'&versionId='+versionId+'&featureId='+featureId+'&price='+price+'&yearModel='+yearModel+'&place='+place+'&description='+description+'&picture='+picture+'&dateIni='+dateIni+'&dateLimit='+dateLimit, function(data) {
      if(data[0].response == "true"){
        console.log("item adicionado");
        $(".ulMO").append('<li class="liMO"><img src="http://carsale.uol.com.br/foto/'+picture+'_p.jpg" /><span>'+name+'</span><span>'+price+'</span><div class="removeItem" onclick="removeItemMega(this,"'+data[0].insertId+'")">remover</div></li>');
      } else {
        // alert(data[0].reason);
        console.log(data[0].reason);
      }
    });
  });
});
  
  function orderMega(obj,type,idItem) {
    //TO DO: change li order at front 
    numOrder = $(obj).parent().children("#numberOrder").text();
    if (type == "downOrder") {
      numOrder--;
    } else if (type == "upOrder") {
      numOrder++;
    } else {
      numOrder = 0;
    }
    console.log(numOrder);
    if (numOrder > 0 ){
      $.getJSON('api/index.php?type=upOrder&mainId='+idItem+'&numOrder='+numOrder, function(data) {
        if (data[0].response == "true") {
          $(obj).parent().children("#numberOrder").text(numOrder);
          //$(obj).parent().children("#downOrder").attr("onclick","orderMega(this,'downOrder','"+idItem+"','"+numOrder+"')");
          //$(obj).parent().children("#upOrder").attr("onclick","orderMega(this,'upOrder','"+idItem+"','"+numOrder+"')");
        }
      });
    }
  }

  function removeItemMega (obj,idItem){
    // console.log($(obj).parent());
    console.log('api/index.php?type=megaRemove&idItem='+idItem);
    $.getJSON('api/index.php?type=megaRemove&idItem='+idItem, function(data) {
      if(data[0].response == "true"){
        console.log(data[0].reason);
        $(obj).parent().remove();
      } else {
        // alert(data[0].reason);
        console.log(data[0].reason);
      }
    });
  }

  function updateItemMega (obj,idItem) {
    //catch all data from <li>
    $(".liMO").removeClass("checkedEditMega");
    numOrder = $(obj).parent().children("#numberOrder").text();
    //$(obj).parent().children("");
    //console.log('api/index.php?type=searchMega&idItem='+idItem);
    $.getJSON('api/index.php?type=searchMega&idItem='+idItem, function(data) {
      if(data[0].response == "true"){
        //put on form
        yearModel = data[0].yearModel;
        $("#megaOfertaId").val(data[0].megaOfertaId);
        $("#manufacturerId").val(data[0].manufacturerId);
        $("#manufacturerName").parent().find("input[name=manufacturerName]").val(data[0].manufacturerName);
        $("#modelId").val(data[0].modelId );
        $("#modelName").parent().find("input[name=modelName]").val(data[0].modelName);
        $("#versionId").val(data[0].versionId);
        $("#versionName").parent().find("input[name=versionName]").val(data[0].versionName);
        $("#price").val(data[0].price);
        if (data[0].place == "carousel") { $("#place").attr("checked","checked"); } else { $("#place").removeAttr("checked"); }
        $("#orderMega").val(data[0].orderMega);
        //$("#yearModel").val(data[0].yearModel);
        $.getJSON('api/index.php?type=askYear&mainId=&manufacturerId='+$("#manufacturerId").val()+'&modelId='+$("#modelId").val()+'&versionId='+data[0].versionId, function(data) {
          $("#yearModel option").remove();
          $.each(data, function(key, val) {
            if (val.yearModel == yearModel) { 
              optCheck = 'selected="selected"'; 
            } else {
              optCheck = ''; 
            }
            optYear = '<option value="'+val.yearModel+'" '+optCheck+'>'+val.yearModel+'</option>';
            $("#yearModel").append(optYear);
          });
        });
        $("#description").val(data[0].description);
        //$(".image-preview").attr("style","background-image:url(../carImagesMegaOferta/"+data[0].picture+")");
        $("#btnAddMegaOferta").val("Atualizar");
        if ($("#cancelRequest").length == 0) {
          $("#btnAddMegaOferta").parent(".megaInputs").append('<input type="button" id="cancelRequest" value="Cancelar" />');
          $("#cancelRequest").click(function(){
            $("#btnAddMegaOferta").val("Adicionar");
            $(this).remove();
            $(".liMO").removeClass("checkedEditMega");
          });
        }
        $(obj).parent(".liMO").addClass("checkedEditMega");
      }
    });
    
    //window.scrollTo(0,0);
    //form submit need check if exist
  }

  function showFeature (){
    vehicle = $("#versionId").val();
    yearModel = $("#yearModel").val();
    $("#versionDetails").attr("href","./formDetails.php?vehicle="+vehicle+"&yearModel="+yearModel+"&category=feature&action=viewVersion");
    $("#versionDetails").removeClass("hide");
  }

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
      	//TODO: change next input value
      	
        ui.item.option.selected = true;
        this._trigger( "select", event, {
          item: ui.item.option
        });

        switch ($(ui.item.option.parentElement).attr("id")) {
      		case "manufacturerName":
	      		var optTemp, optOptMan, optManufacturerName;
	  			$.getJSON('api/index.php?type=askModel&mainId='+ui.item.option.value, function(data) {
					 $.each(data, function(key, val) {
						  optTemp += '<option value="'+val.id+'" >'+val.label+'</option>';
					 });
					$("#modelName option").remove();
					$("#modelName").append(optTemp);
					// $("#modelName").parent().find("input").val("");
					$("#modelId").val("");

					$("#versionName option").remove();
					// $("#versionName").parent().find("input").val("");
					$("#versionId").val("");
          $("#manufacturerId").val(ui.item.option.value);
          $("#versionDetails").addClass("hide");
          $("#yearModel option").remove();
          $("#yearModel").append('<option value="" >Escolha o modelo</option>');
				});
				//TODO: change opts
	      		break;
      	case "modelName":
      			var optTemp;
            console.log('api/index.php?type=askVersionMega&mainId='+ui.item.option.value);
	  			$.getJSON('api/index.php?type=askVersionMega&mainId='+ui.item.option.value, function(data) {
  					$.each(data, function(key, val) {
  						console.log(val.label,"====",ui.item.option.value,"_----"+val.idSegment1);
  						optTemp += '<option value="'+val.id+'" >'+val.label+'</option>';
  					});
  					$("#versionName option").remove();
  					$("#versionName").append(optTemp);
  					// $("#versionName").parent().find("input").val("");
          });
          $("#modelId").val(ui.item.option.value);
          $("#versionDetails").addClass("hide");
          $("#yearModel option").remove();
          $("#yearModel").append('<option value="" >Escolha a versão</option>');
	      	break;
    		case "versionName":
    			//change modelName
          //console.log('api/index.php?type=askYear&mainId=&manufacturerId='+$("#manufacturerId").val()+'&modelId='+$("#modelId").val()+'&versionId='+ui.item.option.value);
          $("#yearModel option").remove();
          $("#yearModel").append('<option value="" >Escolha o ano</option>');
          console.log('api/index.php?type=askYear&mainId=&manufacturerId='+$("#manufacturerId").val()+'&modelId='+$("#modelId").val()+'&versionId='+ui.item.option.value);
        $.getJSON('api/index.php?type=askYear&mainId=&manufacturerId='+$("#manufacturerId").val()+'&modelId='+$("#modelId").val()+'&versionId='+ui.item.option.value, function(data) {
          $.each(data, function(key, val) {
            console.log(val.yearModel,"====",ui.item.option.value,"_----");
            $("#yearModel").append('<option value="'+val.yearModel+'" >'+val.yearModel+'</option>');
          });
    			$("#versionId").val(ui.item.option.value);
          $("#versionDetails").addClass("hide");
        });
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
    		$("#manufacturerId").val("");
    		//$("#modelId").val("");
    		//$("#versionId").val("");
	    	break;
    	case "modelName":
    		$("#modelId").val("");
    		//$("#versionId").val("");
    		break;
		case "versionName":
			$("#versionId").val("");
			break;
		case "txtOptionsName":
			$("#txtOptionsId").val("");
			$("#textAreaOptionsAdd").attr("disabled",false);
			$("#textAreaOptionsAdd").val("");
			$("#textAreaOptionsAdd").text("");
			$("#txtOptionsCode").attr("disabled",false);
			$("#txtOptionsCode").val("");
			$("#txtOptionsPrice").attr("disabled",false);
			$("#txtOptionsPrice").val("");
			$("#txtOptionsCode").focus();
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

















