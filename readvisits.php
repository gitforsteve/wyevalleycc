<?PHP
header('X-Robots-Tag: noindex');
$hash = '$2y$10$MiMvBQjAA8ufm44O/2Y9muqU1GN0noSd/d/VCtZwAd4sJ0CXHdFiC';
if(isset($_SERVER['QUERY_STRING'])){
  if(!password_verify($_SERVER['QUERY_STRING'], $hash)){
    exit;
  }
}

function days_in_month($month, $year){
  return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}
require 'classes.php';
$colours = Array('red','blue','green','yellow');
$spectrum = $colours[mt_rand(0,3)];
$database = new Database("Visitor");

$data = $database->getData("SELECT * FROM newvisits");
// get rid of older data
$thisyear = date("Y");
$result = [];
foreach($data as $item){
	$dt = substr($item->id,-4);
	if((int)$thisyear - (int)$dt < 3){
		$result[] = $item;
	}
}

$last = file_get_contents('lastreading.json');
$lastreading = json_decode($last);

?>
<html>
  <head>
    <style type="text/css">
      canvas {border:1px solid lightblue;}
    </style>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/randomColor.js"></script>
    <script type="text/javascript">
      var colors;
      function setColours(hue){
	colors = randomColor({
	  hue: hue,
	  count: 30,
	  format: 'rgba'
	});
      }
      $(document).ready(function(){
	var datachart = $('#data');
	var jArray = <?php echo json_encode($result);?>;
	var datachartd1 = [], datachartd2 = [];
	setColours('<?=$spectrum?>');
	for(var i=0;i<jArray.length;i++){
	  datachartd1.push(jArray[i].id);
	  datachartd2.push(jArray[i].visits);
	}
	var myDataChart = new Chart(datachart, {
	  type: 'bar',
	  options: {
	    maintainAspectRatio: false,
	    responsive: false,
	    title: {
	      display: true,
	      text: "WEB SITE VISITS"
	    },
	  },
	  data: {
	    labels: datachartd1,
	    datasets: [{
	      label: 'Visits',
	      data: datachartd2,
      	      backgroundColor: colors,
	      borderColor: 'darkgray',
	      borderWidth: 2
	    }]
	  }
	});
      });
    </script>
   </head>
  <body>
    <?PHP
      print("<table style='overflow-y:scroll;height:700px;display:block;'><tr><td>Month</td><td style='text-align:right;'>Count</td><td style='text-align:right;'>Daily</td></tr>");
      foreach($result as $visit){
		$d = strtotime('1 '.$visit->id);
		$days = days_in_month(date('m',$d), date('Y',$d));
		$lastday = strtotime($days.' '.$visit->id);
		$today = strtotime("now");
		if($today > $lastday){
		$avg = number_format($visit->visits/$days,2);
		}else{
		$avg = number_format($visit->visits/date('d'),2);
		}
		$year = date("Y",$d);
		$thisyear = date("Y");
		//if($thisyear - $year < 2){
			printf("<tr><td>%s</td><td style='text-align:right;'>%d</td><td style='text-align:right;'>%s</td></tr>",$visit->id,$visit->visits,$avg);
		//}
      }
      printf("<tr style='color:lightgray;'><td>Last reading</td><td style='text-align:right;'>%s %s</td></tr>",$lastreading->date,$lastreading->lastreading);
      print("</table>");
      $obj = Array("lastreading"=>$visit->visits,"date"=>date("d/m/Y"));
      $f = fopen('lastreading.json','w+');
      fwrite($f, json_encode($obj));
      fclose($f);
    ?>
    <canvas class="rounded" id="data" width="900" height="300">LOADING</canvas>
  </body>
</html>
