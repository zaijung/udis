<?php global $pmc_data;

if(isset($pmc_data['use_grid']) && $pmc_data['use_grid'] == 1){
	get_template_part('category_grid');
}
else {
	get_template_part('category_default');
}?>			