<?php 
$this->renderPartial('newsSV');

$cssAnsScriptFilesModule = array(
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css',
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysiwyg-color.css',
	'/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
	'/plugins/x-editable/css/bootstrap-editable.css',
	'/plugins/select2/select2.css',
	//X-editable...
	'/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js' , 
	'/plugins/x-editable/js/bootstrap-editable.js' , 
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js' , 
	'/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5.js' , 
	'/plugins/wysihtml5/wysihtml5.js',
	'/plugins/moment/min/moment.min.js',
	'/plugins/jquery.scrollTo/jquery.scrollTo.min.js',
	'/plugins/ScrollToFixed/jquery-scrolltofixed-min.js',
	'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
	'/plugins/jquery.appear/jquery.appear.js',
	'/plugins/jquery.elastic/elastic.js',
	'/plugins/select2/select2.css',
	'/plugins/select2/select2.min.js',

);
HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->theme->baseUrl."/assets");
?>	
	<!-- start: PAGE CONTENT -->
<?php 
	
if( isset($_GET["isNotSV"]) && (@$type && $type!="city") ) {
	$contextName = "";
	$contextIcon = "bookmark fa-rotate-270";
	$contextTitle = "";
	if( isset($type) && $type == Organization::COLLECTION && isset($organization) ){
		Menu::organization( $organization );
		$thisOrga = Organization::getById($organization["_id"]);
		$contextName = Yii::t("common","Organization")." : ".$thisOrga["name"];
		$contextIcon = "users";
		$contextTitle = Yii::t("common","Participants");
	}
	else if( isset($type) && $type == City::COLLECTION && isset($city) ){
		Menu::city( $city );
		$contextName = Yii::t("common","City")." : ".$city["name"];
		$contextIcon = "university";
		$contextTitle = Yii::t("common", "DIRECTORY Local network of")." ".$city["name"];
	}
	else if( (isset($type) && $type == Person::COLLECTION) || (isset($person) && !@$type) ){
		Menu::person( $person );
		$contextName = Yii::t("common","Person")." : ".$person["name"];
		$contextIcon = "user";
		$contextTitle =  Yii::t("common", "DIRECTORY of")." ".$person["name"];
	}
	else if( isset($type) && $type == PROJECT::COLLECTION && isset($project) ){
		Menu::project( $project );
		$contextName = Yii::t("common","Project")." : ".$project["name"];
		$contextIcon = "lightbulb-o";
		$contextTitle = Yii::t("common", "Contributors of project");//." ".$project["name"];
	}else if( isset($type) && $type == "pixels"){
		$contextName = "Pixels : participez au projet";
		$contextTitle = Yii::t("common", "Contributors of project");//." ".$project["name"];
	}
	Menu::news($type);
	$this->renderPartial('../default/panels/toolbar'); 
}
?>
<style>
#btnCitoyens:hover{
	color:#F3D116;
	border-left: 5px solid #F3D116;
}
#btnOrganization:hover{
	color:#93C020;
	/*border-left: 5px solid #93C020;*/
}
#btnEvent:hover{
	color:#F9B21A;
	border-left: 5px solid #F9B21A;
}
#btnProject:hover{
	color:#8C5AA1;
	border-left: 5px solid #8C5AA1;
}
.timeline-scrubber{
	min-width: 115px;
	top:125px;
	.optionFilter{
		margin-bottom:20px;
	}
}
.timeline{
	float: left;
	min-width: 100%;
}
.date_separator span{
	font-family: "homestead";
	font-size: 21px;
	background-color: white !important;
	color: #315C6E !important;
	border: none !important;
	border-radius: 0px !important;
	border-bottom: 1px dashed #315C6E !important;

}

#newsHistory{
	overflow: scroll;
	overflow-x: hidden;
	<?php if($type!="city" && !isset($_GET["isSearchDesign"])) { ?>
	position:fixed;
	top:100px;
	<?php } ?>
	<?php if(isset($_GET["isSearchDesign"])) { ?>
		/*position:absolute;*/
	<?php } ?>
	/*padding-top:100px !important;*/
	bottom:0px;
	right:0px;
	left:70px;
}
.fixedTop{
	position:fixed;
	top:100px;
	padding:40px !important;
}
#tagFilters a.filter, #scopeFilters a.filter{
	background-color: rgba(245, 245, 245, 0.7);
	font-size: 14px;
	padding: 5px;
	float: left;
	margin-right: 5px;
	margin-bottom: 5px;
	border-radius: 0px;
	-moz-box-shadow: -1px 1px 3px -2px #656565;
	-webkit-box-shadow: -1px 1px 3px -2px #656565;
	-o-box-shadow: -1px 1px 3px -2px #656565;
	box-shadow: -1px 1px 3px -2px #656565;
	filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=224, Strength=3);
}
.filterNewsActivity{
	margin-bottom: 10px;
}
.filterNewsActivity .btn-green{
	background-color: #3A758D;
	border-color: #315C6E;
}
.filterNewsActivity .btn-green:hover{
	background-color: #315C6E;
}

.filterNewsActivity .btn-dark-green{
	background-color: #315C6E;
	border-color: #315C6E;
}
.timeline-scrubber{
	<?php if($type!="city") { ?>
	right: 65px;
    position: fixed;
    top: 215px;
    <?php } ?>
}

.fixScrubber{
	right: 65px;
	position: fixed;
    top: 215px;
}
.btn-add-something{
	border-radius: 0px;
	padding: 7px 0px;
	font-size: 12px;
	margin:0px;  
	width:100% !important;
	font-family: "homestead";
}

.optionFilter{
	margin-bottom:20px;
}

#formActivity .bg-yellow, #formActivity .bg-green, 
#formActivity .bg-orange, #formActivity .bg-purple{
	/*border-bottom: 3px solid transparent;*/
}

#formActivity .bg-yellow:hover, #formActivity .bg-green:hover, 
#formActivity .bg-orange:hover, #formActivity .bg-purple:hover{
/*border-bottom: 3px solid rgba(255, 255, 255, 0.8);*/
}
div.timeline .spine{
	border-radius:0px;
	z-index: 0;

}
div.timeline .date_separator span{
	z-index: 3;
}
.editable-news{
	
}
.extract_url {
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	font-size: 11px;
}
.extracted_url{
	min-height:100px;
	margin-top: 10px;
}
#get_url{
	max-width:100%; 
	resize: none;
}
#get_url:focus{
	background-color: white !important;
}
.get_url_input {
	width: 100%;
	border: 1px solid #8E9CA4;
	height: 25px;
	padding-left: 10px;
	font-family: Arial, Helvetica, sans-serif;
	padding-right: 30px;
	min-height: 50px;
}
.extracted_thumb {
	float: left;
	position:relative;
	margin-right: 10px;
}
.extracted_thumb_large{
	position:relative;
	max-height: 250px;
	overflow: hidden;
}
#loading_indicator{
	position: absolute;
    right: 10px;
    margin-top: 5px;
    display: none;
}
#results{
	display:none;
    border: 1px solid #eee;
}

.videoSignal{
	position: absolute;
    width: 100px;
    line-height: 100px;
    height: 100px;
    border: 3px solid;
    background-color: rgba(0,0,0,0.2);
    padding-top: 5px;
}

.thumb_sel {
	position: absolute;
    height: 22px;
    width: 55px;
    top: 0;
}
.thumb_sel .prev_thumb {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -50px 0px;
	background-color: rgba(250,250,250,0.5);
	float: left;
	width: 26px;
	height: 22px;
	cursor: hand;
	cursor: pointer;
}
.thumb_sel .prev_thumb:hover {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat 0px 0px;
}
.thumb_sel .next_thumb {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -76px 0px;
	background-color: rgba(250,250,250,0.5);
	float: left;
	width: 24px;
	height: 22px;
	cursor: hand; 
	cursor: pointer;
}
.thumb_sel .next_thumb:hover {
	background: url(<?php echo $this->module->assetsUrl ?>/images/news/thumb_selection.gif) no-repeat -26px 0px;
}
.small_text{
	font-size: 10px;
}
.emptyNewsnews{
	color:#3C5665;
}

