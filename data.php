<?php
$array = array (
		'ticks' => array (
				'EMY',
				'CHERLY',
				'MOLLY',
				'DINA',
				'DIVINE',
				'SARAH' 
		),
		'color' => array (
				'#FB1D1D',
				'#FF9502',
				'#A3FF00',
				'#FFFB12' 
		),
		'data' => array (
				'data1' => array (
						100,
						110,
						50,
						40,
						0,
						40 
				),
				'data2' => array (
						90,
						90,
						90,
						40,
						0,
						70 
				),
				'data3' => array (
						20,
						80,
						100,
						20,
						0,
						20 
				),
				'data4' => array (
						10,
						40,
						10,
						20,
						0,
						20 
				) 
		) 
);
echo json_encode ( $array, true );
?>