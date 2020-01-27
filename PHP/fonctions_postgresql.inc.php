<?php
# Cette fonction prend en paramètre une requete SELECT et retourne le résultat sous forme d'un tableau HTML

function selectQuery_HTMLTable($selectQuery)
{	
	
	$result = pg_query($selectQuery) or die('Erreur3 SQL!'.pg_last_error());
	$table="<table>\n";
	$table.="\t<tr>\n";
	$i = 0;
	while ($i < pg_num_fields($result)){
		$fieldName = pg_field_name($result, $i);
		$table.="<th>".$fieldName."</th>";
		$i++;
	}
	$table.="\t</tr>\n";
	while ($line = pg_fetch_array($result,NULL, PGSQL_ASSOC)) {
	    $table.="\t<tr>\n";
	    foreach ($line as $col_value) {
	        $table.="\t\t<td>$col_value</td>\n";
	    }
	    $table.="\t</tr>\n";
	}
	$table.="</table>\n";
	return $table;
}

# Cette fonction prend en paramètre une requete SELECT sur une colone de la table SQL, et retourne le résultat sous forme d'une liste deroulante HTML

function selectColumn_HTMLScrList($selectQuery)
{
	$result = pg_query($selectQuery);
	$fieldName=pg_field_name($result,0);


		$scrList="<select class='custom-dropdown__select custom-dropdown__select--white' name='".$fieldName."'>";
		while ($line = pg_fetch_array($result,NULL, PGSQL_NUM)) {
	    	$scrList.="<option value='".$line[0]."'>".$line[0]."</option>";
		}
		$scrList.="</select>";
		return $scrList;

}
?>