<?php if (isset($_GET["isSearchDesign"]) ){ ?>
/*MISE EN PAGE SPECIALE POUR NOUVEAU DESIGN "SEARCH"*/
#newsHistory{
	top:110px !important;
	width: 100%;
	left: 16.62% !important;
	/*border-top: 1px solid #d4d4d4;*/
	padding: 0px !important;
}
#newsHistory .panel.panel-white{
	box-shadow: 0px 0px !important
}
#newsHistory #timeline {
    /*width: 91.66666667%;*/
}
#newsHistory .timeline-scrubber {
    right: 0%;
	position: fixed;
	top: 315px;
}
#newsHistory .timeline-scrubber li:last-child a {
    border-color: #50687d;
    color: #50687d;
}
#newsHistory .timeline-scrubber a {
    border-left: 5px solid #50687d;
    color: #50687d;
}
.main-col-search{
	/*padding-top:10px !important;*/
}
<?php } ?>

</style>

<div id="formCreateNewsTemp" style="float: none;display:none;" class="center-block">
	<div class='no-padding form-create-news-container'>
		<h5 class='padding-10 partition-light no-margin text-left header-form-create-news' style="margin-bottom:-40px !important;"><i class='fa fa-pencil'></i> <?php echo Yii::t("news","Share a thought, an idea, a link",null,Yii::app()->controller->module->id) ?> </h5>
		<form id='form-news'>
			<input type="hidden" id="parentId" name="parentId" value="<?php echo $contextParentId ?>"/>
			<input type="hidden" id="parentType" name="parentType" value="<?php echo $contextParentType ?>"/> 
			<div class="extract_url">
				<div class="padding-10 bg-white">
					<img id="loading_indicator" src="<?php echo $this->module->assetsUrl ?>/images/news/ajax-loader.gif">
					<textarea id="get_url" placeholder="..." class="get_url_input form-control textarea" style="border:none;" name="getUrl" spellcheck="false" ></textarea>
					<div id="results" class="padding-10 bg-white"></div>
				</div>
			</div>
			<div class="form-group tagstags" style="">
			    <input id="tags" type="" data-type="select2" name="tags" placeholder="#Tags" value="" style="width:100%;">		    
			</div>
			<div class="form-actions" style="display: block;">
				<?php if(@$type && $type==Person::COLLECTION){ ?>
				<div class="dropdown">
					<a data-toggle="dropdown" class="btn btn-default" id="btn-toogle-dropdown-scope" href="#"><i class="fa fa-globe"></i> Public <i class="fa fa-caret-down"></i></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<li>
							<a href="#" id="scope-my-wall" class="scopeShare" data-value="public"><h4 class="list-group-item-heading"><i class="fa fa-globe"></i> Public</h4>
								<!--<div class="small" style="padding-left:12px;">-->
							<p class="list-group-item-text small">Ouvert au public et votre localité</p><!--</div>-->
							</a>
						</li>
						<li>
							<a href="#" id="scope-my-network" class="scopeShare" data-value="private"><h4 class="list-group-item-heading"><i class="fa fa-connectdevelop"></i> Mon réseau</h4>
								<p class="list-group-item-text small">Le réseau auquel vous êtes connecté</p>
							</a>
						</li>
						<!--<li>
							<a href="#" id="scope-select" data-toggle="modal" data-target="#modal-scope"><i class="fa fa-plus"></i> Selectionner</a>
						</li>-->
					</ul>
				</div>	
				<?php }else if($type=="city"){ ?>
					<input type="hidden" name="cityInsee" value="<?php echo $_GET["insee"]; ?>"/>
					<div class="badge"><i class="fa fa-university"></i> <?php //echo $city["name"]; ?></div>
				<?php } ?>
				<input type="hidden" name="scope" value="public"/>
				<button id="btn-submit-form" type="submit" class="btn btn-green pull-right">Envoyer <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</form>
	 </div>
</div>
<div id="newsHistory" class="padding-10">
	<div class="<?php if($type!="city") {?>col-md-12<?php } ?>">
		<!-- start: TIMELINE PANEL -->
		<div class="panel panel-white" style="padding-top:10px;<?php if (isset($_GET["isSearchDesign"]) ){ ?>box-shadow:inherit;<?php } ?>">
			<div class="panel-heading border-light  <?php if( isset($_GET["isNotSV"])) echo "hidden"; ?>">
				<h4 class="panel-title">News</h4>
				<ul class="panel-heading-tabs border-light">
		        	<?php if( !isset($_GET["isNotSV"])) { ?>
		        	<li>
		        		<a class="new-news btn btn-info" href="#new-News" data-notsubview="1"><?php echo Yii::t("common","Add");?> <i class="fa fa-plus"></i></a>
		        	</li>
		        	<?php } ?>
		        </ul>
			</div>
			<div id="top" class="panel-body panel-white">
				<div id="tagFilters" class="optionFilter pull-left center col-md-10" style="display:none;" ></div>
				<div id="scopeFilters" class="optionFilter pull-left center col-md-10" style="display:none;" ></div>
	
				<div id="timeline" class="col-md-12">
					<?php if($type=="city"){ ?>
					<div class="panel-heading text-center">
						<h3 class="panel-title text-blue lbl-title-newsstream"><i class="fa fa-rss"></i> Les actualités locales</h3>
		  			</div>
		  			<?php } ?>
					<div class="timeline">
						<!--<div class="center filterNewsActivity">
							<div class="btn-group">
								<a id="btnNews" href="javascript:;"  class="filter btn btn-dark-green" data-filter=".news" style="width:140px;">
									<i class="fa fa-rss"></i> <?php echo Yii::t("news","News") ?>
								</a>
								<a id="btnActivity" href="javascript:;" class="filter btn btn-green" data-filter=".activityStream" style="width:140px;">
									<i class="fa fa-exchange"></i> <?php echo Yii::t("news","Activity") ?>
								</a>
							</div>
						</div>-->
						<div class="newsTL">
						</div>
					</div>
				</div>
				<ul class="timeline-scrubber inner-element newsTLmonthsListnews col-md-2"></ul>
				<ul class="timeline-scrubber inner-element newsTLmonthsListactivity col-md-2"></ul>
				
			</div>
			<div class="stream-processing center">
				<span class="search-loader text-dark" style="font-size:20px;"><i class="fa fa-spin fa-circle-o-notch"></i></span>
			</div>
		</div>
		<!-- end: TIMELINE PANEL -->
	</div>
</div>

<div id="modal_scope_extern" class="form-create-news-container hide"></div>

<style type="text/css">
	div.timeline .newsTL > .newsFeed:nth-child(2n+2) {margin-top: 10px;}
	

div.timeline .newsTL > .newsFeed:nth-child(2n+2) {
    float: right;
    margin-top: 20px;
    width: 50%;
    clear: right;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+1) {
    float: left;
    width: 50%;
    clear: left;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+2) .timeline_element {
    float: left;
    margin-left: 30px;
    right: 10%;
    opacity: 1;
    right: 0;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+1) .timeline_element {
    float: right;
    left: 10%;
    margin-right: 30px;
    left: 0;
    opacity: 1;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+2) .timeline_element:before {
    left: -27px;
    top: 15px;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+2) .timeline_element:after {
    left: -35px;
    top: 10px;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+1) .timeline_element:after {
    right: -35px;
    top: 10px;
}
div.timeline .newsTL > .newsFeed:nth-child(2n+1) .timeline_element:before {
    right: -27px;
    top: 15px;
}
	.timeline_element {padding: 10px;}
</style>

<?php 
foreach($news as $key => $oneNews){
	$news[$key]["typeSig"] = "news";	
}
?>

<!-- end: PAGE CONTENT-->
<script type="text/javascript">
/*
	Global Variables to initiate timeline
	- offset => represents measure of last newsFeed (element for each stream) to know when launch loadStrean
	- lastOffset => avoid repetition of scrolling event (unstable behavior)
	- dateLimit => date to know until when get new news
*/
var news = <?php echo json_encode($news)?>;
var newsReferror={
		"news":{
			"offset":"",
			"dateLimit":0,
			"lastOffset":""
			},
		"activity":{
			"offset":"",
			"dateLimit":0,
			"lastOffset":""
			},
	};
