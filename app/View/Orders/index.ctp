<br/>
<form action="<?php echo $this->Html->url([
'controller' => 'orders',
'action' => 'alicreate',
    ]); ?>" method="post" name="form">
<p>Please fill out the form below to register an account.</p>
<label>Username:</label><input name="username" size="40" />

<label>Password:</label><input type="password" name="password" size="40"
/>

<label>Email Address:</label><input name="email" size="40" 
maxlength="255" />

<label>First Name:</label><input name="first_name" size="40" />

<label>Last Name:</label><input name="last_name" size="40" />

<label>price :</label><input name="last_name" size="40" type="text" 
value="<?php 
    echo $this->get('monthly_price') 
?>"
/>
<input type="submit" value="register" />
</form>
