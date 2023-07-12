<?PHP
//cSpell:disable
$title = "Annual Report - what we cost";
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
<a class="button" href="annualreport.php" title="annual report main page">What we do</a> <a class="button" href="chairsreport.php" title="chair's report">Chair's report</a> <a class="button" href="futureplans.php" title="plans for the future">Our plans for the future</a>  
<h2>WHAT WE COST</h2>
<p>Running a Community Council obviously costs money as well as the time and effort of your Community Councillors. The money we receive forms a very small part of your Council Tax (known as our precept) and our costs are shown below</p>
<?PHP
$table->heading();
$table->setBackgrounds(['lightgray'],['lightgray']);
$table->setStyles(['b','b']);
$table->text("Salary, etc");
$table->setStyles(['','']);
$table->setBackgrounds(['white','white']);
$table->row(["Clerk's salary",3800]);
$table->row(["Clerk's expenses, Home Allowance, Stationery",800]);
$table->row(["Councillor expenses",250]);
$table->row(["Councillor training",50]);
$table->row(["Chairman's honoraria",300]);
$table->setBackgrounds(['lightgray'],['lightgray']);
$table->setStyles(['b','b']);
$table->text("Administration and office costs");
$table->setStyles(['','']);
$table->setBackgrounds(['white','white']);
$table->row(["Hall hire",200]);
$table->row(['Elections',200]);
$table->row(['Audit, Council insurance and Village Hall insurance',1700]);
$table->row(['Data protection fee & Gwent magistrates appeal fee',100]);
$table->setBackgrounds(['lightgray'],['lightgray']);
$table->setStyles(['b','b']);
$table->text("Amenities");;
$table->setStyles(['','']);
$table->setBackgrounds(['white','white']);
$table->row(['Fetes and festivals',500]);
$table->row(['Halls and playgrounds',0]);
$table->row(['Maintenance',10000]);
$table->row(['Safety inspections',100]);
$table->row(['Churches and churchyards',500]);
$table->row(['Fetes and festivals',500]);
$table->setBackgrounds(['lightgray'],['lightgray']);
$table->setStyles(['b','b']);
$table->text("Web sites and IT");
$table->setStyles(['','']);
$table->setBackgrounds(['white','white']);
$table->row(['Wye Valley Community Council and Tintern Village sites',150]);
$table->setBackgrounds(['lightgray'],['lightgray']);
$table->setStyles(['b','b']);
$table->text("Subscription, projects and donations");
$table->setStyles(['','']);
$table->setBackgrounds(['white','white']);
$table->row(["Subscriptions One Voice Wales and Society of Local Council Clerks",220]);
$table->row(["Tintern News and Charities",400]);
$table->row(["Education grants and Church Brigade",600]);
$table->row(["Projects",1000]);
$table->setStyles('b','b');
$table->row(["Total expenditure",20870]);
$table->text("INCOME");
$table->setStyles(['','']);
$table->row(["Precept",20870]);

$table->print();
?>
</div>
<?PHP
require 'bottom.html';
?>
 <script type="text/javascript">
  handleMenu($('#report'));
</script>?>