var mode = "view";
var canPostNews = <?php echo json_encode(@$canPostNews) ?>;

var contextParentType = <?php echo json_encode(@$contextParentType) ?>;
var contextParentId = <?php echo json_encode(@$contextParentId) ?>;
var countEntries = 0;
var offset="";
var	dateLimit = 0;	
var lastOffset="";
var streamType="news";
var months = ["<?php echo Yii::t('common','january') ?>", "<?php echo Yii::t('common','febuary') ?>", "<?php echo Yii::t('common','march') ?>", "<?php echo Yii::t('common','april') ?>", "<?php echo Yii::t('common','may') ?>", "<?php echo Yii::t('common','june') ?>", "<?php echo Yii::t('common','july') ?>", "<?php echo Yii::t('common','august') ?>", "<?php echo Yii::t('common','september') ?>", "<?php echo Yii::t('common','october') ?>", "<?php echo Yii::t('common','november') ?>", "<?php echo Yii::t('common','december') ?>"];
var contextMap = {
	"tags" : [],
	"scopes" : {
		codeInsee : [],
		codePostal : [], 
		region :[],
		addressLocality : []
	},
};
var formCreateNews;
var indexStep = 15;
var currentIndexMin = 0;
var currentIndexMax = indexStep;
var currentMonth = null;
var scrollEnd = false;
var totalEntries = 0;
var timeout = null;
var tagsFilterListHTML = "";
var scopesFilterListHTML = "";
jQuery(document).ready(function() 
{	
	if(contextParentType=="pixels"){
		tagsNews=["bug","idea"];
	}
	else {
		tagsNews = <?php echo json_encode($tags); ?>
	}
	/////// A réintégrer pour la version last
	<?php if (isset($_GET["isSearchDesign"]) ){ ?>
		var $scrollElement = $(".my-main-container");
	<?php } else { ?>
		var $scrollElement = $("#newsHistory");
	<?php } ?>
	$('#tags').select2({tags:tagsNews});
	$("#tags").select2('val', "");
	if(contextParentType!="city"){
		$(".moduleLabel").html("<i class='fa fa-<?php echo @$contextIcon ?>'></i> <?php echo @$contextName; ?>");
		Sig.restartMap();
		Sig.showMapElements(Sig.map, news);
	}else{
		
	}
	// SetTimeout => Problem of sequence in js script reader
	setTimeout(function(){
		loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
	},100);
	$(".my-main-container").scroll(function(){
	    if(!loadingData && !scrollEnd){
	        var heightContainer = $(".my-main-container")[0].scrollHeight;
	        var heightWindow = $(window).height();
	        //console.log("scroll : ", scrollEnd, heightContainer, $(this).scrollTop() + heightWindow);
	        if(scrollEnd == false){
	          var heightContainer = $(".my-main-container")[0].scrollHeight;
	          var heightWindow = $(window).height();
	          if( ($(this).scrollTop() + heightWindow) == heightContainer){
	            console.log("scroll MAX");
	            loadStream(currentIndexMin+indexStep, currentIndexMax+indexStep);
	          }
	        }
	    }
	});
	
	getUrlContent();
	setTimeout(function(){
		saveNews();
	},5000);
 	//Construct the first NewsForm
	//buildDynForm();
	//déplace la modal scope à l'exterieur du formulaire
 	$('#modal-scope').appendTo("#modal_scope_extern") ;
});

/*
* function loadStream() loads news for timeline: 5 news are download foreach call
* @param string contextParentType indicates type of wall news
* @param string contextParentId indicates the precise parent id 
* @param strotime dateLimite indicates the date to load news
*/
var loadStream = function(indexMin, indexMax){
	loadingData = true;
    indexStep = 15;
    if(typeof indexMin == "undefined") indexMin = 0;
    if(typeof indexMax == "undefined") indexMax = indexStep;

    currentIndexMin = indexMin;
    currentIndexMax = indexMax;
    if(indexMin == 0 && indexMax == indexStep) {
      totalData = 0;
      mapElements = new Array(); 
    }
    else{ if(scrollEnd) return; }
    
	$.ajax({
        type: "POST",
        url: baseUrl+"/"+moduleId+"/news/index/type/"+contextParentType+"/id/"+contextParentId+"/date/"+dateLimit,
       	dataType: "json",
    	success: function(data){
	    	console.log(data.news)
	    	if(data){
				buildTimeLine (data.news, indexMin, indexMax);
				if(typeof(data.limitDate.created) == "object")
					dateLimit=data.limitDate.created.sec;
				else
					dateLimit=data.limitDate.created;
			}
		}
	});
}

var tagsFilterListHTML = "";
var scopesFilterListHTML = "";
function buildTimeLine (news, indexMin, indexMax)
{
	if (dateLimit==0){
		$(".newsTL").html('<div class="spine"></div>');
		if (streamType=="activity"){
			btnFilterSpecific='<li><a id="btnCitoyens" href="javascript:;"  class="filter yellow" data-filter=".citoyens" style="color:#F3D116;border-left: 5px solid #F3D116"><i class="fa fa-user"></i> Citoyens</a></li>'+
				'<li><a id="btnOrganization" href="javascript:;"  class="filter green" data-filter=".organizations" style="color:#93C020;border-left: 5px solid #93C020"><i class="fa fa-users"></i> Organizations</a></li>'+
				'<a id="btnEvent" href="javascript:;"  class="filter orange" data-filter=".events" style="color:#F9B21A;border-left: 5px solid #F9B21A"><i class="fa fa-calendar"></i> Events</a>'+
				'<a id="btnProject" href="javascript:;"  class="filter purple" data-filter=".projects" style="color:#8C5AA1;border-left: 5px solid #8C5AA1"><i class="fa fa-lightbulb-o"></i> Projects</a><li><br/></li>';
			$(".newsTLmonthsList"+streamType).html(btnFilterSpecific);
		}
	}
	//insertion du formulaire CreateNews dans le stream
	var formCreateNews = $("#formCreateNewsTemp");
	//currentMonth = null;
	var countEntries = 0;
	$.each(news, function(i, v) { if(v.length!=0){ countEntries++; } });
	
	totalEntries += countEntries;
	
	str = "";
	console.log(news);
	$.each( news , function(key,newsObj)
	{
		if(newsObj.created)
		{
			if(typeof(newsObj.created) == "object")
				var date = new Date( parseInt(newsObj.created.sec)*1000 );
			else
				var date = new Date( parseInt(newsObj.created)*1000 );
			var d = new Date();
			
			str += buildLineHTML(newsObj);
		}
	});
	$(".newsTL").append(str);
	if(canPostNews==true){
		$("#newFeedForm").append(formCreateNews);
		$("#formCreateNewsTemp").css("display", "inline");
	}
	$.each( news , function(key,o){
		initXEditable();
		manageModeContext(key);
	});

	loadingData = false;
	//offset=$('.newsTL'+' .newsFeed:last').offset(); 
	if( tagsFilterListHTML != "" )
		$("#tagFilters").html(tagsFilterListHTML);
	if( scopesFilterListHTML != "" )
		$("#scopeFilters").html(scopesFilterListHTML);

	if(!countEntries || countEntries < 5){
		if( dateLimit == 0 && countEntries == 0){
			var date = new Date(); 
			form ="";
			if(canPostNews==true){
				form = "<div class='newsFeed'>"+
						"<div id='newFeedForm"+"' class='timeline_element partition-white no-padding' style='min-width:85%;'></div>"+
					"</div>";
				msg = "Aucune activité.<br/>Soyez le premier à publier ici";
			}
			else{
				msg = "Aucune activité.<br/>Participez à l'activité de ce fil d'actualité<br/>En devenant membre ou contributeur";
			}
			newsTLLine = '<div class="date_separator" id="'+'month'+date.getMonth()+date.getFullYear()+'" data-appear-top-offset="-400">'+
						'<span>'+months[date.getMonth()]+' '+date.getFullYear()+'</span>'+
					'</div>'+form+"<div class='col-md-5 text-extra-large emptyNews"+"'><i class='fa fa-ban'></i> "+msg+".</div>";
		
			$(".spine").css("bottom","0px");
			$(".tagFilter, .scopeFilter").hide();
			
			$(".newsTL").append(newsTLLine);
			if(canPostNews==true){
				$("#newFeedForm").append(formCreateNews);
				$("#formCreateNewsTemp").css("display", "inline");
			}
		}
		else {
			if($("#backToTop").length <= 0){
				//$('.first')
				titleHTML = '<div class="date_separator" id="backToTop" data-appear-top-offset="-400" style="height:150px;">'+
						'<a href="javascript:;" onclick="smoothScroll(\'0px\');" title="retour en haut de page">'+
							'<span style="height:inherit;" class="homestead"><i class="fa fa-ban"></i> <?php echo Yii::t("common","No more news"); ?><br/><i class="fa fa-arrow-circle-o-up fa-2x"></i> </span>'+
						'</a>'+
					'</div>';
					$(".newsTL").append(titleHTML);
					$(".spine").css('bottom',"0px");
			}
		}
			$(".stream-processing").hide();
	}
	
	bindEvent();
	//Unblock message when click to change type stream
	if (dateLimit==0)
		setTimeout(function(){$.unblockUI()},1);
}



