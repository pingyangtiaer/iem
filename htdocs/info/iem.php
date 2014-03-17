<?php
include("../../config/settings.inc.php");
include("../../include/myview.php");
$t = new MyView();
$t->title = "Information";
$t->content = <<<EOF

<h3 class="heading">Iowa Environmental Mesonet</h3>

<br><div class="text"><h3 class="subtitle">Background</h3>
<p>The Iowa Environmental Mesonet [IEM] aims to gather, collect,
compare, disseminate and archive observations made in Iowa.  Unlike other 
mesonet projects, the IEM does not own or operate any of the automated stations.
Rather, the IEM collects data from existing resources in the state.  The result
is a low-cost, high resolution mesonet for use in a wide 
range of disciplines.

<br><br>One of the first questions we are often asked is, 'What does
Mesonet mean?' <i>Meso-net</i> is a combination of two meteorological
terms.  <i>Meso</i> refers to a spatial scale on which Meteorologists
define certain weather phenomena. In the context of an observing network,
<i>meso</i> refers to a spatial scale at which a network of sensors can
resolve mesoscale phenomena.  Mesonet implies a spatially and temporarily
dense set of observing stations.</p>

<br><h3 class="subtitle">Partners</h3>
<p>The IEM would not be possible without the generous cooperation
and support from federal, state and local agencies as well as the private 
sector.  These groups have been very supportive of the IEM and responsive to
requests made by the IEM. Among these include...
<ul>
 <li>Iowa Department of Transportation [IaDOT]</li>
 <li>Iowa State University & Department of Agronomy [ISU]</li>
 <li>KCCI-TV8 Des Moines, Iowa [KCCI]</li>
 <li>National Weather Service [NWS]</li>
</ul>

<br><h3 class="subtitle">Data Networks</h3>
<p>As of 1 April 2002, the IEM is gathering information from 
over 7 permanent observing networks in the State.  These networks include...
<ul>
 <li>Automated Surface Observing System [<a href="/ASOS/">ASOS</a>]</li>
 <li>Automated Weather Observing System [<a href="/AWOS/">AWOS</a>]</li>
 <li>Cooperative Observer Program [<a href="/COOP/">COOP</a>]</li>
 <li>River Gauges / Data Collection Platforms [<a href="/DCP/">DCP</a>]</li>
 <li>Iowa State Agricultural Climate Network [<a href="/agclimate">ISUAG</a>]</li>
 <li>Roadway Weather Information System [<a href="/RWIS/">RWIS</a>]</li>
 <li>Soil Climate Analysis Network [<a href="/scan/">SCAN</a>]</li>
 <li>KCCI-TV8 School Network [<a href="/schoolnet/">SNET</a>]</li>
</ul></p>

<p>Clearly, the aforementioned list provides a wide range of
measurements for the state of Iowa.  The networks have <b>not</b> been
developed for similar purposes.  The ASOS/AWOS stations are located at
Airports in support of aviation and weather prediction.  The SCAN site
provides detailed information about soil conditions and has no direct
application for use in aviation.  The RWIS sites are located near major
highways and provide pavement temperatures for frost forecasting and
chemical application guidance.  The ISUAG sites primarily monitor soil
temperatures and augment precipitation observations in the state. The
schoolnet sites, while located in poor meteorological locations, are
intended to give public visibility to the local station and serve as a
learning tool for students.  The DCP network provides river gauging needed
for flood prediction and observation.  The COOP provides a daily weather 
record for climatological use.

<br><br>If you put all of these networks together, you can see the value
that each network brings.  Combining them into one product is very
difficult, hence the need for the IEM.  Sites in different networks are 
not always similar in reporting
routines.  For example, many stations report wind information, but not 
every station is
at the same height or not every station averages the same way or not every
station reports in the same units.  These issues are important to consider
before beginning any quality control work.</p>

<br><h3 class="subtitle">Future of the IEM</h3>
<p>Public response to the IEM have and continue to be 
very positive.  It would be unproductive for the IEM to work on 
projects/products that the public has no interest in.  Feedback from 
end-users of the data is always welcome.  Currently, we are moving forward 
on these projects...
<ul>
 <li>Back-filling the IEM data archive from times before the IEM came into 
existance.</li>
 <li>Identifying locations in the state where new sensors/sites would be 
most beneficially placed.</li>
 <li>Building climatologies of stations and networks in the state.</li>
 <li>Maintaining/enhancing a meta-database of site information.</li>
 <li>Creating data products in GIS-ready formats.</li>
 <li>Meeting the data needs of end-users.</li>
 <li>Quality control issues.</li>
</ul>
<br><br>If you have any questions or comments, please let us know.
</p><p>

<h3 class="subtitle">IEM Contacts</h3>
<p>
<b>Dr Raymond Arritt</b>
<br>3010 Agronomy Hall
<br>Iowa State University
<br>Ames, IA 50010

<br>
<br><b>Daryl Herzmann</b>
<br>3010 Agronomy Hall
<br>Iowa State University
<br>Ames, IA 50010
</p>
EOF;
$t->render('single.phtml');
?>
