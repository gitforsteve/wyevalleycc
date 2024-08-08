<?PHP
// cSpell:disable
$title = "Accessibility statement";
$desc = "Every effort is made to make our site accessible to everyone";
$keywords = "wye valley community council, accessibility screen readers";
require 'top.html';
?>
<div class="nine columns" style="padding-left:10px;">
  <h1 class="limit-min-max">Accessibility statement</h1>
  <p>Every effort has been made to ensure that our site is accessibile to everyone and checks are carried out regularly to maintain as high a standard of accessibility as possible through contrast of text and features to enhance the use of screen readers.</p>
  <p>If you have been unable to make the most of our site because of a difficulty in using it please contact us and we will try to address it.</p>
  <h2>PDF documents</h2>
  <p>While we do not generate <dfn><abbr title="portable document format, an Adobe standard">PDF</abbr></dfn> documents we do receive these from outside agencies and groups for display or link to pages where these are included, for example, the Tintern News.</p>
  <p>Some of these files are created as tagged (having a built-in index structure) and are readable by most screen readers. Most, however, are not and we have no control over these documents.</p>
</div>
<form id="postform" action="contact.php" method="POST">
  <input type="hidden" name="id" id="id" value="se" />
</form>
<?PHP
require "bottom.html";
?>
<script type='text/javascript'>
  handleMenu($('#accessibility'));
</script>