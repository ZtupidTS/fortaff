<?php
// contains a set of rules based on particular controller function 

$config = array(
    'admin/editprofile' => array(
        array(
            'field' => 'userName',
            'label' => 'Username',
            'rules' => 'required'
        ),
        array(
            'field' => 'userEmail',
            'label' => 'Password',
            'rules' => 'required'
        )
    ),
);
?>
