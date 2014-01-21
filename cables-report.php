<?php
include ('inc/init.php');
 
$tabhandler['reports']['cableid'] = 'renderCableIdReport'; // register a report rendering function
$tab['reports']['cableid'] = 'Cable IDs'; // title of the report tab
 
function renderCableIdReport()
{
	global $dbxlink;
    $sql = "SELECT Link.*, porta.id as porta_id, porta.name as porta_name, objecta.id as objecta_id, objecta.name as objecta_name, portb.id as portb_id, portb.name as portb_name, objectb.id as objectb_id, objectb.name as objectb_name
FROM Link
INNER JOIN Port porta ON porta.id = Link.porta
INNER JOIN Port portb ON portb.id = Link.portb
INNER JOIN Object objecta ON porta.object_id = objecta.id
INNER JOIN Object objectb ON portb.object_id = objectb.id
WHERE Link.cable<>''
ORDER BY cable ASC";
 
	echo '<div class="portlet">';
	// display the stat array
	echo "<h2>Cable IDs Report</h2>";
	echo '<table cellspacing="0" cellpadding="5" align="center" class="widetable">';
	echo '<tbody>';
	echo '<tr><th class="tdleft">Cable Name</th><th class="tdleft">Port A ID</th><th class="tdleft">Port B ID</th></tr>';
 
	foreach ($dbxlink->query($sql) as $row) {
		echo "<tr>";
		echo '<td class="tdleft"><h3>' . $row["cable"] . "</h3></td>";
		// A
		echo '<td class="tdleft">';
			echo '<div><strong>';
				echo $row["objecta_name"];
			echo '</strong></div>';
			echo '<div>';
				echo '<a href="/index.php?page=object&tab=ports&object_id='.$row["objecta_id"].'&hl_port_id='.$row["porta_id"].'">' . $row["porta_name"] . '</a>';
			echo '</div>';
		echo '</td>';
		// B
		echo '<td class="tdleft">';
			echo '<div><strong>';
				echo $row["objectb_name"];
			echo '</strong></div>';
			echo '<div>';
				echo '<a href="/index.php?page=object&tab=ports&object_id='.$row["objectb_id"].'&hl_port_id='.$row["portb_id"].'">' . $row["portb_name"] . '</a>';
			echo '</div>';
		echo '</td>';
		echo "</tr>";
    }
 
    echo '</tbody>';
	echo '</table>';
	echo '</div>';
}
 
?>
