<!-- File: /App/Template/Articles/edit.ctp -->

<h1>Edit Article</h1>
<?php
echo $this->Form->create('Article', array('action'=>'edit'));
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => '3']);
echo $this->Form->input('id', ['type' => 'hidden']);
echo $this->Form->button('Save Article');
echo $this->Form->end();
?>