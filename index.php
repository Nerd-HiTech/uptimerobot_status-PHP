<!DOCTYPE html>
<html>
	<head>
		<script src="js/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body>
		<?php
			$api_uptimerobot= 'u142481-e8ad7454b1327071daa36e5d';
			$danger_porcentage = 95.00;
			$success_porcentage = 99.00;
			
			$json_url_uptimerobot = "http://api.uptimerobot.com/getMonitors?apiKey=" .$api_uptimerobot. "&format=json&noJsonCallback=1";
			$json_uptimerobot = json_decode(file_get_contents($json_url_uptimerobot));
			$monitors = (array)$json_uptimerobot->monitors;
		?>
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th style="width:0;">Uptime</th>
						<th style="width:0;">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($json_uptimerobot->monitors->monitor as $monitor){
							$monitor = (array)$monitor;

							if ($monitor['status']==2){$server_status="Online";$status_color="success";}
								elseif($monitor['status']==9){$server_status="Offline";$status_color="danger";}
								else{$server_status="ERROR!";$color="danger";}
							
							if($monitor['alltimeuptimeratio']>=$success_porcentage){$uptime_color="success";}
							elseif($monitor['alltimeuptimeratio']>=$danger_porcentage){$uptime_color="default";}
							else{$uptime_color="danger";}
							
							if($monitor['status']!=2 && $monitor['alltimeuptimeratio']<=$danger_porcentage){$row_color="danger";}
								elseif($monitor['status']!=2 || $monitor['alltimeuptimeratio']<=$danger_porcentage){$row_color="warning";}
								else{$row_color="success";}

							$uptime=number_format($monitor['alltimeuptimeratio'],2,',','')."%";

							echo '<tr class="'.$row_color.'" href="'.$monitor['url'].'" target="_blank">';
							echo '<td><a href="'.$monitor['url'].'" target="_blank">'.$monitor['friendlyname'].'</a></td>';
							echo '<td class="text-right"><span class="label label-'.$uptime_color.'">'.$uptime.'</span></td>';
							echo '<td class="text-right"><span class="label label-'.$status_color.'">'.$server_status.'</span></td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>