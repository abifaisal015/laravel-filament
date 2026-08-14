<?php

it('displays the custom login screen', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSeeText('Laravel')
        ->assertSeeText('Sign in');
});
