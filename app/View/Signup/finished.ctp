<?php
/**
 * @var $this View
 */
?>

<?php
echo $this->Html->link('アクティベーション',
	[
		'controller' => 'signup',
		'action' => 'activate',
		$activation_code
	]
);
?>
