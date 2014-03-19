<!-- File: /App/Template/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
echo $this->Form->create($user);
echo $this->Form->input('username');
echo $this->Form->input('password', ['type' => 'password']);
echo $this->Form->input('id', ['type' => 'hidden']);
echo $this->Form->button('Save User');
echo $this->Form->end();
?>