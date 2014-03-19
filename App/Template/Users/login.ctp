<!-- File: /App/Template/Users/login.ctp -->

<h1>Login User</h1>
<?php
echo $this->Form->create($user);
echo $this->Form->input('username');
echo $this->Form->input('password', ['type' => 'password']);
echo $this->Form->button('Save User');
echo $this->Form->end();
?>