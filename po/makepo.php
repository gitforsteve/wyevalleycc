<?PHP
//cSpell:disable
date_default_timezone_set("Europe/London");
require_once "sfpdf.php";
require_once "fpdi.php";
//load pdf
$pdf = new FPDI('P','mm',[210,297]);
$pdf->AddFont('typewriter','','Courier Prime.php');
$pdf->AddPage();
$pdf->setSourceFile("purchaseorder.pdf");
$tmp = $pdf->importPage(1);
$pdf->useTemplate($tmp);
$pdf->SetFont("typewriter",'',10);
$pdf->SetTextColor(0,0,0);
$supppos = [20,55];
$ourrefpos = [150,58];
$yourrefpos = [150,72];
$datepos = [157,80];
$descpos = [20,110];
$deldatepos = [20,187];
$periodpos = [82,187];
$placepos = [140,187];
$specialpos = [20,215];
$pricepos = [120,215];

$supplier = $_POST['supplier'];
$ourref = $_POST['ourref'];
$yourref = $_POST['yourref'];
$deldate = $_POST['deldate'];
$desc = $_POST['desc'];
$period = $_POST['period'];
$place = $_POST['place'];
$special = $_POST['special'];
$price = $_POST['price'];

$pdf->SetXY($supppos[0],$supppos[1]);
$pdf->MultiCell(115,5,$supplier);
$pdf->SetXY($ourrefpos[0],$ourrefpos[1]);
$pdf->Cell(45,5,$ourref);
$pdf->SetXY($yourrefpos[0],$yourrefpos[1]);
$pdf->Cell(45,5,$yourref);
$pdf->SetXY($datepos[0],$datepos[1]);
$pdf->Cell(165,5,date('jS F Y'));
$pdf->SetXY($descpos[0],$descpos[1]);
$pdf->MultiCell(160,5,$desc);
$pdf->SetXY($deldatepos[0],$deldatepos[1]);
$pdf->Cell(50,5,date('jS F Y',strtotime($deldate)),0,0,'C');
$pdf->SetXY($periodpos[0],$periodpos[1]);
$pdf->Cell(50,5,$period,0,0,'C');
$pdf->SetXY($placepos[0],$placepos[1]);
$pdf->Cell(50,5,$place,0,0,'C');
$pdf->SetXY($specialpos[0],$specialpos[1]);
$pdf->MultiCell(90,5,$special);
$pdf->SetXY($pricepos[0],$pricepos[1]);
$pdf->Cell(45,5,substr("£",1,1).number_format($price,2,'.',','),0,0,'C');

