<aside class="right-side">
	<section class="content">
		<div class="row">
			<div id="frame">
				<table>
					<tbody>
					<?php 
					for($i = 0, $size = count($farm)-1; $i < $size; $i++) {
						if($i == 0) 
							echo '<tr>';
						
						if($flag == 1){
							echo '</tr>';
							echo '<tr>';
							$flag = 0;
						}
						if($farm[$i]['id_field'] == $farm[$i+1]['id_field']) {
							echo '<td>';
						    	echo '<div id="'.$farm[$i]['section_name'].'"style="width:60px; height:60px; border:1px solid #aaaaaa; 
						    	background:#CCFF99"><center>'.$farm[$i]['section_name'].'</center></div>';
						    echo '</td>';
						}else
							$flag = 1;
						
						if($i == $size - 1)
							echo '</tr>';
					}?>
			        </tbody>
			    </table>
		    </div>
		    <div  id="drag1" class="drag">
				<img id="treatment" src="<?=base_url()?>/public/img/treat.gif" width="40" height="40" />
			</div>
		</div>
	</section>

	

</aside>