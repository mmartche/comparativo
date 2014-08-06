<?php
include('../includes/header.php');
?>

<div class="content">
	<div class="columnMiddle">
		<div class="contentMiddle">
			<h2 class="expTitle">
				<div class="titleBar"></div>
				<div class="titleContent">
					<b>Explorador Carsale</b>
					<span>Encontre o carro perfeito para você</span>
				</div>
			</h2>
			<section class="secExplore">
				<h3 class="secTitle">Já tem algum carro em mente?</h3>
				<div class="secSubTitle"><span>Então começe por aqui</span></div>
				<div class="expHomeForm">
					<form action="search.php" method="post">
						<select class="expInputSelect" name="expManufacturer" id="expSelectManufacturer" onchange="updateField(this)">
							<option>Montadora</option>
							<?
							$sql = "select manufacturer.id as manufacturerId, manufacturer.name as manufacturerName from manufacturer, model, version, feature WHERE feature.idVersion = version.id and version.idModel = model.id and model.idManufacturer = manufacturer.id and version.active = 's' group by manufacturer.name ORDER by manufacturer.name";
							$query = mysql_query($sql) or die (mysql_error()."error #62");
							while ($resList = mysql_fetch_array($query)) {
								// echo "<div>".$resList[manufacturerName]."</div>";
							?>
							<option value="<?=$resList[manufacturerId]?>"><?=$resList[manufacturerName]?></option>
							<?
							}
							?>
						</select>
						<select class="expInputSelect" id="expModel" name="expModel">
							<option>Escolha uma montadora primeiro</option>
						</select>
						<div class="btnExpSearch"><div class="btnPadding"><input type="submit" class="btnButton" value="Ir para comparativo" /></div></div>
					</form>
				</div>
			</section>
			<section class="secExplore">
				<h3 class="secTitle">Não sabe o que quer?</h3>
				<div class="secSubTitle"><span>Nós Ajudamos você</span></div>
				<img src="../images/carExplorerQuestion.jpg" />
				<div class="btnExpSearch"><div class="btnPadding"><a href="search.php" class="btnButton">Explorar</a></div></div>
			</section>
		</div>
	</div>
</div>
<?
include ("../includes/footer.php");
?>
















<script type="text/javascript">
var uolJsHost = (("https:" == document.location.protocol) ? "https://ssl.carsale.com.br/js/carsale.js" : "http://me.jsuol.com/omtr/carsale.js");
document.write(unescape("%3Cscript language='JavaScript' src='" + uolJsHost + "' type='text/javascript' %3E%3C/script%3E"));
</script>
<script type="text/javascript"><!--
uol_sc.channel="Carros-parceiros-carsale";
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=uol_sc.t();if(s_code)document.write(s_code)//--></script>
<!-- End SiteCatalyst code version: H.20.2. -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10478324-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 </script>
<script type="text/javascript">
function updateField(obj){
	$("#expModel option").remove();
	var optTemp;
	console.log('../admin/api/index.php?type=askModel&mainId='+obj.value);
	$.getJSON('../admin/api/index.php?type=askModel&mainId='+obj.value, function(data) {
		$.each(data, function(key, val) {
			optTemp += '<option value="'+val.id+'" >'+val.label+'</option>';
		});
		$("#expModel").append(optTemp);
	});
}
</script>

</body>
</html>