// TERM AND CONDITIONS
$pdf->AddPage();
$pdf->SetFont("arial","B");
$pdf->Cell(0,5,"TERMS AND CONDITIONS RELATING TO THIS ORDER",0,1,"C");
$pdf->Ln();
$pdf->SetFont('','',8);
$pdf->Write(3,"1 GENERAL These conditions of purchase and any matter referred to in Paragraph 5 specify all the terms of the contract between the buyer and the seller and are hereinafter referred to as 'the Contract'. All other terms whether oral or written express or implied whether pursuant to statute or otherwise are hereby excluded provided always that the buyer may opt to rely upon any other term which would otherwise have been expressly or impliedly incorporated herein. Without prejudice to the generality of the foregoing, the buyer will not be bound by any standard or printed terms furnished by the seller or by any trade practice or custom unless the seller specifically states in writing separately from the Contract that it intends such terms to apply in place of the Contract and the buyer has expressly accepted in writing that such terms shall apply in the place of the Contract.

2 VARIATION Neither the buyer nor the seller shall be bound by any variation, waiver of, or addition to these conditions except as agreed by both parties in writing and signed on their behalf.

3 SPECIFICATION, DESCRIPTION, SAMPLE The goods will be in conformity with the specifications, drawings, samples or other descriptions of the goods contained or referred to in this contract.

4 QUALITY The goods will be of satisfactory quality within the meaning of the Sale and Supply of Goods Act 1994 and free from defects in material or workmanship.

5 FITNESS FOR PURPOSE If the purpose for which the goods are required is made known to the seller expressly or by implication the goods shall be fit for that purpose.

6 THIRD PARTY RIGHTS The seller shall indemnify the buyer from and against all costs, claims, proceedings or demands in respect of any rights of any third party arising out of the sale or use of any goods supplied under the Contract, provided always that the seller shall not be required to indemnify the buyer against infringements of third party intellectual property rights where the goods are supplied to the particular design or specification of the buyer and that particular design or specification infringes third party intellectual property rights.

7 PRICES The prices stated in the order are firm.

8 PAYMENT Subject to the seller having met all his obligations the buyer shall pay for goods within 30 days of receipt of a valid invoice from the seller.

9 DELIVERY The goods must be delivered carriage paid to such destination as the buyer may direct. In the event that there shall be any loss or disruption to the buyer's property or business arising in connection with the delivery or non-delivery of the goods the seller shall pay to the buyer such sum as shall be certified by the buyer to be the value of such loss or disruption.

10 RISK The goods will be delivered at the seller's risk and shall remain at the seller's risk until written acceptance thereof has been given to the seller by the buyer.

11 TIME The time stipulated for delivery shall be of the essence.

12 PROPERTY The seller warrants to the buyer that he has good title to the goods and that the property in the goods shall pass to the buyer when the goods have been accepted to the buyer.

13 FORCE MAJEURE Neither the seller nor the buyer shall be liable to the other for any failure to fulfil its obligations under the Contract if such a failure is caused by circumstances beyond its reasonable control provided that if such circumstances shall occur then at the option of the buyer the Contract shall be void in its entirety or may be terminated by the buyer either in its entirety or in part.

14 REJECTION If any of the goods or part thereof, or the packages containing the same do not comply in every respect with the order or with any term of this contract including quantity, quality or description, the buyer shall be entitled to reject those goods or any part of them at any time after delivery irrespective of whether the buyer has accepted them. Any acceptance of such goods by the buyer shall be without prejudice to any rights that the buyer may have against the seller. The buyer shall be entitled to return any rejected goods, carriage forward, to the seller at the risk of the seller.

15 NON-DELIVERY If the seller does not deliver the goods or any part thereof within the time specified in the Contract then without prejudice to any other remedy, the buyer shall be entitled to terminate the Contract, purchase other goods of the same or similar description and recover from the seller the amount by which the cost of so purchasing other goods exceeds the price which would have been payable to the seller in respect of the goods replaced by such purchase.

16 INDEMNITY The seller shall indemnify the buyer against all claims, costs, expense, loss or damage whether direct or consequential which the buyer may suffer howsoever arising from the seller's breach of any of its obligations under this Contract

17 ASSIGNMENTS AND SUBCONTRACTING The seller shall not assign or transfer the whole or any part of the Contract or subcontract the production or supply of any goods to be supplied under this Contract without the prior written consent of the buyer.

18 LAW The contract shall be governed by English law.

19 WAIVER Failure by the buyer at any time to enforce the provisions of the Contract of whether to require performance strictly or otherwise by the seller of any of the provisions of the Contract or any failure or delay by the seller to exercise any act right or remedy shall not be construed as a waiver of or as creating an estoppel in connection with any such provisions and shall not affect the validity of the Contract or any part thereof or the right of the seller to enforce any provision.

20 CORRUPTION If the seller or his employees servants or agents whether with or without his knowledge does or has done anything improper to influence the buyer to enter into the Contract or commits an offence under the Prevention of Corruption Acts 1889 to 1916 or Section 117(2) of the Local Government Act 1972 the buyer will be entitled to terminate the Contract forthwith and recover any resulting losses from the seller.

21 GUARANTEE PERIOD The seller warrants to the buyer that the goods will continue to comply with the Contract for a period of 12 months from the date upon which the same are accepted by the buyer and will on demand by the buyer replace any goods or any part thereof stated in writing by the buyer to have failed to comply with the terms hereof.

22 USE OF INFORMATION PROVIDED The buyer is under a duty to protect the public funds it administers, and to this end may use the information you have provided such as contact and banking details for the prevention and detection of fraud. It may also share this information with other bodies responsible for auditing or administering public funds for these purposes.

23 DEFINITIONS The buyer shall mean Wye Valley Community Council The seller shall mean the person to whom the order for the goods was addressed The goods shall mean those goods specified by the buyer on or before the date of the Contract.");
$pdf->Output();
?>