function buildLineHTML(newsObj,update)
{
	newsTLLine = "";
	
	// ManageMenu to the user de signaler un abus, de modifier ou supprimer ces news
	manageMenu = "";
	if (newsObj.author.id=="<?php echo Yii::app() -> session["userId"] ?>" && streamType=="news"){
		manageMenu='<div class="btn dropdown pull-right no-padding" style="padding-left:10px !important;">'+
			'<a class="dropdown-toggle" type="button" data-toggle="dropdown" style="color:#8b91a0;">'+
				'<i class="fa fa-cog"></i>  <i class="fa fa-angle-down"></i>'+
			'</a>'+
			'<ul class="dropdown-menu">'+
				'<li><a href="javascript:;" class="deleteNews" data-id="'+newsObj._id.$id+'"><small><i class="fa fa-times"></i> Supprimer</small></a></li>';
		if (newsObj.type != "activityStream"){
		manageMenu	+= '<li><a href="#" class="modifyNews" data-id="'+newsObj._id.$id+'"><small><i class="fa fa-pencil"></i> Modifier la publication</small></a></li>';
		}
		manageMenu +=	'</ul>'+
		'</div>';
	}
	
	if(typeof(newsObj.created) == "object")
		var date = new Date( parseInt(newsObj.created.sec)*1000 );
	else
		var date = new Date( parseInt(newsObj.created)*1000 );

	var year = date.getFullYear();
	var month = months[date.getMonth()];
	var day = (date.getDate() < 10) ?  "0"+date.getDate() : date.getDate();
	var hour = (date.getHours() < 10) ?  "0"+date.getHours() : date.getHours();
	var min = (date.getMinutes() < 10) ?  "0"+date.getMinutes() : date.getMinutes();
	var dateStr = day + ' ' + month + ' ' + year + ' ' + hour + ':' + min;
	// if month of the current news is different than currentMonth
	// Added new month link to the right sidebar and a new date separator in the timeline
	// Check if inject the new's form
	if( currentMonth != date.getMonth() && update != true)
	{
		form="";
		// Append for at the beginning after the construction of the timeline
		//alert(canPostNews);
		if (currentMonth == null  && canPostNews == true){
		//	alert();
			form = "<div class='newsFeed'>"+
						"<div id='newFeedForm"+"' class='timeline_element partition-white no-padding' style='min-width:85%;'></div>"+
					"</div>";

		}
		currentMonth = date.getMonth();
		// Add item to the left filter by month YY
		linkHTML =  '<li class="">'+
						'<a href="javascript:;" class="linkMonth" onclick="smoothScroll(\'#month'+date.getMonth()+date.getFullYear()+'\');">'+months[date.getMonth()]+' '+date.getFullYear()+'</a>'+
					'</li>';
		// Add date separator by month YY
		$(".newsTLmonthsList"+streamType).append(linkHTML);
		newsTLLine += '<div class="date_separator" id="'+'month'+date.getMonth()+date.getFullYear()+'" data-appear-top-offset="-400">'+
						'<span>'+months[date.getMonth()]+' '+date.getFullYear()+'</span>'+
					'</div>'+form;
		
		$(".spine").css("bottom","0px");
	}
	else{
		$(".spine").css("bottom","30px");
	}
	
	var color = "white";
	var icon = "fa-user";
	///// Url link to object
	urlAction=buildHtmlUrlAndActionObject(newsObj);
	var imageBackground = "";
	if(typeof newsObj.author != "undefined"){
		if(typeof newsObj.author.type == "undefined") {
			newsObj.author.type = "people";
		}
		if (typeof newsObj.type == "events"){
			newsObj.author.type = "";		
		}
	}
	
	///// Image Backgound
	if(typeof(newsObj.imageBackground) != "undefined" && newsObj.imageBackground){
		imagePath = baseUrl+'/'+newsObj.imageBackground;
		imageBackground = '<a '+url+'>'+
							'<div class="timeline_shared_picture"  style="background-image:url('+imagePath+');">'+
								'<img src="'+imagePath+'">'+
							'</div>'+
						'</a>';
	}
	//END Image Background
	iconStr=builHtmlAuthorImageObject(newsObj);
	if(typeof(newsObj.target) != "undefined" && newsObj.target.type != "citoyens" && newsObj.type!="gantts"){
	if(newsObj.target.objectType=="projects")
			var iconBlank="fa-lightbulb-o";
		else if (newsObj.target.objectType=="organizations")
			var iconBlank="fa-group";
		}
	// END IMAGE AND FLAG POST BY HOSTED BY //
	media="";
	title="";
	if (streamType=="news" && newsObj.type != "activityStream"){
		if("undefined" != typeof newsObj.name){
			title='<a href="#" id="newsTitle'+newsObj._id.$id+'" data-type="text" data-pk="'+newsObj._id.$id+'" class="editable-news editable editable-click newsTitle"><span class="text-large text-bold light-text timeline_title no-margin" style="color:#719FAB;">'+newsObj.name+"</span></a>";
		}
		text='<a href="#" id="newsContent'+newsObj._id.$id+'" data-type="textarea" data-pk="'+newsObj._id.$id+'" class="editable-news editable-pre-wrapped ditable editable-click newsContent"><span class="timeline_text no-padding">'+newsObj.text+"</span></a>";
		if("undefined" != typeof newsObj.media){
			media=newsObj.media;
		}
	}
	else{
		title = '<a '+urlAction.url+'><span class="text-large text-bold light-text timeline_title no-margin padding-5">'+newsObj.name+'</span></a>';
		text = '<span class="timeline_text">'+newsObj.text+'</span>';
	}
	
	tags = "", 
	scopes = "",
	tagsClass = "",
	scopeClass = "";
	if( "object" == typeof newsObj.tags && newsObj.tags )
	{
		$.each( newsObj.tags , function(i,tag){
			tagsClass += tag+" ";
			tags += "<span class='label tag_item_map_list'>#"+tag+"</span> ";
			if( $.inArray(tag, contextMap.tags)  == -1 && tag != undefined && tag != "undefined" && tag != "" ){
				contextMap.tags.push(tag);
				tagsFilterListHTML += ' <a href="javascript:;" class="filter btn btn-xs btn-default text-red" data-filter=".'+tag+'"><span class="text-red text-xss">#'+tag+'</span></a>';
			}
		});
		tags = '<div class="pull-left"><i class="fa fa-tags text-red"></i> '+tags+'</div>';
	}

	var author = typeof newsObj.author != "undefined" ? newsObj.author : null;
	if( (author != null && typeof author.address != "undefined") || newsObj.type == "activityStream")
	{
		if(newsObj.type != "activityStream"){
			postalCode=author.address.postalCode;
			city=author.address.addressLocality;			
		}else{
			postalCode=newsObj.scope.address.postalCode;
			city=newsObj.scope.address.addressLocality;		
		}
		
		if( typeof postalCode != "undefined")
		{
			scopes += "<span class='label label-danger'>"+postalCode+"</span> ";
			scopeClass += postalCode+" ";
			if( $.inArray(postalCode, contextMap.scopes.codePostal )  == -1){
				contextMap.scopes.codePostal.push(postalCode);
				//scopesFilterListHTML += ' <a href="#" class="filter btn btn-xs btn-default text-red" data-filter=".'+newsObj.address.postalCode+'"><span class="text-red text-xss">'+newsObj.address.postalCode+'</span></a>';
			}
		}
		if( typeof city != "undefined")
		{
			scopes += "<span class='label label-danger'>"+city+"</span> ";
			scopeClass += city+" ";
			if( $.inArray(city, contextMap.scopes.addressLocality )  == -1){
				cityFilter=city.replace(/\s/g, "");
				console.log(city);
				contextMap.scopes.addressLocality.push(cityFilter);
				scopesFilterListHTML += ' <a href="#" class="filter btn btn-xs btn-default text-red" data-filter=".'+postalCode+'"><span class="text-red text-xss">'+city+'</span></a>';
			}
		}
		scopes = '<div class="pull-right"><i class="fa fa-circle-o"></i> '+scopes+'</div>';
	}
	var objectDetail = (newsObj.object && newsObj.object.displayName) ? '<div>Name : '+newsObj.object.displayName+'</div>'	 : "";
	var objectLink = (newsObj.object) ? ' <a '+urlAction.url+'>'+iconStr+'</a>' : iconStr;
	// HOST NAME AND REDIRECT URL
	if (typeof(newsObj.target) != "undefined" && newsObj.target.id != newsObj.author.id  && newsObj.type!="needs" && newsObj.type!="gantts"){
		redirectTypeUrl=newsObj.target.objectType.substring(0,newsObj.target.objectType.length-1);
		if (newsObj.target.objectType=="citoyens")
			redirectTypeUrl="person";

		urlTarget = 'href="javascript:;" onclick="loadByHash(\'#'+redirectTypeUrl+'.detail.id.'+newsObj.target.id+'\')"';
		var personName = "<a "+urlTarget+" style='color:#3C5665;'>"+newsObj.target.name+"</a> "+urlAction.titleAction;
	}
	else {
		if(typeof newsObj.author.id != "undefined")
			authorId=newsObj.author.id;
		else
			authorId=newsObj.author._id.$id;
			urlTarget = 'href="#" onclick="loadByHash(\'#person.detail.id.'+authorId+'\')"';
		var personName = "<a "+urlTarget+" style='color:#3C5665;'>"+newsObj.author.name+"</a> "+urlAction.titleAction;
	}
	// END HOST NAME AND REDIRECT URL
	// Created By Or invited by
	if(typeof(newsObj.verb) != "undefined" && typeof(newsObj.target) != "undefined" && newsObj.target.id != newsObj.author.id){
		<?php if (isset($_GET["isNotSV"])){ ?> 
			urlAuthor = 'href="#" onclick="openMainPanelFromPanel(\'/person/detail/id/'+newsObj.author.id+'\', \'person : '+newsObj.author.name+'\',\'fa-user\', \''+newsObj.author.id+'\')"';
		<?php } else{ ?>
			urlAuthor = 'href="'+baseUrl+'/'+moduleId+'/person/dashboard/id/'+newsObj.author.id+'"';
		<?php } ?>
		authorLine=newsObj.verb+" by <a "+urlAuthor+">"+newsObj.author.name+"</a> "+urlAction.titleAction;
	}
	else 
		authorLine="";
	//END OF CREATED BY OR INVITED BY
	var commentCount = 0;
	if (streamType=="news"){
		idVote=newsObj._id['$id'];
	}
	else
		idVote=newsObj.id;
	if ("undefined" != typeof newsObj.commentCount) 
		commentCount = newsObj.commentCount;
	vote=voteCheckAction(idVote,newsObj);

	newsTLLine += '<div class="newsFeed '+''+tagsClass+' '+scopeClass+' '+newsObj.type+' ">'+
					'<div class="timeline_element partition-'+color+'">'+
						tags+
						manageMenu+
						//scopes+
						'<div class="space1"></div>'+ 
						imageBackground+
						'<div class="timeline_author_block">'+
							objectLink+
							'<span class="light-text timeline_author padding-5 margin-top-5 text-bold">'+personName+'</span>'+
							'<div class="timeline_date"><i class="fa fa-clock-o"></i> '+dateStr+'</div>' +					
						'</div>'+
						'<div class="space5"></div>'+
						'<hr/>' + 
						'<a '+urlAction.url+'>'+
							//'<div class="timeline_title">'+
								//'<span class="text-large text-bold light-text timeline_title no-margin padding-5">'+
							//	title+
								//'</span>'+
							//'</div>'+
							'<div class="space5"></div>'+
							//'<span class="timeline_text">'+ 
							text + media +//+ '</span>' +	
						'</a>'+
						'<div class="space5"></div>';
						//'<span class="timeline_text">'+ authorLine + '</span>' +
						//'<div class="space10"></div>'+
						<?php if(isset(Yii::app()->session['userId'])){ ?>
	newsTLLine +=		'<hr>'+
						"<div class='bar_tools_post pull-left'>"+
							"<a href='javascript:;' class='newsAddComment' data-count='"+commentCount+"' data-id='"+idVote+"' data-type='"+newsObj.type+"'><span class='label text-dark'>"+commentCount+" <i class='fa fa-comment'></i></span></a> "+
							vote+
							//"<a href='javascript:;' class='newsShare' data-count='10' data-id='"+newsObj._id['$id']+"'><span class='label text-dark'>10 <i class='fa fa-share-alt'></i></span></a> "+
							//"<span class='label label-info'>10 <i class='fa fa-eye'></i></span>"+
						"</div>";
						<?php } ?>
	newsTLLine +=	'</div>'+
				'</div>';
	return newsTLLine;
}
function buildHtmlUrlAndActionObject(obj){
	console.log(obj);
	if(typeof(obj.type) != "undefined")
		redirectTypeUrl=obj.type.substring(0,obj.type.length-1);
	else 
		redirectTypeUrl="news";
	if(obj.type == "citoyens" && typeof(obj.verb) == "undefined" || obj.type !="activityStream"){
		<?php if (isset($_GET["isNotSV"])){ ?> 
			url = 'href="#" onclick="openMainPanelFromPanel(\'/news/latest/id/'+obj.id+'\', \''+redirectTypeUrl+' : '+obj.name+'\',\''+obj.icon+'\', \''+obj.id+'\')"';
		<?php } else{ ?>
			url = 'href="'+baseUrl+'/'+moduleId+'/'+redirectTypeUrl+'/latest/id/'+obj.id+'"';
		<?php } ?>
		if(typeof(obj.postOn) != "undefined" && obj.type != contextParentType){
			if(obj.type == "organizations"){
				color="green";
			}else
				color="purple";
			titleAction = ' <i class="fa fa-caret-right"></i> <a href="javascript:;" onclick="loadByHash(\'#'+redirectTypeUrl+'.detail.id.'+obj.id+'\')"><span class="text-'+color+'">'+obj.postOn.name+"</span></a>";
		} else {
			if(obj.text.length == 0 && obj.media.length)
				titleAction = "a partagé un lien";
			else 
				titleAction = "";
		}
	}
	else{
		if(obj.object.objectType=="needs"){
			redirectTypeUrl=obj.type;
			id=obj.object.id;
			urlParent="/type/"+contextParentType+"/id/"+contextParentId;
		}
		else if(obj.object.objectType =="citoyens"){
			redirectTypeUrl="person";
			id=obj.object.id;
			urlParent="";
		} 
		else if(obj.object.objectType =="organizations"){
			redirectTypeUrl="organization";
			id=obj.object.id;
			urlParent="";
			titleAction = "a créé une organization";
		} 
		else if(obj.object.objectType =="events"){
			redirectTypeUrl="event";
			id=obj.object.id;
			urlParent="";
			titleAction = "a posté un évènement";
		} 
		else if(obj.object.objectType == "gantts" || obj.object.objectType =="projects"){
			redirectTypeUrl="project";
			id=obj.object.id;
			urlParent="";
			titleAction = "a créé un projet";
		}
		url = 'href="javascript:;" onclick="loadByHash(\'#'+redirectTypeUrl+'.detail.id.'+id+'\')"';
	}
	object=new Object;
	object.url= url,
	object.titleAction= titleAction;
	return object; 
}
function builHtmlAuthorImageObject(obj){
	if(typeof(obj.icon) != "undefined"){
		icon = "fa-" + Sig.getIcoByType({type : obj.type});
		var colorIcon = Sig.getIcoColorByType({type : obj.object.objectType});
		if (icon == "fa-circle")
			icon = obj.icon;
	}else{ 
		icon = "fa-rss";
		colorIcon="blue";
	}
	var flag = '<div class="ico-type-account"><i class="fa '+icon+' fa-'+colorIcon+'"></i></div>';	
	// IMAGE AND FLAG POST BY - TARGET IF PROJECT AND EVENT - AUTHOR IF ORGA
	if(typeof(obj.target) != "undefined" && obj.target.objectType != "citoyens" && obj.type!="gantts"){
		if(obj.target.objectType=="projects")
			var iconBlank="fa-lightbulb-o";
		else if (obj.target.objectType=="organizations")
			var iconBlank="fa-group";
		if(typeof obj.target.profilImageUrl !== "undefined" && obj.target.profilImageUrl != ""){ 
			imgProfilPath = "<?php echo Yii::app()->createUrl('/'.$this->module->id.'/document/resized/50x50'); ?>"+obj.target.profilImageUrl;
		var iconStr = "<div class='thumbnail-profil'><img height=50 width=50 src='" + imgProfilPath + "'></div>" + flag ; 
		}else {
			var iconStr = "<div class='thumbnail-profil text-center text-white' style='overflow:hidden;text-shadow: 2px 2px grey;'><i class='fa "+iconBlank+"' style='font-size:50px;'></i></div>"+flag;
		}
	}else{
			var imgProfilPath =  "<?php echo $this->module->assetsUrl.'/images/news/profile_default_l.png';?>";
			if((contextParentType == "projects" || contextParentType == "organizations") && typeof(obj.verb) != "undefined" && obj.type!="gantts"){
				if(typeof obj.target.profilImageUrl != "undefined" && obj.target.profilImageUrl != ""){ 
					imgProfilPath = "<?php echo Yii::app()->createUrl('/'.$this->module->id.'/document/resized/50x50'); ?>"+obj.target.profilImageUrl;
					var iconStr = "<div class='thumbnail-profil'><img height=50 width=50 src='" + imgProfilPath + "'></div>" + flag ; 
				}else {
					if(obj.object.objectType=="organizations")
						var iconStr = "<div class='thumbnail-profil text-center' style='overflow:hidden;'><i class='fa fa-group' style='font-size:50px;'></i></div>"+flag;
					else
						var iconStr = "<div class='thumbnail-profil'><img height=50 width=50 src='" + imgProfilPath + "'></div>" + flag ; 

				}
			}
			else{	
				if(typeof obj.author.profilImageUrl !== "undefined" && obj.author.profilImageUrl != ""){
					imgProfilPath = "<?php echo Yii::app()->createUrl('/'.$this->module->id.'/document/resized/50x50'); ?>" + obj.author.profilImageUrl;
				}
				var iconStr = "<div class='thumbnail-profil'><img height=50 width=50 src='" + imgProfilPath + "'></div>" + flag ;	 
			}
	}
	return iconStr;
}

