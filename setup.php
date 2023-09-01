<?php
session_start();

//db connection

$conn = mysqli_connect('localhost', 'root', '', 'digi3');
if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);			
	}
else {
	$eventdatareset = "TRUNCATE TABLE events";
	$webcamdatareset = "TRUNCATE TABLE webcams";
	$query_reset= mysqli_query($conn, $eventdatareset);
	$query_reset2= mysqli_query($conn, $webcamdatareset);
			
	
$database_query = $conn->prepare("CREATE DATABASE IF NOT EXISTS digi3");
$database_query -> execute();

$conn = mysqli_connect('localhost', 'root', '', 'digi3');
$table_query = $conn->prepare("CREATE TABLE IF NOT EXISTS events(event VARCHAR(50),
																		impact VARCHAR(50), 
																		towards VARCHAR(50),
																		direction VARCHAR(50),
																		roadname VARCHAR(50),
																		city VARCHAR(50),
																		start DATETIME,
																		end DATETIME,
																		advice VARCHAR(50))");
$table_query -> execute();

$conn = mysqli_connect('localhost', 'root', '', 'digi3');
$table_query = $conn->prepare("CREATE TABLE IF NOT EXISTS webcams(URL VARCHAR(100),
																		description VARCHAR(100))");
$table_query -> execute(); 	

//api connection

$endpointw = 'webcams';
$endpointe = 'events';
$acess_key = '3e83add325cbb69ac4d8e5bf433d770b';

include("curlsetup.php");
$urle='https://api.qldtraffic.qld.gov.au/v2/'.$endpointe.'?apikey='.$acess_key.'';
$urlw='https://api.qldtraffic.qld.gov.au/v1/'.$endpointw.'?apikey='.$acess_key.'';

$theinfoe=get_web_page($urle);
$theinfow=get_web_page($urlw);

$Eventjsone=json_decode($theinfoe['content'], true);
$Eventjsonw=json_decode($theinfow['content'], true);

$totale=count($Eventjsone['features']);
$totalw=count($Eventjsonw['features']);

//db insert

$newdata_query1=$conn->prepare("INSERT IGNORE INTO webcams VALUES (?,?)");

//first 'for' loop

for ($i=0; $i<=$totalw-1; $i++)
{
	echo "<b>image url:</b>".$Eventjsonw['features'][$i]['properties']['image_url']."<br><br>";

	echo "<b>description:".$Eventjsonw['features'][$i]['properties']['description']."<br><br>";

	$newdata_query1->bind_param("ss",$Eventjsonw['features'][$i]['properties']['image_url'],$Eventjsonw['features'][$i]['properties']['description']);   
             						
	$newdata_query1->execute();

}

//db query

$newdata_query2=$conn->prepare("INSERT IGNORE INTO events VALUES (?,?,?,?,?,?,?,?,?)");

//second  'for loop' 

for ($i=0; $i<=$totale-1; $i++)
{


			echo "<b>event type:</b>".$Eventjsone['features'][$i]['properties']['event_type']."<br><br>";

			if (isset($Eventjsone['features'][$i]['properties']['impact']['impact_subtype']))
				{
					echo "<b>impacted lanes:</b>".$Eventjsone['features'][$i]['properties']['impact']['impact_subtype']."<br><br>";
					$acn=$Eventjsone['features'][$i]['properties']['impact']['impact_subtype'];
						}
						else
					{
				echo "<b>Impacted Lanes:</b> NA<br><br>";
				$acn="NA";
					}
			
			if (isset($Eventjsone['features'][$i]['properties']['impact']['towards']))
				{
					echo "<b>towards:</b>".$Eventjsone['features'][$i]['properties']['impact']['towards']."<br><br>";
					$acn1=$Eventjsone['features'][$i]['properties']['impact']['towards'];
						}
						else
					{
				echo "<b>towards:</b> NA<br><br>";
				$acn1="NA";
					} 		

			echo "<b>direction:</b>".$Eventjsone['features'][$i]['properties']['impact']['direction']."<br><br>";

			echo "<b>road name:</b>".$Eventjsone['features'][$i]['properties']['road_summary']['road_name']."<br><br>";

			echo "<b>city:</b>".$Eventjsone['features'][$i]['properties']['road_summary']['local_government_area']."<br><br>";

			echo "<b>start date:</b>".$Eventjsone['features'][$i]['properties']['duration']['start']."<br><br>";

			if (isset($Eventjsone['features'][$i]['properties']['duration']['end']))
				{
					echo "<b>end date:</b>".$Eventjsone['features'][$i]['properties']['duration']['end']."<br><br>";
					$acn1=$Eventjsone['features'][$i]['properties']['duration']['end'];
						}
						else
					{
				echo "<b>end date:</b> NA<br><br>";
				$acn1="NA";
					}

			echo "<b>advice:</b>".$Eventjsone['features'][$i]['properties']['advice']."<br><br>";
			

			$newdata_query2->bind_param("sssssssss",$Eventjsone['features'][$i]['properties']['event_type'],$Eventjsone['features'][$i]['properties']['impact']['impact_subtype'],$Eventjsone														['features'][$i]['properties']['impact']['towards'],$Eventjsone['features'][$i]['properties']['impact']['direction'],$Eventjsone['features'][$i]																	['properties']['road_summary']['road_name'],$Eventjsone['features'][$i]['properties']['road_summary']['local_government_area'],$Eventjsone['features']														[$i]['properties']['duration']['start'],$Eventjsone['features'][$i]['properties']['duration']['end'],$Eventjsone['features'][$i]['properties']['advice']													);

			$newdata_query2->execute();

	}

	}
?>
