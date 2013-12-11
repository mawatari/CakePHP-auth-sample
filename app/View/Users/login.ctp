<?php
/**
 * @var $this View
 */
?>

<h2>ログイン</h2>
<?php
echo($this->Form->create('User'));
echo($this->Form->label('email'));
echo($this->Form->text('email'));
echo($this->Form->label('password'));
echo($this->Form->password('password'));
echo($this->Form->end('ログイン'));
?>

<?php if (count($errors)): ?>
<ul>
	<?php foreach ($errors as $error): ?>
		<li><?php echo $error ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
