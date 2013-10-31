<?
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$sv_connection = mysql_connect("localhost", "root", "");
	$db_connection = mysql_select_db ("thaumasolver3000");

	$itemlist = array();
	$aspectlist = array();

	$select = "SELECT * FROM `aspects` order by name";
	$result = mysql_query($select);
	while ($row = mysql_fetch_assoc($result)) {
		$aspectlist[$row["id"]] = $row;
	}		
	
	$select = "SELECT * FROM `items` order by name";
	$result = mysql_query($select);
	while ($row = mysql_fetch_assoc($result)) {
		$itemlist[$row["id"]] = $row;
		$itemlist[$row["id"]]["amount"] = 0;
		$itemlist[$row["id"]]["aspects"] = getAspects($row["id"]);
	}

	function getAspects($id){
		global $aspectlist;
		$aspects = "";
		$i = 0;
		foreach ($aspectlist as $key => $value) {
			if ($value["item1"] == $id || $value["item2"] == $id || $value["item3"] == $id || $value["item4"] == $id || $value["item5"] == $id || $value["item6"] == $id || $value["item7"] == $id || $value["item8"] == $id || $value["item9"] == $id || $value["item10"] == $id || $value["item11"] == $id || $value["item12"] == $id || $value["item13"] == $id || $value["item14"] == $id || $value["item15"] == $id || $value["item16"] == $id) {
				if ($i > 0) $aspects .= " ";
				$aspects .= "<img src='icons_aspects/".$value["pic"]."' width='32' height='32' />";
				//$aspects .= $value["name"];
				$i++;
			}
		}
		return $aspects;
	}

	function getAspectRow($id){
		global $itemlist, $aspectlist;
		
		echo "<br>";
		
		echo '<div style="display:inline-block; width:60px; height:48px;"><image class="tooltip" title="'.$aspectlist[$id]["name"].'" width="64" height="64" src="icons_aspects/'.$aspectlist[$id]["pic"].'"/></div>';
		for ($i=1;$i<9;$i++){
			$itemid = $aspectlist[$id]["item".$i];
			if ($itemid>0){
				echo '<div style="display:inline-block; height:64px; padding-left:10px;"><image width="32" height="32" src="items/'.$itemlist[$itemid]["pic"].'"/><br>';
				echo '<small>'.$itemlist[$itemid]["name"].' ('.$aspectlist[$id]["item".$i."a"].')</small></div>';
			}
		}
	}

	if ($_POST["action"] == "getResults") {
	
		
		$where = "(0";
		
		if ($_POST["v1"] > 0) $where .= ",".$_POST["v1"];
		if ($_POST["v2"] > 0) $where .= ",".$_POST["v2"];
		if ($_POST["v3"] > 0) $where .= ",".$_POST["v3"];
		if ($_POST["v4"] > 0) $where .= ",".$_POST["v4"];
		if ($_POST["v5"] > 0) $where .= ",".$_POST["v5"];
		if ($_POST["v6"] > 0) $where .= ",".$_POST["v6"];
		if ($_POST["v7"] > 0) $where .= ",".$_POST["v7"];
		if ($_POST["v8"] > 0) $where .= ",".$_POST["v8"];
		
		$where .= ")";
		
		$select = "SELECT * FROM `aspects` WHERE id IN ".$where;
		$result = mysql_query($select);
		while ($row = mysql_fetch_assoc($result)) {
			if ($row["item1"] > 0) $itemlist[$row["item1"]]["amount"]++;
			if ($row["item2"] > 0) $itemlist[$row["item2"]]["amount"]++;
			if ($row["item3"] > 0) $itemlist[$row["item3"]]["amount"]++;
			if ($row["item4"] > 0) $itemlist[$row["item4"]]["amount"]++;
			if ($row["item5"] > 0) $itemlist[$row["item5"]]["amount"]++;
			if ($row["item6"] > 0) $itemlist[$row["item6"]]["amount"]++;
			if ($row["item7"] > 0) $itemlist[$row["item7"]]["amount"]++;
			if ($row["item8"] > 0) $itemlist[$row["item8"]]["amount"]++;
			if ($row["item9"] > 0) $itemlist[$row["item9"]]["amount"]++;
			if ($row["item10"] > 0) $itemlist[$row["item10"]]["amount"]++;
			if ($row["item11"] > 0) $itemlist[$row["item11"]]["amount"]++;
			if ($row["item12"] > 0) $itemlist[$row["item12"]]["amount"]++;
			if ($row["item13"] > 0) $itemlist[$row["item13"]]["amount"]++;
			if ($row["item14"] > 0) $itemlist[$row["item14"]]["amount"]++;
			if ($row["item15"] > 0) $itemlist[$row["item15"]]["amount"]++;
			if ($row["item16"] > 0) $itemlist[$row["item16"]]["amount"]++;
		}
		for($i=8;$i>1;$i--){
			$ite = 0;
			foreach ($itemlist as $key => $value) {
				if ($value["amount"] == $i) {
					if ($ite == 0) echo "<hr>Items with ".$i." aspect matches:<br>";
					//echo '<span style="background-color:#0055FF; widht:64px; height:64px;" class="tooltip" title="'.$value["aspects"].'"><image width="48" height="48" src="items/'.$value["pic"].'"/><br><span style="padding-left:8px; line-height:32px;">'.$value["name"].'</span></span>';
					echo '<image class="tooltip" title="'.$value["name"]."<br>".$value["aspects"].'" width="32" height="32" src="items/'.$value["pic"].'"/>';
					$ite++;
				}
			}
		}
		
		echo "<br>";
		
		if ($_POST["v1"] > 0) getAspectRow($_POST["v1"]);
		if ($_POST["v2"] > 0) getAspectRow($_POST["v2"]);
		if ($_POST["v3"] > 0) getAspectRow($_POST["v3"]);
		if ($_POST["v4"] > 0) getAspectRow($_POST["v4"]);
		if ($_POST["v5"] > 0) getAspectRow($_POST["v5"]);
		if ($_POST["v6"] > 0) getAspectRow($_POST["v6"]);
		if ($_POST["v7"] > 0) getAspectRow($_POST["v7"]);
		if ($_POST["v8"] > 0) getAspectRow($_POST["v8"]);
		
		
	}

	if ($_GET["action"] == "getRecipes") {
		$select = "SELECT * FROM `recipes`";
		$result = mysql_query($select);
		echo "<items>\n";
		while ($row = mysql_fetch_assoc($result)) {
			echo "<item id=\"".$row["id"]."\" rname=\"".$row["name"]."\" v1=\"".$row["aspect1"]."\" v2=\"".$row["aspect2"]."\" v3=\"".$row["aspect3"]."\" v4=\"".$row["aspect4"]."\" v5=\"".$row["aspect5"]."\" v6=\"".$row["aspect6"]."\" v7=\"".$row["aspect7"]."\" v8=\"".$row["aspect8"]."\"></item>\n";
		}		
		echo "</items>\n";
	}
	
?>