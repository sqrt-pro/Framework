<?php

class RouteCollection extends \Base\RouteCollection
{
  protected function init()
  {
    $this->get('/', 'Welcome::index');
    $this->get('/protected/', 'Welcome::protected');

    $this->get('/form/', 'Welcome::editUser');
    $this->get('/form/{id}', 'Welcome::editUser');
    $this->post('/form/', 'Welcome::saveUser');
    $this->post('/form/{id}', 'Welcome::saveUser');

    $this->get('/login/', 'Auth::login');
    $this->post('/login/', 'Auth::login');

    $this->get('/logout/', 'Auth::logout');
  }
}