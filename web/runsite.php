<?php  
require("dbinfo.php");
require("system.php");

$pft_id=15;

# parameters
if (!isset($_REQUEST['siteid'])) {
  die("Need a siteid.");
}
$siteid=$_REQUEST['siteid'];

if (!isset($_REQUEST['pft'])) {
  die("Need a pft.");
}
$pft=$_REQUEST['pft'];

if (!isset($_REQUEST['met'])) {
  die("Need a met.");
}
$met=$_REQUEST['met'];

if (!isset($_REQUEST['psscss'])) {
  die("Need a psscss.");
}
$psscss=$_REQUEST['psscss'];

if (!isset($_REQUEST['start'])) {
  die("Need a start.");
}
$start=$_REQUEST['start'];

if (!isset($_REQUEST['end'])) {
  die("Need a end.");
}
$end=$_REQUEST['end'];

// Opens a connection to a MySQL server
$connection=mysql_connect ($hostname, $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
} 

// get site information
$query = "SELECT * FROM sites WHERE sites.id=$siteid";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
$siteinfo = mysql_fetch_assoc($result);
print_r($siteinfo);

# folders
mkdir("$folder",  0777, true);
$folder = tempnam($output_folder, 'PEcAn_');
unlink($folder);
if (!mkdir("$folder/out",  0777, true)) {
    die("Failed to create folders $folder/out");
}
if (!mkdir("$folder/pecan",  0777, true)) {
    die("Failed to create folders $folder/pecan");
}
if (!mkdir("$folder/pft",  0777, true)) {
    die("Failed to create folders $folder/pft");
}
if (!mkdir("$folder/run",  0777, true)) {
    die("Failed to create folders $folder/run");
}

// create the run
$params=mysql_real_escape_string(str_replace("\n", "", var_export($_REQUEST, true)));
if (mysql_query("INSERT INTO runs (site_id, start_time, finish_time, outdir, parameter_list, created_at, started_at) values ('$siteid', '$start', '${end}', '${folder}', '${params}', NOW(), NOW())") === FALSE) {
	die('Can\'t insert run : ' . mysql_error());
}
$runid=mysql_insert_id();

