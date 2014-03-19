<!-- File: /App/Template/Users/add.ctp -->

<h1>Add User</h1>
<?php
echo $this->Form->create($user);
echo $this->Form->input('username');
echo $this->Form->input('password', ['type' => 'password']);
echo $this->Form->button('Save User');
echo $this->Form->end();
?>