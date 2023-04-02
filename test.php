<?PHP
require_once 'PdfParser/Element.php';
require_once 'PdfParser/PDFObject.php';
require_once 'PdfParser/Font.php';
require_once 'PdfParser/Page.php';
require_once 'PdfParser/Element/ElementString.php';
require_once 'PdfParser/Encoding/AbstractEncoding.php';

$parser = new PdfParser/Parser();
$pdf = $parser->parseFile()("https://www.monmouthshire.gov.uk/app/uploads/2023/03/week-ending-24.03-ext.pdf");
$t = $pdf->getText();
echo $t;
?>