# create pecan.xml
$fh = fopen("$folder/pecan.xml", 'w');
fwrite($fh, "<?xml version=\"1.0\"?>" . PHP_EOL);
fwrite($fh, "<pecan>" . PHP_EOL);
fwrite($fh, "  <pecanDir>${pecan_home}</pecanDir>" . PHP_EOL);
fwrite($fh, "  <outdir>${folder}/pecan/</outdir>" . PHP_EOL);
fwrite($fh, "  <pfts>" . PHP_EOL);
foreach($pft as $p) {
	if (!mkdir("${folder}/pft/${pft_id}",  0777, true)) {
		die("Failed to create folders $folder/pft");
	}
	fwrite($fh, "    <pft>" . PHP_EOL);
	fwrite($fh, "      <name>${p}</name> " . PHP_EOL);
	fwrite($fh, "      <outdir>${folder}/pft/${pft_id}/</outdir>" . PHP_EOL);
	fwrite($fh, "      <edin>${folder}/template.pavi</edin>" . PHP_EOL);
	fwrite($fh, "      <constants>" . PHP_EOL);
	fwrite($fh, "        <num>${pft_id}</num>" . PHP_EOL);
	fwrite($fh, "        <phenology>2</phenology>" . PHP_EOL);
	fwrite($fh, "        <max_dbh>0.78</max_dbh>" . PHP_EOL);
	fwrite($fh, "        <hgt_min>2.0</hgt_min>" . PHP_EOL);
	fwrite($fh, "        <dark_respiration_factor>0.015</dark_respiration_factor>" . PHP_EOL);
	fwrite($fh, "        <qsw>0.0</qsw>" . PHP_EOL);
	fwrite($fh, "        <mort1>1.0</mort1>" . PHP_EOL);
	fwrite($fh, "        <plant_min_temp>-100</plant_min_temp>" . PHP_EOL);
	fwrite($fh, "        <storage_turnover_rate>0</storage_turnover_rate>" . PHP_EOL);
	fwrite($fh, "        <mort2>32.0439606614782</mort2>" . PHP_EOL);
	fwrite($fh, "        <growth_resp_factor>0.25571351984367</growth_resp_factor>" . PHP_EOL);
	fwrite($fh, "        <leaf_turnover_rate>4.07940798578859</leaf_turnover_rate>" . PHP_EOL);
	fwrite($fh, "        <leaf_width>0.00583301333358546</leaf_width>" . PHP_EOL);
	fwrite($fh, "        <nonlocal_dispersal>0.213605956298449</nonlocal_dispersal>" . PHP_EOL);
	fwrite($fh, "        <q>1.33458694386225</q>" . PHP_EOL);
	fwrite($fh, "        <root_turnover_rate>0.667528983849579</root_turnover_rate>" . PHP_EOL);
	fwrite($fh, "        <seedling_mortality>0.983858724584934</seedling_mortality>" . PHP_EOL);
	fwrite($fh, "        <stomatal_slope>3.44101445626496</stomatal_slope>" . PHP_EOL);
	fwrite($fh, "        <r_fract>0.31506190134535</r_fract>" . PHP_EOL);
	fwrite($fh, "        <root_respiration_factor>1.80614305233583</root_respiration_factor>" . PHP_EOL);
	fwrite($fh, "        <Vm_low_temp>10.0027508263303</Vm_low_temp>" . PHP_EOL);
	fwrite($fh, "        <SLA>33.4394271188472</SLA>" . PHP_EOL);
	fwrite($fh, "        <Vm0>17.0857612325517</Vm0>" . PHP_EOL);
	fwrite($fh, "        <quantum_efficiency>0.0572563220569342</quantum_efficiency>" . PHP_EOL);
	fwrite($fh, "      </constants>" . PHP_EOL);
	fwrite($fh, "    </pft>" . PHP_EOL);
	$pft_id++;
}
fwrite($fh, "  </pfts>" . PHP_EOL);
fwrite($fh, "  <database>" . PHP_EOL);
fwrite($fh, "    <name>bety</name>" . PHP_EOL);
fwrite($fh, "    <userid>${username}</userid>" . PHP_EOL);
fwrite($fh, "    <passwd>${password}</passwd>" . PHP_EOL);
fwrite($fh, "    <location>${hostname}</location>" . PHP_EOL);
fwrite($fh, "  </database>" . PHP_EOL);
fwrite($fh, "  <meta.analysis>" . PHP_EOL);
fwrite($fh, "    <iter>1000</iter>" . PHP_EOL);
fwrite($fh, "    <random.effects>TRUE</random.effects>" . PHP_EOL);
fwrite($fh, "  </meta.analysis>" . PHP_EOL);
fwrite($fh, "  <ensemble>" . PHP_EOL);
fwrite($fh, "    <size>1</size>" . PHP_EOL);
fwrite($fh, "  </ensemble>" . PHP_EOL);
fwrite($fh, "  <config.header>" . PHP_EOL);
fwrite($fh, "    <radiation>" . PHP_EOL);
fwrite($fh, "      <lai_min>0.01</lai_min>" . PHP_EOL);
fwrite($fh, "    </radiation>" . PHP_EOL);
fwrite($fh, "    <ed_misc>" . PHP_EOL);
fwrite($fh, "      <output_month>12</output_month>      " . PHP_EOL);
fwrite($fh, "    </ed_misc> " . PHP_EOL);
fwrite($fh, "  </config.header>" . PHP_EOL);
fwrite($fh, "  <run>" . PHP_EOL);
fwrite($fh, "    <id>${runid}</id>" . PHP_EOL);
fwrite($fh, "    <folder>${folder}</folder>" . PHP_EOL);
fwrite($fh, "    <site>" . PHP_EOL);
fwrite($fh, "      <name>{$siteinfo['sitename']}</name>" . PHP_EOL);
fwrite($fh, "      <lat>{$siteinfo['lat']}</lat>" . PHP_EOL);
fwrite($fh, "      <lon>{$siteinfo['lon']}</lon>" . PHP_EOL);
fwrite($fh, "      <met>$met</met>" . PHP_EOL);
fwrite($fh, "      <psscss>$psscss</psscss>" . PHP_EOL);
fwrite($fh, "    </site>" . PHP_EOL);
fwrite($fh, "    <start.date>$start</start.date>" . PHP_EOL);
fwrite($fh, "    <end.date>$end</end.date>" . PHP_EOL);
fwrite($fh, "    <host>" . PHP_EOL);
fwrite($fh, "      <name>localhost</name>" . PHP_EOL);
fwrite($fh, "      <rundir>${folder}/run/</rundir>" . PHP_EOL);
fwrite($fh, "      <outdir>${folder}/out/</outdir>" . PHP_EOL);
fwrite($fh, "      <ed>" . PHP_EOL);
fwrite($fh, "        <binary>$ed_binary</binary>" . PHP_EOL);
fwrite($fh, "        <veg>$ed_veg</veg>" . PHP_EOL);
fwrite($fh, "        <soil>$ed_soil</soil>" . PHP_EOL);
fwrite($fh, "        <inputs>$ed_inputs</inputs>" . PHP_EOL);
fwrite($fh, "      </ed>" . PHP_EOL);
fwrite($fh, "    </host>" . PHP_EOL);
fwrite($fh, "  </run>" . PHP_EOL);
fwrite($fh, "</pecan>" . PHP_EOL);
fclose($fh); 

# copy template.pavi
copy("template.pavi", "${folder}/template.pavi");

# execute runall.sh
shell_exec("sed -e 's#@PECAN_HOME@#${pecan_home}#' runall.sh > ${folder}/runall.sh");
chdir($folder);
pclose(popen('bash ./runall.sh >/dev/null &', 'r'));

#done
header("Location: running.php?runid=$runid");
?>
