<?PHP
//cSpell:disable
$title = "Annual Report - what we do";
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
<p>Our annual report has been distributed, where possible, as a printed leaflet for those who have no access to the internet. If required a printed copy may be obtained from the Clerk.</p>
<div style="position:sticky;top:0;background:white;">
<a class="button" href="whatwecost.php" title="what we cost">What we cost</a> <a class="button" href="chairsreport.php" title="chair's report">Chair's report</a> <a class="button" href="futureplans.php" title="plans for the future">Our plans for the future</a>  
</div>
<h2>What we do</h2>
    <p>Community Councils are made up of local people who give their time working for and on behalf of their community.</p><p>WVCC meets on the last Monday of every month (except December and Bank Holidays), either in Tintern or Llandogo Village Hall. Starting at 19:00, the meetings last approximately two hours and are open to members of the public. Each meeting starts with a public forum for individuals to raise concerns. Our chief responsibility is to make known the concerns of local people to Monmouthshire County Council (MCC) and other public bodies, for example, the Police, Welsh Assembly Government (WAG) and Natural Resources Wales (NRW).</p><p>MCC has a duty to consult with WVCC over local services such as planning and licensing applications.</p><p>In addition WVCC:</p>
    <ul>
    <li>Provides grants for the maintenance of the churchyards in Tintern and Llandogo. Provides small grants for local projects and charities e.g. Monmouth Children's Services, new playground equipment, etc.</li>
    <li>Pays for the provision and emptying of dog waste bins.</li>
    <li>Owns and maintains benches and notice boards.</li>
    <li>Consults with local residents on planning applications.</li>
    <li>Reports highways problems to MCC.</li>
    <li>Consults with MCC and the Police on issues of speed and road safety.</li>
    <li>Reports issues concerning public rights of way such as stiles, diversions and blockages.</li>
    <li>Liaises with the Police on issues of anti-social behaviour, drug abuse, speeding, crime, etc.</li>
    <li>Appoints representatives on village hall committees, Llandogo School, Tintern and Llandogo Churches and the Wye Valley Villages Project.</i>
    <li>Owns Tintern Village Hall and supports both Tintern & Llandogo Village Halls.</li>
    </ul>

</div>
<?PHP
 require 'bottom.html';
 ?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>