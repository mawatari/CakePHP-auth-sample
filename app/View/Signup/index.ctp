<?php
/**
 * @var $this View
 */
?>

<h2>新規登録</h2>
<?php echo $this->Form->create('User'); ?>
	<div class='email'>
		<?php
		echo($this->Form->label('email', 'メールアドレス: '));
		echo($this->Form->text('email'));
		echo($this->Form->error('email'));
		?>
	</div>

	<div class='password'>
		<?php
		echo($this->Form->label('password', 'パスワード: '));
		echo($this->Form->password('password'));
		echo($this->Form->error('password'));
		?>
	</div>
<?php echo($this->Form->end('送信')); ?>
