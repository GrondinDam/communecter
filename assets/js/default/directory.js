
var indexStepInit = 30;
var indexStep = indexStepInit;
var currentIndexMin = 0;
var currentIndexMax = indexStep;
var scrollEnd = false;
var totalData = 0;

var timeout = null;

function startSearch(indexMin, indexMax){
    
    if(loadingData) return;
    loadingData = true;
    
    //console.log("loadingData true");
    indexStep = indexStepInit;

    console.log("startSearch", indexMin, indexMax, indexStep);

	  var name = $('#searchBarText').val();
    
    if(name == "" && searchType.indexOf("cities") > -1) return;  

    if(typeof indexMin == "undefined") indexMin = 0;
    if(typeof indexMax == "undefined") indexMax = indexStep;

    currentIndexMin = indexMin;
    currentIndexMax = indexMax;

    if(indexMin == 0 && indexMax == indexStep) {
      totalData = 0;
      mapElements = new Array(); 
    }
    else{ if(scrollEnd) return; }
    
    if(name.length>=3 || name.length == 0){
      var locality = "";
      if(communexionActivated){
	    if(typeof(cityInseeCommunexion) != "undefined"){
			if(levelCommunexion == 1) locality = cpCommunexion;
			if(levelCommunexion == 2) locality = inseeCommunexion;
		}else{
			if(levelCommunexion == 1) locality = inseeCommunexion;
			if(levelCommunexion == 2) locality = cpCommunexion;
		}
        //if(levelCommunexion == 3) locality = cpCommunexion.substr(0, 2);
        if(levelCommunexion == 3) locality = inseeCommunexion;
        if(levelCommunexion == 4) locality = inseeCommunexion;
        if(levelCommunexion == 5) locality = "";
      } 
      autoCompleteSearch(name, locality, indexMin, indexMax);
    }else{
      
    }   
}


function addSearchType(type){
  $.each(allSearchType, function(key, val){
    removeSearchType(val);
  });

  var index = searchType.indexOf(type);
  if (index == -1) {
    searchType.push(type);
    //$(".search_"+type).removeClass("active"); //fa-circle-o");
    $(".search_"+type).addClass("active"); //fa-check-circle-o");
  }
}


function removeSearchType(type){
  var index = searchType.indexOf(type);
  if (index > -1 && searchType.length > 1) {
    searchType.splice(index, 1);
    $(".search_"+type).removeClass("active"); //fa-check-circle-o");
    //$(".search_"+type).addClass("fa-circle-o");
  }
}

var loadingData = false;
var mapElements = new Array(); 


