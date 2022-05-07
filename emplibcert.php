<?PHP
$title = "Our employer's insurance certificate";
$desc = "Our employer's liability insurance certificate";
require 'classes.php';
require 'top.html';
?>
<div class="nine columns" id="content">
<h1>Employer's Liability Insurance Certificates</h1>
<p>Each entry links to a copy of the certificate which will load as a PDF into this page. You will be able to download, print and zoom into the document. If your browser doesn't support this method a link will be displayed which will enable you to view it in a new tab or window.</p>
<ul>
<?PHP
$files = glob("docs/Employers Liability Certificate*.pdf");
$docs = Array();
foreach($files as $filename){
  $doc = basename($filename);
  $docs[] = $doc;
}
sort($docs);

foreach($docs as $doc){
  $doc = array_pop($docs);
  printf("<li><a title='This link will load a PDF' href='showpdf.php?file=docs/%s&page=emplibcert&title=Employers Liability Insurance Certificate' target='new'>%s</a></li>",urlencode($doc),$doc);
}
print("</ul>");

require 'bottom.html';
?>
<script type="text/javascript">
  handleMenu($('#emplibcert'));
</script>