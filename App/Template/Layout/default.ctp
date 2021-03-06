<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset(); ?>
	<title>
		<?= $cakeDescription; ?>:
		<?= $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css([
				'cake.generic',
			]
		);
		
		echo $this->Html->script([
				'jquery.min',
			]
		);
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

<script type="text/javascript">
	$(document).ready(function(){
		
		$(".article_status").click(function(){
			var id = parseInt($(".article_status").attr("id"));
			if(id > 0){
				$.ajax({
					url: 'articles/ajax',
					type: 'POST',
					dataType: 'JSON',
					data: {id:id},
					success: function(data){
						if(data.value === false){
							alert('error return');
						} else {
							alert('succes return');
						}
					},
					error: function(xhr, textStatus, error){
						alert('Error js: ' + textStatus);
					}
				});
			}
			return false;
		});
		
		$(".article_delete").click(function(){
			var id = parseInt($(".article_delete").attr("id"));
			if(id > 0){
				var alertConfirm = confirm("Desea eliminar el registro");
				if(alertConfirm){
					$.ajax({
						url: 'articles/ajaxDelete',
						type: 'POST',
						dataType: 'JSON',
						data: {id:id},
						success: function(data){
							if(data.value === false){
								alert('error return');
							} else {
								alert('succes return');
							}
						},
						error: function(xhr, textStatus, error){
							alert('Error js: ' + textStatus);
						}
					});
				}
			}
			return false;
		});
		
	});
</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?= $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">
			<?= $this->Session->flash(); ?>

			<?= $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?= $this->element('sql_dump'); ?>
</body>
</html>
