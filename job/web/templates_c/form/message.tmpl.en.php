

<?php if ($t->hasItems)  {?>


<?php if ($t->hasErrors)  {?>
<div class="script-error">
    <ul>
        <?php if ($this->options['strict'] || (is_array($t->errors)  || is_object($t->errors))) foreach($t->errors as $error) {?>
            <li> <?php echo htmlspecialchars($error);?> </li>
        <?php }?>

    </ul>

</div>
<?php }?>

<?php if ($t->hasMessages)  {?>
<div class="script-message">
    <ul>
        <?php if ($this->options['strict'] || (is_array($t->messages)  || is_object($t->messages))) foreach($t->messages as $message) {?>
            <li> <?php echo htmlspecialchars($message);?> </li>
        <?php }?>

    </ul>

</div>

<?php }?>

<div class="error_pad"></div>

<?php }?>
