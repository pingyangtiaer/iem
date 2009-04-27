<?php
include ("../../../include/jpgraph/jpgraph.php");
include ("../../../include/jpgraph/jpgraph_bar.php");

// 16 Oct 2007 select extract(year from day) as year, count(*) from (select day, count(*) from alldata WHERE precip >= 4 and year > 1950 and stationid IN (select stationid from alldata WHERE day = '1971-01-01') GROUP by day) as foo WHERE count > 1 GROUP by year ORDER by count ASC;


$d=array(92,100,104,106,108,109,207);
$datax=array("1945 (Least)\nJun 23 - Sep 23", 
             "2008\nMay 26 - Sep 03",
             "1935\nJun 12 - Sep 24",
             "1913\nMay 27 - Sep 10",
             "1957\nJun 03 - Sep 19",
             "1993\nMay 27 - Sep 13",
             "1910 (Most)\nMar 23 - Oct 16",
);

// Size of graph
$width=300; 
$height=300;

// Set the basic parameters of the graph 
$graph = new Graph($width,$height,'auto');
$graph->SetScale("textlin");
$graph->img->SetAntiAliasing();


// No frame around the image
$graph->SetFrame(false);

// Rotate graph 90 degrees and set margin
$graph->Set90AndMargin(110,5,40,28);

// Set white margin color
$graph->SetMarginColor('white');

// Use a box around the plot area
$graph->SetBox();

// Use a gradient to fill the plot area
$graph->SetBackgroundGradient('blue','lightblue',GRAD_HOR,BGRAD_PLOT);

// Setup title
$graph->title->Set("Days between first and last 90°F");
$graph->subtitle->Set("Based on Iowa data 1893-2008");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,11);

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);

// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(10);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// We don't want to display Y-axis
$graph->yaxis->Hide();

$graph->legend->Pos(0.1,0.92);
$graph->legend->SetLayout(LEGEND_HOR);


// Now create a bar pot
$bplot = new BarPlot($d);
$bplot->SetShadow();
$bplot->SetFillGradient('orange','red',GRAD_HOR);
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_BOLD,10);
//$bplot->value->SetAlign('left','center');
$bplot->value->SetColor("black");
$bplot->value->SetFormat('%.0f');
//$bplot->SetLegend("2008");
$bplot->SetValuePos('max');

$graph->Add($bplot);

// Add some explanation text
$txt = new Text("* 148 days is the climate mean");
$txt->SetPos(280,240);
$txt->SetFont(FF_COMIC,FS_NORMAL,8);
$graph->Add($txt);

// .. and stroke the graph
$graph->Stroke();
?>
