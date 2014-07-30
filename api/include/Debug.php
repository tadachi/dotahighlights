<?php
	function arrp() {
		$arrs = func_get_args();
		if (isset($arrs) && is_array($arrs)) {
			echo '
            <pre style="padding: 5px; font-size: 11px; line-height: 16px;">';
			foreach ($arrs as $key=>$val) {
				ob_start();
				var_dump($val);
				$o.=ob_get_contents();
				ob_end_clean();
			}
			echo htmlspecialchars($o, ENT_QUOTES);
			echo '</pre>';
         }
 }
?>
