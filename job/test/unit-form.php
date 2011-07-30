<?php
include 'job-app.inc';
use webgloo\common\ui\form as Form ;

echo intval('31.3');

$post = array('name' => 'rajeev', 'age' => '35.3' , 'pan' => 'adopj0487d', 'address' => '');
$fhandler = new Form\Handler('web-form-1',$post);

$fhandler->addRule('name', 'Name', array('required' => 1 , 'minlength' => 6) );
$fhandler->addRule('age', 'Median Age', array('required' => 1 , 'maxval' => 26) );
$fhandler->addRule('address', 'Home Address', array('required' => 1) );


echo " errors \n ";
print_r($fhandler->getErrors());
echo "\n\n values \n";
print_r($fhandler->getValues());

?>