function bindEvent(){
	var separator, anchor;
	$("#get_url").elastic();
	
	$(".scopeShare").click(function() {
		console.log(this);
		replaceText=$(this).find("h4").html();
		$("#btn-toogle-dropdown-scope").html(replaceText+' <i class="fa fa-caret-down"></i>');
		scopeChange=$(this).data("value");
		$("input[name='scope']").val(scopeChange);
	});

	$(".date_separator").appear().on('appear', function(event, $all_appeared_elements) {
		separator = '#' + $(this).attr("id");
		$('.timeline-scrubber').find("li").removeClass("selected").find("a[href = '" + separator + "']").parent().addClass("selected");
	}).on('disappear', function(event, $all_disappeared_elements) {   				
		separator = $(this).attr("id");
		$('.timeline-scrubber').find("a").find("a[href = '" + separator + "']").parent().removeClass("selected");
	});
	$('.newsAddComment').off().on("click",function() {
		$.blockUI({
			message : '<div><a href="javascript:$.unblockUI();"><span class="pull-right text-dark"><i class="fa fa-share-alt"></span></a>'+
							'<div class="commentContent"></div></div>', 
			onOverlayClick: $.unblockUI,
			css: {"text-align": "left", "cursor":"default"}
		});
		if(streamType=="news"){
			type="news";
		} else
			type=$(this).data("type");
			getAjax('.commentContent',baseUrl+'/'+moduleId+"/comment/index/type/"+type+"/id/"+$(this).data("id"),function(){ 
		},"html");
	});
	$('.newsVoteUp').off().on("click",function(){
		if($(".newsVoteDown[data-id='"+$(this).data("id")+"']").children(".label").hasClass("text-orange"))
			toastr.info('<?php echo Yii::t("common","Remove your negative vote before") ?> !');
		else{	
		//toastr.info('This vote has been well registred');
			if($(this).children(".label").hasClass("text-green")){
				method = true;
		}
		else{
			method = false;
		}
		actionOnNews($(this),'<?php echo Action::ACTION_VOTE_UP ?>',method);
		disableOtherAction($(this), '.commentVoteUp', method);
		count = parseInt($(this).data("count"));
		$(this).children(".label").html($(this).data("count")+" <i class='fa fa-thumbs-up'></i>");
		}
	});
	$('.newsVoteDown').off().on("click",function(){
		if($(".newsVoteUp[data-id='"+$(this).data("id")+"']").children(".label").hasClass("text-green"))
			toastr.info('<?php echo Yii::t("common","Remove your positive vote before") ?> !');
		else{	
		//toastr.info('This vote has been well registred');
			if($(this).children(".label").hasClass("text-orange")){
				method = true;
		}
		else{
			method = false;
		}
		actionOnNews($(this),'<?php echo Action::ACTION_VOTE_DOWN ?>',method);
		disableOtherAction($(this), '.commentVoteDown', method);
		$(this).children(".label").html($(this).data("count")+" <i class='fa fa-thumbs-down'></i>");
		}
	});
	$('.newsShare').off().on("click",function(){
		toastr.info('TODO : SHARE this news Entry');
		console.log("newsShare",$(this).data("id"));
		count = parseInt($(this).data("count"));
		$(this).data( "count" , count+1 );
		$(this).children(".label").html($(this).data("count")+" <i class='fa fa-share-alt'></i>");
	});

	$('.filter').off().on("click",function(){
	 	if($(this).data("filter") == ".news" || $(this).data("filter")==".activityStream"){
		 	htmlMessage = '<div class="title-processing homestead"><i class="fa fa-circle-o-notch fa-spin"></i></div>';
		 	<?php if( isset($_GET["isNotSV"]) ) { ?>
				htmlMessage +=	'<a class="thumb-info" href="'+proverbs[rand]+'" data-title="Proverbs, Culture, Art, Thoughts"  data-lightbox="all">'+
			 		'<img src="'+proverbs[rand]+'" style="border:0px solid #666; border-radius:3px;"/></a><br/><br/>';
			<?php } ?>
			console.log(newsReferror);
			if(dateLimit==0){
				$.blockUI({message : htmlMessage});
				loadStream();
			}
			
			if ($("#backToTop"+streamType).length > 0 || $(".emptyNews"+streamType).length > 0){
				if($("#backToTop"+streamType).length > 0){
					$(".tagFilter, .scopeFilter").show();
				}
				else{
					$(".tagFilter, .scopeFilter").hide();
				}
				$(".stream-processing").hide();	
			}
			else{
				$(".stream-processing").show();	
			}
		}
		else{
			console.warn("filter",$(this).data("filter"));
			filter = $(this).data("filter");
			$(".newsFeed").hide();
			$(filter).show();
		}
	});

	$(".form-create-news-container #name").focus(function(){
		showFormBlock(true);	
	});
	
	$(".deleteNews").off().on("click",function(){
		var $this=$(this);
		idNews=$(this).data("id");
		bootbox.confirm("<?php echo Yii::t("common","Are you sure you want to delete this news") ?>", 
			function(result) {
				if (result) {
					$.ajax({
				        type: "POST",
				        url: baseUrl+"/"+moduleId+"/news/delete/id/"+idNews,
						dataType: "json",
						//data: {"newsId": idNews},
			        	success: function(data){
				        	if (data) {               
								toastr.success("<?php echo Yii::t("common", "News has been successfully delated") ?>!!");
								liParent=$this.parents().eq(4);
								offset.top = offset.top-liParent.height();
					        	liParent.fadeOut();
					        	
							} else {
					            toastr.error("<?php echo Yii::t("common", "Something went wrong!")." ".Yii::t("common","Please try again")?>.");
					        }
					    }
					});
				}
			}
		)
	});
	$(".modifyNews").off().on("click", function(){
		idNews=$(this).data("id");
		switchModeEdit(idNews);
	});
	$(".videoSignal").click(function(){
		videoLink = $(this).find(".videoLink").val();
		iframe='<div class="embed-responsive embed-responsive-16by9">'+
			'<iframe src="'+videoLink+'" width="100%" height="" class="embed-responsive-item"></iframe></div>';
		$(this).parent().next().before(iframe);
		$(this).parent().remove();
	});
}

