<?PHP
$title = "Annual Report";
$desc = "Our annual report";
require 'top.html';
?>
<html>
    <div class="nine-columns" id="content">
        <h1>Annual report</h1>
        <p style="font-weight:bold;font-size:3rem;">ANNUAL REPORT 2022/23</p>
        <h2>What we do</h2>
    <?PHP
    $txt = <<< para
    Community Councils are made up of local people who give their time working for and on behalf of their community.
WVCC meets on the last Monday of every month (except December and Bank Holidays), either in Tintern or Llandogo Village Gall. Starting at 19:00, the meetings last approximately two hours and are open to members of the public. Each meeting starts with a public forum for individuals to raise concerns. Our chief responsibility is to make known the concerns of local people to Monmouthshire County Council (MCC) and other public bodies, for example, the Police, Welsh Assembly Government (WAG) and Natural Resources Wales (NRW).
MCC has a duty to consult with WVCC over local services such as planning and licensing applications.
In addition WVCC:
Provides grants for the maintenance of the churchyards in Tintern and Llandogo. Provides small grants for local projects and charities e.g. Monmouth Children's Services, new playground equipment, etc.
Pays for the provision and emptying of dog waste bins.
Owns and maintains benches and notice boards.
Consults with local residents on planning applications.
Reports highways problems to MCC.
Consults with MCC and the Police on issues of speed and road safety.
Reports issues concerning public rights of way such as stiles, diversions and blockages.
Liaises with the Police on issues of anti-social behaviour, drug abuse, speeding, crime, etc.
Appoints representatives on village hall committees, Llandogo School, Tintern and Llandogo Churches and the Wye Valley Villages Project. Owns Tintern Village Hall and supports both Tintern & Llandogo Village Halls.
para;
    echo $txt;
    ?>
    </div>
</html>
<?PHP
require "bottom.html";
?>