function autoCompleteSearch(name, locality, indexMin, indexMax){
	if(typeof(cityInseeCommunexion) != "undefined"){
	    var levelCommunexionName = { 1 : "CODE_POSTAL_INSEE",
	                             2 : "INSEE",
	                             3 : "DEPARTEMENT",
	                             4 : "REGION"
	                           };
	}else{
		var levelCommunexionName = { 1 : "INSEE",
	                             2 : "CODE_POSTAL_INSEE",
	                             3 : "DEPARTEMENT",
	                             4 : "REGION"
	                           };
	}
    //console.log("levelCommunexionName", levelCommunexionName[levelCommunexion]);
    var data = {
      "name" : name, 
      "locality" : "",//locality, 
      "searchType" : searchType, 
      "searchTag" : $('#searchTags').val().split(','), //is an array
      "searchLocalityCITYKEY" : $('#searchLocalityCITYKEY').val().split(','),
      "searchLocalityCODE_POSTAL" : $('#searchLocalityCODE_POSTAL').val().split(','), 
      "searchLocalityDEPARTEMENT" : $('#searchLocalityDEPARTEMENT').val().split(','),
      "searchLocalityREGION" : $('#searchLocalityREGION').val().split(','),
      "searchBy" : levelCommunexionName[levelCommunexion], 
      "indexMin" : indexMin, 
      "indexMax" : indexMax  };
				
    loadingData = true;
    
    str = "<i class='fa fa-circle-o-notch fa-spin'></i>";
    $(".btn-start-search").html(str);
    $(".btn-start-search").addClass("bg-azure");
    $(".btn-start-search").removeClass("bg-dark");
    
    if(indexMin > 0)
      $("#btnShowMoreResult").html("<i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...");
    else
      $("#dropdown_search").html("<span class='search-loader text-dark' style='font-size:20px;'><i class='fa fa-spin fa-circle-o-notch'></i> Recherche en cours ...</span>");
      
    if(isMapEnd)
      $.blockUI({
        message : "<h1 class='homestead text-red'><i class='fa fa-spin fa-circle-o-notch'></i> Commune<span class='text-dark'>xion en cours ...</span></h1>"
      });
   
    $.ajax({
      type: "POST",
          url: baseUrl+"/" + moduleId + "/search/globalautocomplete",
          data: data,
          dataType: "json",
          error: function (data){
             console.log("error autocomplete search"); console.dir(data);     
             //signal que le chargement est terminé
            loadingData = false;     
          },
          success: function(data){ console.log("success autocomplete search"); //console.dir(data);
            if(!data){ toastr.error(data.content); }
            else
            {
              var countData = 0;
            	$.each(data, function(i, v) { if(v.length!=0){ countData++; } });
              
              totalData += countData;
            
              str = "";
              var city, postalCode = "";

              //parcours la liste des résultats de la recherche
              console.dir(data);
              $.each(data, function(i, o) {
                  var typeIco = i;
                  var ico = mapIconTop["default"];
                  var color = mapColorIconTop["default"];

                  mapElements.push(o);

  				        typeIco = o.type;
                  
                  ico = ("undefined" != typeof mapIconTop[typeIco]) ? mapIconTop[typeIco] : mapIconTop["default"];
                  color = ("undefined" != typeof mapColorIconTop[typeIco]) ? mapColorIconTop[typeIco] : mapColorIconTop["default"];
                  
                  var htmlIco ="<i class='fa "+ ico +" fa-2x bg-"+color+"'></i>";
                 	if("undefined" != typeof o.profilThumbImageUrl && o.profilThumbImageUrl != ""){
                    htmlIco= "<img width='80' height='80' alt='' class='img-circle bg-"+color+"' src='"+baseUrl+o.profilThumbImageUrl+"'/>"
                  }

                  city="";

                  var postalCode = o.cp
                  if (o.address != null) {
                    city = o.address.addressLocality;
                    postalCode = o.cp ? o.cp : o.address.postalCode ? o.address.postalCode : "";
                  }
                  
                  //console.dir(o);
                  var id = getObjectId(o);
                  var insee = o.insee ? o.insee : "";
                  type = typeObj[o.type].col;
                  // var url = "javascript:"; // baseUrl+'/'+moduleId+ "/default/simple#" + type + ".detail.id." + id;
                  //type += "s";
                  var url = '#news.index.type.'+type+'.id.' + id;
                  if(type == "citoyens") url += '.viewer.' + userId;
                  if(type == "cities") url = "#city.detail.insee."+o.insee+".postalCode."+o.cp;
                  if(type == "surveys") url = "#survey.entry.id."+id;
                  if(type == "actions") url = "#rooms.action.id."+id;

                  //if(type=="citoyen") type = "person";
                 
                  var onclick = 'loadByHash("' + url + '");';

                  var onclickCp = "";
                  var target = " target='_blank'";
                  var dataId = "";
                  if(type == "city"){
                  	url = "javascript:"; //#main-col-search";
                  	onclick = 'setScopeValue($(this))'; //"'+o.name.replace("'", "\'")+'");';
                  	onclickCp = 'setScopeValue($(this));';
                  	target = "";
                    dataId = o.name; //.replace("'", "\'");
                  }

                  var tags = "";
                  if(typeof o.tags != "undefined" && o.tags != null){
          					$.each(o.tags, function(key, value){
          						if(value != "")
  		                tags +=   "<a href='javascript:' class='badge bg-transparent text-red btn-tag tag' data-tag-value='"+value+"'>#" + value + "</a> ";
  		              });
                  }

                  var name = notEmpty(o.name) ? o.name : "";

                  var address = notEmpty(o.address) ? o.address : "";

                  var postalCode = notEmpty(address) && notEmpty(address.postalCode) ? address.postalCode : "";
                  if(postalCode == "") postalCode = notEmpty(o.cp) ? o.cp : "";
                  
                  var cityName = notEmpty(address) && notEmpty(address.addressLocality) ? address.addressLocality : "";


                  var fullLocality = postalCode + " " + cityName;

                  var description = notEmpty(o.shortDescription) ? o.shortDescription : "";
                  if(description == "") description = (notEmpty(o.description)) ? o.description : "";
                  if(description == "") description = (notEmpty(o.message)) ? o.message : "";
           
                  //console.dir(o);
                  //console.log(typeof o.startDate);

                  var startDate = notEmpty(o.startDate) ? dateToStr(o.startDate, "fr", true, true) : null;
                  var endDate   = notEmpty(o.endDate) ? dateToStr(o.endDate, "fr", true, true)   : null;
                  if(endDate == null) endDate = notEmpty(o.dateEnd) ? dateToStr(o.dateEnd, "fr", true, true)   : null;
                  
                  if(type!="surveys" && type!="actions"){
                    startDate = notEmpty(startDate) ? "Du " + startDate : startDate;
                    endDate = notEmpty(endDate) ? "Au " + endDate : endDate;
                  }
                  else{                   
                    startDate = notEmpty(startDate) ? "Du " + startDate : startDate;
                    endDate = notEmpty(endDate) ? "jusqu'au " + endDate : endDate;
                  }

                  var updated   = notEmpty(o.updatedLbl) ? o.updatedLbl : null; 
                  
                  //template principal
                  str += "<div class='col-md-12 searchEntity'>";

                    
                    if(userId != null){
                        isFollowed=false;
                        str += "<div class='col-md-1 col-sm-1 col-xs-1' style='max-width:40px;'>";
                        if(typeof o.isFollowed != "undefined" ) isFollowed=true;
                        if(type!="cities" && type!="surveys" && type!="actions" && id != userId && userId != null && userId != ""){
                          tip = (type == "events") ? "Participer" : 'Suivre';
                          str += "<a href='javascript:;' class='btn btn-default btn-sm btn-add-to-directory bg-white tooltips followBtn'" + 
                                'data-toggle="tooltip" data-placement="left" data-original-title="'+tip+'"'+
                                " data-ownerlink='follow' data-id='"+id+"' data-type='"+type+"' data-name='"+name+"' data-isFollowed='"+isFollowed+"'>"+
                                    "<i class='fa fa-chain'></i>"+ //fa-bookmark fa-rotate-270
                                  "</a>";
                        }
                        str += '</div>';
                      }

                    
  	                str += "<div class='col-md-2 col-sm-2 col-xs-3 entityCenter no-padding'>";

                    str += "<a href='"+url+"' class='lbh'>" + htmlIco + "</a>";
  	                str += "</div>";
  					         target = "";

                     

                      
  	                str += "<div class='col-md-10 col-sm-9 col-xs-8 entityRight no-padding'>";
  	                	
                      str += "<a href='"+url+"' "+target+" class='entityName text-dark lbh'>" + name + "</a>";
                      
                      if(updated != null)
                      str += "<div class='pull-right'><i class='fa fa-flash'></i> <span class='hidden-xs'>actif </span>" + updated + "</div>";
                      

                      //var thisLocality = "";
                      if(fullLocality != "" && fullLocality != " ")
                           thisLocality = "<a href='"+url+"' "+target+ ' data-id="' + dataId + '"' + "  class='entityLocality lbh'><i class='fa fa-home'></i> " + fullLocality + "</a>";
                      else thisLocality = "<br>";
                      
                      //debat / actions
                      if(notEmpty(o.parentRoom)){
                        str += "<div class='entityDescription text-dark'><i class='fa fa-archive'></i> " + o.parentRoom.name + "</div>";
                        if(notEmpty(o.parentRoom.parentObj)){
                          var typeIcoParent = o.parentRoom.parentObj.typeSig;
                          console.log("typeIcoParent", typeIcoParent);
                          var icoParent = ("undefined" != typeof mapIconTop[typeIcoParent]) ? mapIconTop[typeIcoParent] : mapIconTop["default"];
                          var colorParent = ("undefined" != typeof mapColorIconTop[typeIcoParent]) ? mapColorIconTop[typeIcoParent] : mapColorIconTop["default"];
                          

                          var thisLocality = notEmpty(o.parentRoom) && notEmpty(o.parentRoom.parentObj) && 
                                        notEmpty(o.parentRoom.parentObj.address) ? 
                                        o.parentRoom.parentObj.address : null;

                          var postalCode = notEmpty(thisLocality) && notEmpty(thisLocality.postalCode) ? thisLocality.postalCode : "";
                          var cityName = notEmpty(thisLocality) && notEmpty(thisLocality.addressLocality) ? thisLocality.addressLocality : "";

                          thisLocality = postalCode + " " + cityName;
                          if(thisLocality != " ") thisLocality = ", <small> " + thisLocality + "</small>";
                          else thisLocality = "";

                          var ctzCouncil = typeIcoParent=="city" ? "Conseil citoyen de " : "";
                          str += "<div class='entityDescription text-"+colorParent+"'> <i class='fa "+icoParent+"'></i> <b>" + ctzCouncil + o.parentRoom.parentObj.name + "</b>" + thisLocality+ "</div>";
                        

                        }
                      }else{
                        str += thisLocality;
                      }


                      if(startDate != null)
                      str += "<div class='entityDate bg-"+color+" badge'><i class='fa fa-caret-right'></i> " + startDate + "</div>";
                      if(endDate != null)
  	                	str += "<div  class='entityDate bg-"+color+" badge'><i class='fa fa-caret-right'></i> " + endDate + "</div>";
  	                	
                      if(notEmpty(o.parentRoom)){
                        var vUp   = notEmpty(o.voteUpCount)       ? o.voteUpCount.toString()        : "0";
                        var vMore = notEmpty(o.voteMoreInfoCount) ? o.voteMoreInfoCount.toString()  : "0";
                        var vAbs  = notEmpty(o.voteAbstainCount)  ? o.voteAbstainCount.toString()   : "0";
                        var vUn   = notEmpty(o.voteUnclearCount)  ? o.voteUnclearCount.toString()   : "0";
                        var vDown = notEmpty(o.voteDownCount)     ? o.voteDownCount.toString()      : "0";
                        str += "<div class='pull-right margin-bottom-10 no-padding'>";
                          str += "<span class='bg-green lbl-res-vote'><i class='fa fa-thumbs-up'></i> " + vUp + "</span>";
                          str += " <span class='bg-blue lbl-res-vote'><i class='fa fa-pencil'></i> " + vMore + "</span>";
                          str += " <span class='bg-dark lbl-res-vote'><i class='fa fa-circle'></i> " + vAbs + "</span>";
                          str += " <span class='bg-purple lbl-res-vote'><i class='fa fa-question-circle'></i> " + vUn + "</span>";
                          str += " <span class='bg-red lbl-res-vote'><i class='fa fa-thumbs-down'></i> " + vDown + "</span>";
                        str += "</div>";
                      }

                      str += "<div class='entityDescription'>" + description + "</div>";
  	               
                      str += tags;
              
                    str += "</div>";

                    
  	                					
  				        str += "</div>";
              }); //end each

              if(str == "") { 
	              $.unblockUI();
	              showMap(false);
                  $(".btn-start-search").html("<i class='fa fa-refresh'></i>"); 
                  if(indexMin == 0){
                    //ajout du footer   
                    var msg = "<i class='fa fa-ban'></i> Aucun résultat";    
                    if(name == "" && locality == "") msg = "<h3 class='text-dark'><i class='fa fa-3x fa-keyboard-o'></i><br> Préciser votre recherche pour plus de résultats ...</h3>"; 
                    str += '<div class="pull-left col-md-12 text-left" id="footerDropdown" style="width:100%;">';
                    str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>"+msg+"</h3><br/>";
                    str += "</div>";
                    $("#dropdown_search").html(str);
                    $("#searchBarText").focus();
                  }
                     
              }
              else
              {       
                //ajout du footer      	
                str += '<div class="pull-left col-md-12 text-center" id="footerDropdown" style="width:100%;">';
                str += "<hr style='float:left; width:100%;'/><h3 style='margin-bottom:10px; margin-left:15px;' class='text-dark'>" + totalData + " résultats</h3><br/>";
                str += '<button class="btn btn-default" id="btnShowMoreResult"><i class="fa fa-angle-down"></i> Afficher plus de résultat</div></center>';
                str += "</div>";

                //si on n'est pas sur une première recherche (chargement de la suite des résultat)
                if(indexMin > 0){
                  //on supprime l'ancien bouton "afficher plus de résultat"
                  $("#btnShowMoreResult").remove();
                  //on supprimer le footer (avec nb résultats)
                  $("#footerDropdown").remove();

                  //on calcul la valeur du nouveau scrollTop
                  var heightContainer = $(".my-main-container")[0].scrollHeight - 180;
                  //on affiche le résultat à l'écran
                  $("#dropdown_search").append(str);
                  //on scroll pour afficher le premier résultat de la dernière recherche
                  $(".my-main-container").animate({"scrollTop" : heightContainer}, 1700);
                  //$(".my-main-container").scrollTop(heightContainer);

                  
                //si on est sur une première recherche
                }else{
                  //on affiche le résultat à l'écran
                  $("#dropdown_search").html(str);

                  if(typeof myMultiTags != "undefined"){
                    $.each(myMultiTags, function(key, value){ //console.log("binding bold "+key);
                      $("[data-tag-value='"+key+"'].btn-tag").addClass("bold");
                    });
                  }
                  
                  //on scroll pour coller le haut de l'arbre au menuTop
                  //$(".my-main-container").scrollTop(95);
                }
                //remet l'icon "loupe" du bouton search
                $(".btn-start-search").html("<i class='fa fa-refresh'></i>");
                //active les link lbh
                bindLBHLinks();

                $.unblockUI();
				        showMap(false);
                
                //active le chargement de la suite des résultat au survol du bouton "afficher plus de résultats"
                //(au cas où le scroll n'ait pas lancé le chargement comme prévu)
               	//$("#btnShowMoreResult").mouseenter(function(){
                  // if(!loadingData){
                  //   startSearch(indexMin+indexStep, indexMax+indexStep);
                  //   $("#btnShowMoreResult").mouseenter(function(){});
                  // }
                //});
                
                //initialise les boutons pour garder une entité dans Mon répertoire (boutons links)
                initBtnLink();

    	        } //end else (str=="")

              //signal que le chargement est terminé
              loadingData = false;

              //quand la recherche est terminé, on remet la couleur normal du bouton search
    	        $(".btn-start-search").removeClass("bg-azure");
        	  }

            //console.log("scrollEnd ? ", scrollEnd, indexMax, countData , indexMin);
            //si le nombre de résultat obtenu est inférieur au indexStep => tous les éléments ont été chargé et affiché
            //console.log("SHOW MORE ?", indexMax, indexMin, indexMax - indexMin, countData);
            console.log("SHOW MORE ?", countData, indexStep);
            //if(indexMax - countData > indexMin){ 
            if(countData < indexStep){
              $("#btnShowMoreResult").remove(); 
              scrollEnd = true;
            }else{
              scrollEnd = false;
            }

            if(typeof showResultInCalendar != "undefined")
              showResultInCalendar(mapElements);
            //affiche les éléments sur la carte
            Sig.showMapElements(Sig.map, mapElements);
          }
    });

                    
  }


  function initBtnLink(){
    $('.tooltips').tooltip();
  	//parcours tous les boutons link pour vérifier si l'entité est déjà dans mon répertoire
  	$.each($(".followBtn"), function(index, value){
    	var id = $(value).attr("data-id");
   		var type = $(value).attr("data-type");
      console.log("error type :", type);
   		if(type == "person") type = "people";
   		else type = typeObj[type].col;
      //console.log("#floopItem-"+type+"-"+id);
   		if($("#floopItem-"+type+"-"+id).length){
   			//console.log("I FOLLOW THIS");
   			if(type=="people"){
	   			$(value).html("<i class='fa fa-unlink text-green'></i>");
	   			$(value).attr("data-original-title", "Ne plus suivre cette personne");
	   			$(value).attr("data-ownerlink","unfollow");
   			}
   			else{
	   			$(value).html("<i class='fa fa-user-plus text-green'></i>");
	   			
          if(type == "organizations")
	   				$(value).attr("data-original-title", "Vous êtes membre de cette organization");
	   			else if(type == "projects")
	   				$(value).attr("data-original-title", "Vous êtes contributeur de ce projet");
	   			
          //(value).attr("onclick", "");
	   			$(value).removeClass("followBtn");
	   		}
   		}
   		if($(value).attr("data-isFollowed")=="true"){

	   		$(value).html("<i class='fa fa-unlink text-green'></i>");
	   		$(value).attr("data-original-title", (type == "events") ? "Ne plus participer" : "Ne plus suivre" );
			  $(value).attr("data-ownerlink","unfollow");
        $(value).addClass("followBtn");
   		}
   	});

  	//on click sur les boutons link
   	$(".followBtn").click(function(){
	   	formData = new Object();
   		formData.parentId = $(this).attr("data-id");
   		formData.childId = userId;
   		formData.childType = personCOLLECTION;
   		var type = $(this).attr("data-type");
   		var name = $(this).attr("data-name");
   		var id = $(this).attr("data-id");
   		//traduction du type pour le floopDrawer
   		var typeOrigine = typeObj[type].col;
      if(typeOrigine == "persons"){ typeOrigine = personCOLLECTION;}
   		formData.parentType = typeOrigine;
   		if(type == "person") type = "people";
   		else type = typeObj[type].col;

		var thiselement = this;
		$(this).html("<i class='fa fa-spin fa-circle-o-notch text-azure'></i>");
		//console.log(formData);
    var linkType = (type == "events") ? "connect" : "follow";
		if ($(this).attr("data-ownerlink")=="follow"){
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/link/"+linkType,
				data: formData,
				dataType: "json",
				success: function(data) {
					if(data.result){
						toastr.success(data.msg);	
						$(thiselement).html("<i class='fa fa-unlink text-green'></i>");
						$(thiselement).attr("data-ownerlink","unfollow");
						$(thiselement).attr("data-original-title", (type == "events") ? "Ne plus participer" : "Ne plus suivre");
						addFloopEntity(id, type, data.parentEntity);
					}
					else
						toastr.error(data.msg);
				},
			});
		} else if ($(this).attr("data-ownerlink")=="unfollow"){
			formData.connectType =  "followers";
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: baseUrl+"/"+moduleId+"/link/disconnect",
				data : formData,
				dataType: "json",
				success: function(data){
					if ( data && data.result ) {
						$(thiselement).html("<i class='fa fa-chain'></i>");
						$(thiselement).attr("data-ownerlink","follow");
						$(thiselement).attr("data-original-title", (type == "events") ? "Participer" : "Suivre");
						removeFloopEntity(data.parentId, type);
						toastr.success(trad["You are not following"]+data.parentEntity.name);
					} else {
					   toastr.error("You leave succesfully");
					}
				}
			});
		}
   	});
   	//on click sur les boutons link
    $(".btn-tag").click(function(){
      setSearchValue($(this).html());
    });
  }



  function setSearchValue(value){
    $("#searchBarText").val(value);
    startSearch(0, indexStepInit);
  }

  