function smoothScroll(scroolTo){
	$(".my-main-container").scrollTo(scroolTo,500,{over:-0.6});
}

function switchModeEdit(idNews){
	if(mode == "view"){
		mode = "update";
		manageModeContext(idNews);
	} else {
		mode ="view";
		manageModeContext(idNews);
	}
}

function manageModeContext(id) {
	listXeditables = ['#newsContent'+id, '#newsTitle'+id];
	if (mode == "view") {
		//$('.editable-project').editable('toggleDisabled');
		$.each(listXeditables, function(i,value) {
			$(value).editable('toggleDisabled');
		});
		//$("#btn-update-geopos").removeClass("hidden");
	} else if (mode == "update") {
		// Add a pk to make the update process available on X-Editable
		$('.editable-news').editable('option', 'pk', id);
		$.each(listXeditables, function(i,value) {
			$(value).editable('option', 'pk', id);
			$(value).editable('toggleDisabled');
		});
	}
}
function initXEditable() {
	$.fn.editable.defaults.mode = 'inline';
	$('.editable-news').editable({
    	url: baseUrl+"/"+moduleId+"/news/updatefield", //this url will not be used for creating new job, it is only for update
    	textarea: {
			html: true,
			video: true,
			image: true
		},
    	showbuttons: 'bottom',
    	success : function(data) {
	        if(data.result) {
	        	toastr.success(data.msg);
				console.log(data);
	        }
	        else{
	        	toastr.error(data.msg);  
	        }
	    }
	});
    //make jobTitle required
	$('.newsTitle').editable('option', 'validate', function(v) {
    	if(!v) return 'Required field!';
	});

	$('.newsContent').editable({
		url: baseUrl+"/"+moduleId+"/news/updatefield", 
		showbuttons: 'bottom',
		wysihtml5: {
			html: true,
			video: true,
			image: true
		},
		success : function(data) {
	        if(data.result) 
	        	toastr.success(data.msg);
	        else
	        	toastr.error(data.msg);  
	    },
	});


}
function actionOnNews(news, action,method) {
	if (streamType=="news")
		type="news";
	else 
		type=news.data("type");
	params=new Object,
	params.id=news.data("id"),
	params.collection=type,
	params.action=action;
	if(method){
		params.unset=method;
	}
	$.ajax({
		url: baseUrl+'/'+moduleId+"/action/addaction/",
		data: params,
		type: 'post',
		global: false,
		dataType: 'json',
		success: 
			function(data) {
    			if(!data.result){
                    toastr.error(data.msg);
                    console.log(data);
               	}
                else { 
                    if (data.userAllreadyDidAction) {
                    	toastr.info("You already vote on this comment.");
                    } else {
						count = parseInt(news.data("count"));
	                    if(count < count+data.inc)
	                    	toastr.success("<?php echo Yii::t("common","Your vote has been succesfully added")?>");
	                    else
		                    toastr.success("<?php echo Yii::t("common","Your vote has been succesfully removed")?>");
	                    console.log(data);
						news.data( "count" , count+data.inc );
						icon = news.children(".label").children(".fa").attr("class");
						news.children(".label").html(news.data("count")+" <i class='"+icon+"'></i>");
					}
                }
            },
        error: 
        	function(data) {
        		toastr.error("Error calling the serveur : contact your administrator.");
        	}
		});
}
function voteCheckAction(idVote, newsObj) {
	var voteUpCount = 0;
	textUp="text-dark";
	textDown="text-dark";
	if ("undefined" != typeof newsObj.voteUpCount){ 
		voteUpCount = newsObj.voteUpCount;
		if (newsObj.voteUp.indexOf("<?php echo Yii::app() -> session["userId"] ?>") != -1){
			textUp= "text-green";
			$(".newsVoteDown[data-id="+idVote+"]").off();
		}
	}
	var voteDownCount = 0;
	if ("undefined" != typeof newsObj.voteDownCount) {
		voteDownCount = newsObj.voteDownCount;
		if (newsObj.voteDown.indexOf("<?php echo Yii::app() -> session["userId"] ?>") != -1){
			textDown= "text-orange";
			$(".newsVoteUp[data-id="+idVote+"]").off();
		}
	}
	voteHtml = "<a href='javascript:;' class='newsVoteUp' data-count='"+voteUpCount+"' data-id='"+idVote+"' data-type='"+newsObj.type+"'><span class='label "+textUp+"'>"+voteUpCount+" <i class='fa fa-thumbs-up'></i></span></a> "+
			"<a href='javascript:;' class='newsVoteDown' data-count='"+voteDownCount+"' data-id='"+idVote+"' data-type='"+newsObj.type+"'><span class='label "+textDown+"'>"+voteDownCount+" <i class='fa fa-thumbs-down'></i></span></a>";
	return voteHtml;
}
function disableOtherAction($this,action,method){
	if(method){
		if (action != ".commentVoteUp")
			$this.children(".label").removeClass("text-orange").addClass("text-dark");
		if (action != ".commentVoteDown")
			$this.children(".label").removeClass("text-green").addClass("text-dark");
	}
	else{
		if (action != ".commentVoteUp")
			$this.children(".label").removeClass("text-dark").addClass("text-orange");
		if (action != ".commentVoteDown")
			$this.children(".label").removeClass("text-dark").addClass("text-green");
	}
}
function updateNews(newsObj)
{
	var date = new Date( parseInt(newsObj.created.sec)*1000 );
	if(newsObj.date.sec && newsObj.date.sec != newsObj.created.sec) {
		date = new Date( parseInt(newsObj.date.sec)*1000 );
	}
	var newsTLLine = buildLineHTML(newsObj,true);
	$(".emptyNews").remove();
	$("#newFeedForm").parent().after(newsTLLine).fadeIn();
	manageModeContext(newsObj._id.$id);
	$("#form-news #get_url").val("");
	$("#form-news #results").html("").hide();
	$("#form-news #tags").select2('val', "");
	showFormBlock(false);
	bindEvent();
}


