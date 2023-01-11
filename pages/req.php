<?php 

//$page = $_SERVER['PHP_SELF'];
//$sec = "60";


function integerToRoman($integer)
{
 // Convert the integer into an integer (just to make sure)
 $integer = intval($integer);
 $result = '';
 
 // Create a lookup array that contains all of the Roman numerals.
 $lookup = array('M' => 1000,
 'CM' => 900,
 'D' => 500,
 'CD' => 400,
 'C' => 100,
 'XC' => 90,
 'L' => 50,
 'XL' => 40,
 'X' => 10,
 'IX' => 9,
 'V' => 5,
 'IV' => 4,
 'I' => 1);
 
 foreach($lookup as $roman => $value){
  // Determine the number of matches
  $matches = intval($integer/$value);
 
  // Add the same number of characters to the string
  $result .= str_repeat($roman,$matches);
 
  // Set the integer to be the remainder of the integer and the value
  $integer = $integer % $value;
 }
 
 // The Roman numeral should be built, return it
 return $result;
}

?>


<meta http-equiv="Cache-control" content="public">




<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>



<!-- Bootstrap Core CSS -->
    <link href="/emergenze/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- Bootstrap Plugins -->
<link href="/emergenze/vendor/bootstrap-table/dist/bootstrap-table.css" rel="stylesheet">

<link href="/emergenze/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="/emergenze/vendor/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="/emergenze/vendor/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.css"
    rel="stylesheet">
<link href="/emergenze/vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">


<!-- Leaflet CSS -->
<link href="/emergenze/vendor/leaflet/leaflet.css" rel="stylesheet">
<link href=<?php echo "\"$leaflet_measure_path\""; ?> rel="stylesheet">
<!-- <link href="l_map/css/leaflet-measure.css" rel="stylesheet"> -->


<!-- MetisMenu CSS -->
<link href="/emergenze/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="/emergenze/dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="/emergenze/vendor/morrisjs/morris.css" rel="stylesheet">

<!--link href="/emergenze/vendor/highcharts/code/css/highcharts.css" rel="stylesheet"-->

<!-- Custom Fonts -->
<link href="/emergenze/vendor/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet" type="text/css">

<link href="/emergenze/vendor/font-awesome-animation/dist/font-awesome-animation.css" rel="stylesheet" type="text/css">
 
    <style type="text/css">
    #wrapper { 
    	/*padding-top:50px;*/
		padding-top: $('.navbar').height()
    }

	
	.sidebar{
		overflow-y: scroll;
		position: fixed;
		margin-top: 0px;
		z-index:1;
	}

      .panel-allerta {
		  border-color: <?php echo $color_allerta; ?>;
		}
		.panel-allerta > .panel-heading {
		  border-color: <?php echo $color_allerta; ?>;
		  color: white;
		  background-color: <?php echo $color_allerta; ?>;
		}
		.panel-allerta > a {
		  color: <?php echo $color_allerta; ?>;
		}
		.panel-allerta > a:hover {
		  color: #337ab7;
		  /* <?php echo $color_allerta; ?>;*/
		}
      
      
		.dot {
  height: 25px;
  width: 25px;
  /*background-color: #bbb;*/
  border-radius: 50%;
  display: inline-block;
}      
      
      
      .fa{ 
    -webkit-print-color-adjust: exact;
		}

	  .fas{ 
    -webkit-print-color-adjust: exact;
		}
		
		
      
      @media print
   {
   	
   	/* commentata riga 191 del file bootstrap.css per consentire la stampa dei colori*/ 
   	.fa{ 
    -webkit-print-color-adjust: exact;
		}

	  .fas{ 
    -webkit-print-color-adjust: exact;
		}
		
	  p.bodyText {
		  font-family:georgia, times, serif;
		  -webkit-print-color-adjust: exact;
		  color-adjust: exact;
	  }
	  
	  .rows-print-as-pages .row {
		page-break-before: auto;
	  }
	  
	  .btn {
    		display: none;
  		}
	  
	  
	   table,
		table tr td,
		table tr th {
			page-break-inside: avoid;
		}

		.collapse {
   	display: block !important;
   	height: auto !important;
	}
	
	
	#break {
		 page-break-before: always;
	}
	
	.fa-inverse {
        color: #fff !important;
    }
	  .noprint
	  {
		display:none
	  }
	  
	  
   }
   
      
      
      </style>
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- jQuery -->
<script src="/emergenze/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap js -->
<script src="/emergenze/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap table -->
<script src="/emergenze/vendor/bootstrap-table/dist/bootstrap-table.js"></script>

<!--  load jquery UI  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/excite-bike/jquery-ui.css" rel="stylesheet">

<!-- GRAFICI d3js -->
<script src="https://d3js.org/d3.v4.min.js"></script>

<!-- GRAFICI highcart -->
<script src="/emergenze/vendor/highcharts/code/highcharts.js"></script>
<script src="/emergenze/vendor/highcharts/code/modules/stock.js"></script>
<script src="/emergenze/vendor/highcharts/code/modules/data.js"></script>
<script src="/emergenze/vendor/highcharts/code/modules/exporting.js"></script>
<script src="/emergenze/vendor/highcharts/code/modules/export-data.js"></script>

