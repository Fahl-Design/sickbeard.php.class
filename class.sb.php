<?php


$sbh = new sbh;



class sbh {
	function banner($tvdbid) {
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sb_banner = "<img src='".$sburl . "show.getbanner&tvdbid=". $tvdbid."' class='img-responsive'> "; 
		return $sb_banner;
	}
	function url_banner($tvdbid) {
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sb_banner = $sburl . "show.getbanner&tvdbid=". $tvdbid; 
		return $sb_banner;
	}
	function poster($tvdbid) {
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sb_poster= "<img src='".$sburl . "show.getposter&tvdbid=". $tvdbid."' class='img-responsive'> "; 
		return $sb_poster;
	}
	function url_poster($tvdbid) {
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sb_poster= $sburl . "show.getposter&tvdbid=". $tvdbid; 
		return $sb_poster;
	}
	function showinfo($sb_show)
	 {
			global $sb;
			global $sbh;
			global $sb_ip;
			global $sb_api;
			$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
			$sbqry = 'show&tvdbid='.$sb_show;
			$feed = $sburl . $sbqry;
			$sbJSON = json_decode(file_get_contents($feed));
			echo '<strong>Titel:</strong> '.$sbJSON->{data}->{show_name} .'<br>';
			echo '<strong>Status:</strong> '.$sbJSON->{data}->{status} .'<br>';
			echo '<strong>Quality: </strong>'.$sbJSON->{data}->{quality} .'<br>';
			echo '<strong>Networkt: </strong>'.$sbJSON->{data}->{network} .'<br>';
	}
	function showpopup($sb_show)
	 {
			global $sb;
			global $sbh;
			global $sb_ip;
			global $sb_api;
			$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
			$sbqry = 'show&tvdbid='.$sb_show;
			$feed = $sburl . $sbqry;
			$sbJSON = json_decode(file_get_contents($feed));
			/*
			echo '<strong>Titel:</strong> '.$sbJSON->{data}->{show_name} .'<br>';
			echo '<strong>Status:</strong> '.$sbJSON->{data}->{status} .'<br>';
			echo '<strong>Quality: </strong>'.$sbJSON->{data}->{quality} .'<br>';
			echo '<strong>Networkt: </strong>'.$sbJSON->{data}->{network} .'<br>';
			*/
			echo '<div data-role="popup" id="'.$sb_show.'" data-overlay-theme="b" data-theme="b" data-corners="false">';
	    	echo '	<a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>';
			echo '	<img class="popphoto" src="'.$sbh->url_poster($sb_show).'" style="max-height:512px;" alt="'.$sbJSON->{data}->{show_name} .'">';
			echo '</div>';
			
			
	}
}




$sb = new sb;

class sb {

	function history($sb_limit)
	{	
		global $sb;
		global $sbh;
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sbqry = "history&limit=".$sb_limit."&type=downloaded";
		$feed = $sburl . $sbqry;
		$sbJSON = json_decode(file_get_contents($feed));
		echo '<ul class="list-group">';
		foreach($sbJSON->{data} as $show) {
		

			echo '<li class="list-group-item">';
			echo '    <span class="badge">S'. $show->{season} .'E'. $show->{episode} .'</span>';
			echo '	'.$show->{show_name} . '<br>' . $sbh->banner($show->{tvdbid});
			echo '</li>';
		}
		echo '</ul>';
	}
	
	function showlist() 
	{
		global $sb;
		global $sbh;
		global $sb_ip;
		global $sb_api;
		$sburl = 'http://' . $sb_ip . '/api/' . $sb_api .'/?cmd=';
		$sbqry = "shows";
		$feed = $sburl . $sbqry;
		$sbJSON = json_decode(file_get_contents($feed));
		echo '<ul class="list-group">';
		foreach($sbJSON->{data} as $show) {
			$sbbanner = $sburl . "show.getbanner&tvdbid=". $show->{tvdbid} ; 
			echo '<li class="list-group-item">';
			echo '<span class="badge">'. $show->{network} .'</span>';
//			echo '<a href="#'.$show->{tvdbid}.'" data-rel="popup" class="ui-btn ui-corner-all ui-shadow ui-btn-inline" data-transition="slide">'.$show->{show_name}.$sbh->banner($show->{tvdbid}).'</a>';
			
			echo '<a href="#'.$show->{tvdbid}.'" data-rel="popup" data-position-to="window" data-transition="fade"><img class="popphoto" src="'.$sbh->url_banner($show->{tvdbid}).'" alt="'.$show->{show_name}.'" style="width:40%"></a><br>';
			
			$sbh->showinfo($show->{tvdbid});
			$sbh->showpopup($show->{tvdbid});
			echo '</li>';
			}
		echo '</ul>';
	}
	
		

	
	}
?>