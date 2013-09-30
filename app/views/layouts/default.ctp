<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php
	$enproduccion = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Aplicación Vacunas Sanatorio Santa Cristina'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
	<?php
		echo $this->Html->meta('icon');
		
		if($enproduccion) {
			echo $this->Html->css('estilosall-min');
		} else {
			echo $this->Html->css('estilos');
			echo $this->Html->css('/js/jquery-ui-1.8.13.custom');
			echo $this->Html->css('/js/tipTip');
		}
		
	?>

</head>
<body>
		<div id="header">
			<?php echo $this->element('header');?>
		</div>
		<div id="content">
			<script type="text/javascript">var elemento = document.getElementById('content'); elemento.className = 'js';</script>
			<div id="bodywrapper">
				<?php echo $this->Session->flash(); ?>
				<?php echo $content_for_layout; ?>
			</div>	

		</div>
		<div id="footer">
			<?php echo $this->element('footer');?>
		</div>
	<?php echo $this->element('sql_dump'); ?>
	
	<!-- JavaScript at the bottom for fast page loading -->

	  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
	  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	  	<script>window.jQuery || document.write("<script src='js/jquery-1.5.1.min.js'>\x3C/script>")</script>
	
	  <!-- scripts concatenated and minified via ant build script-->
	  	<?php if($enproduccion) { ?>
	  	<?php echo $this->Html->script('jsall-min'); ?>
	  	<?php } else { ?>
	  	<?php echo $this->Html->script('jquery-ui-1.8.13.custom.min'); ?>
	  	<?php echo $scripts_for_layout; ?>
	  	<?php echo $this->Html->script('functions'); ?>
	  	<?php } ?>
	  	
	  <!-- end scripts-->
      
   <!-- end of Javascript -->
</body>
</html>