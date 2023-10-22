<?PHP
//cSpell:disable
$title = "Annual Report - chair's report";
$desc = "Our annual report for 2022/23";
$keywords = "tintern, annual report, council report";
require 'top.html';
require 'classes.php';
require "stevetable.php";
$table = new steveTable('{
    "tableWidth": "100%",
    "widths": ["85%","15%"],
    "heading": ["Expenditure","Budget\n2021/22"],
    "tableFontSize": "1.5vw",
    "aligns": ["L","R"],
    "currency": [0,1],
    "currencySybmbol": ""
}');

?>
<div class='nine columns' style='padding-right: 10px; border-radius:0 0 15px 0; ' id='content'>
<h1>Annual Report 2022/23</h1>
<div style="position:sticky;top:0;background:white;">
<a class="button" href="annualreport.php" title="annual report main page">What we do</a> <a class="button" href="whatwecost.php" title="what we cost">What we cost</a> <a class="button" href="futureplans.php" title="plans for the future">Our plans for the future</a>
</div>
<h2>Chair's report</h2>
<p>The last three years have been difficult for everyone, with the closure of the A466, which had a phenomenal impact on business, residents and visitors, followed by the Covid Pandemic. The community council did its best to represent you through these difficult times. In order to do that we met regularly via telephone conference calls; the other means not being easy in our rural area where not everyone has access to computers and Zoom.</p>
<p>Where possible we continued consultations on planning applications and strived with local residents to have reduced speed limits in Tintern.</p>
<p>During the year the Welsh Assembly Government's boundary changes came into force in May 2022. WVCC consists of Chapel Hill & Tintern Parva Wards in Tintern and Llandogo. There were financial decisions associated with these changes that were aimed to achieve parity across the community.</p>
<p>In addition to our usual commitments, we once again funded the Business Map which is published to provide advertising for businesses in the village.</p>
<p>Wye Valley Community Council has spent large sums on the maintenance of Tintern Village Hall and financed projects for Llandogo Village Hall.</p>
<p>WVCC upheld TCC’s commitment to provide a specific play item for the newly refurbished Playground in Tintern.</p>
<p>In conclusion I would like to thank my fellow Councillors, our Clerk and County Councillor for their stalwart support throughout the year.</p>
<p>Stephanie Shewell Chair 2022/23</p>
</div>
<?PHP
require 'bottom.html';
?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>?>

