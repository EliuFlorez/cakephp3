<!-- File: /App/Template/Articles/add.ctp -->

<h1>Add Article</h1>
<?php
echo $this->Form->create('Article', array('action'=>'add'));
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => '3']);
echo $this->Form->button('Save Article');
echo $this->Form->end();
?>