function applyTagFilter(str)
{
	$(".newsFeed").fadeOut();
	if(!str){
		if($(".btn-tag.active").length){
			str = "";
			sep = "";
			$.each( $(".btn-tag.active") , function() { 
				str += sep+"."+$(this).data("id");
				sep = ",";
			});
		} else
			str = ".newsFeed";
	} 
	console.log("applyTagFilter",str);
	$(str).fadeIn();
	return $(".newsFeed").length;
}

function applyScopeFilter(str)
{
	$(".newsFeed").fadeOut();
	if(!str){
		if($(".btn-context-scope.active").length){
			str = "";
			sep = "";
			$.each( $(".btn-context-scope.active") , function() { 
				str += sep+"."+$(this).data("val");
				sep = ",";
			});
		} else
			str = ".newsFeed";
	} 
	console.log("applyScopeFilter",str);
	$(str).fadeIn();
	return $(".newsFeed").length;
}

function toggleFilters(what){
 	if( !$(what).is(":visible") )
 		$('.optionFilter').hide();
 	$(what).slideToggle();
 }
/*
* Save news and url generate
*
*
*
*
*
*/
function showFormBlock(bool){
	if(bool){
		$(".form-create-news-container #text").show("fast");
		//$(".form-create-news-container .tagstags").show("fast");
		$(".form-create-news-container .datedate").show("fast");
		//$(".form-create-news-container .form-actions").show("fast");
		$(".form-create-news-container .publiccheckbox").show("fast");
		//if($("input#public").prop('checked') != true)
		//$(".form-create-news-container .scopescope").show("fast");	
	}else{
		$(".form-create-news-container #text").hide();
		//$(".form-create-news-container .tagstags").hide();
		$(".form-create-news-container .datedate").hide();
		//$(".form-create-news-container .form-actions").hide();
		//$(".form-create-news-container .scopescope").hide();
		$(".form-create-news-container .publiccheckbox").hide();
	}
}

