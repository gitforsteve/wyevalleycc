<?PHP
//cSpell:disable
$title = "Links to external sites";
$desc = "Links to sites which may be of interest to you";
require 'steveCSV.php';
require 'top.html';
?>
<div class="nine columns" style="padding-left:10px;">
<h1>Useful Links</h1>
<p>These links will open in a new page or tab, depending upon your browser settings. Please be aware that we cannot be responsible for the content of external sites.</p>
<table><thead></thead><tbody>
<?PHP
$csv = new steveCSV('data/links.csv');
$links = $csv->data;
foreach($links as $link){
  printf("<tr><td style='vertical-align:top'><a style='text-decoration:none;' href='%s' target='blank' title=\"External link to %s\">%s</a></td><td>%s</td></tr>",$link->linkurl,$link->linktitle,$link->linktitle,$link->linkdesc);
}
print("</tbody></table></div>");
require 'bottom.html';
?>
<script type="text/javascript">
  handleMenu($('#links'));
</script>