function getUrlContent(){
    //user clicks previous thumbail
    $("body").on("click","#thumb_prev", function(e){        
        if(img_arr_pos>0) 
        {
            img_arr_pos--; //thmubnail array position decrement
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">'+selectThumb);
            
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
    });
    
    //user clicks next thumbail
    $("body").on("click","#thumb_next", function(e){        
        if(img_arr_pos<total_images)
        {
            img_arr_pos++; //thmubnail array position increment
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">'+selectThumb);
            
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
    });
    var getUrl  = $('#get_url'); //url to extract from text field
    getUrl.keyup(function() { //user types url in text field        
        //url to match in the text field
        var match_url = /\b(https?):\/\/([\-A-Z0-9. \-]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;\-]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;\-]*)?/i;
        //continue if matched url is found in text field
        if (match_url.test(getUrl.val())) {
	        if(!$(".lastUrl").attr("href") || $(".lastUrl").attr("href") != getUrl.val().match(match_url)[0]){
	        	var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
                $("#results").hide();
                $("#loading_indicator").show(); //show loading indicator image
                //ajax request to be sent to extract-process.php
                //alert(extracted_url);
                $.ajax({
					url: baseUrl+'/'+moduleId+"/news/extractprocess",
					data: {
					'url': extracted_url},
					type: 'post',
					dataType: 'json',
					success: function(data){        
	                console.log(data); 
                    extracted_images = data.images;
                    total_images = parseInt(data.images.length);
                    //img_arr_pos = total_images;
                    img_arr_pos=1;
                    if(data.size){
	                    if (data.video){
		                		extractClass="extracted_thumb";
			                    width="100";
			                    height="100";
			                    aVideo='<a href="#" class="videoSignal text-white center"><i class="fa fa-2x fa-play-circle-o"></i><input type="hidden" class="videoLink" value="'+data.video+'"/></a>';
						}
		                else{
			                aVideo="";
			                endAVideo="";
		                    if(data.size[0] > 350 ){
			                    extractClass="extracted_thumb_large";
			                    width="100%";
			                    height="";
		                    }
		                    else{
			                    extractClass="extracted_thumb";
			                    width="100";
			                    height="100";
		                    }
						}
                    }
                    if (data.imageMedia!=""){
	                    inc_image = '<div class="'+extractClass+'" id="extracted_thumb">'+aVideo+'<img src="'+data.imageMedia+'" width="'+width+'" height="'+height+'"></div>';
	                    countThumbail="";
                    }
                    else {
	                    if(total_images > 0){
		                    if(total_images > 1){
			                    selectThumb='<div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div>';
			                    countThumbail='<span class="small_text" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span>';
		                    }
		                    else{
			                    selectThumb="";
			                    countThumbail="";
		                    }
	                        inc_image = '<div class="'+extractClass+'" id="extracted_thumb">'+aVideo+'<img src="'+data.images[0]+'" width="'+width+'" height="'+height+'">'+selectThumb+'</div>';
	                        
	                    }else{
	                        inc_image ='';
		                    countThumbail='';
	                    }
                    }
                    
                    //content to be loaded in #results element
					if(data.content==null)
						data.content="";
                    var content = '<div class="extracted_url">'+ inc_image +'<div class="extracted_content"><h4><a href="'+extracted_url+'" target="_blank" class="lastUrl">'+data.title+'</a></h4><p>'+data.content+'</p>'+countThumbail+'</div></div>';
                    //load results in the element
                    $("#results").html(content); //append received data into the element
                    $("#results").slideDown(); //show results with slide down effect
                    $("#loading_indicator").hide(); //hide loading indicator image
                	},
					error : function(){
						$.unblockUI();
						toastr.error("<?php echo yii::t("common","Something went wrong with the url"); ?>!");
						$("#loading_indicator").hide();
					}	
                });
			}
        }
    });
}
function saveNews(){
	var formNews = $('#form-news');
	var errorHandler2 = $('.errorHandler', formNews);
	var successHandler2 = $('.successHandler', formNews);
	formNews.submit(function(e) {
    		e.preventDefault();
		}).validate({
		<?php if(isset(Yii::app()->session['userId'])){ ?>
		errorElement : "span", // contain the error msg in a span tag
		errorClass : 'help-block',
		errorPlacement : function(error, element) {// render error placement for each input type
			if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
				error.insertAfter($(element).closest('.form-group').children('div').children().last());
			} else if (element.parent().hasClass("input-icon")) {
				error.insertAfter($(element).parent());
			} else {
				error.insertAfter(element);
				// for other inputs, just perform default behavior
			}
		},
		ignore : "",
		rules : {
			getUrl : {
				required:{
					depends: function() {
						if($("#results").html() !="")
							return false;
						else
							return true;
						}
				}
			},
		},
		messages : {
			getUrl : "* Please write something"

		},
		submitHandler : function(form) {
			$("#btn-submit-form i").removeClass("fa-arrow-circle-right").addClass("fa-circle-o-notch fa-spin");
			successHandler2.show();
			errorHandler2.hide();
			newNews = new Object;
			if($("#form-news #results").html() != ""){
				newNews.mediaContent=$("#form-news #results").html();	
			}
			if ($("#tags").val() != ""){
				newNews.tags = $("#form-news #tags").val().split(",");	
			}
			newNews.typeId = $("#form-news #parentId").val(),
			newNews.type = $("#form-news #parentType").val(),
			newNews.scope = $("input[name='scope']").val(),
			newNews.text = $("#form-news #get_url").val();
			if($("input[name='cityInsee']").length)
				newNews.codeInsee = $("input[name='cityInsee']").val();
			console.log(newNews);
			$.ajax({
		        type: "POST",
		        url: baseUrl+"/"+moduleId+"/news/save",
		        dataType: "json",
		        data: newNews,
				type: "POST",
		    })
		    .done(function (data) {
		        console.log(data);
	    		if(data.result)
	    		{
	    			//if(totalEntries == 0){
	    			//	loadByHash('#news.index.type.<?php echo (isset($_GET['type'])) ? $_GET['type'] : 'citoyens' ?>.id.<?php echo (isset($_GET['id'])) ? $_GET['id'] : Yii::app()->session['userId'] ?>?isSearchDesign=1', 'KESS KISS PASS ','rss' )
					//}
					//else {
		    			if( 'undefined' != typeof updateNews && typeof updateNews == "function" )	
		            		updateNews(data.object);
		  			//}
					$.unblockUI();
					$.hideSubview();
					toastr.success('Saved successfully!');
	    		}
	    		else 
	    		{
	    			$.unblockUI();
					toastr.error(data.msg);
	    		}
	    		$("#btn-submit-form i").removeClass("fa-circle-o-notch fa-spin").addClass("fa-arrow-circle-right");
				return false;
		    });
		}
		<?php }else{ ?>
			submitHandler : function(form) {
				showPanel("box-login");
			}
		<?php } ?>
	});
}
</script>
