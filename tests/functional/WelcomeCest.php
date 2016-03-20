<?php

class WelcomeCest
{
  public function testWelcomePage(FunctionalTester $i)
  {
    $i->amOnPage('/');
    $i->seeResponseCodeIs(200);
    $i->seeInTitle('SQRT');
  }

  public function testInTransaction(FunctionalTester $i)
  {
    $m = $i->getManager();

    $u = $m->getRepository('users')->make();
    $u->set('name', 'Vasya');
    $u->save();

    $i->amOnPage('/');
    $i->seeResponseCodeIs(200);
    $i->seeLink('Vasya', '/form/' . $u['id']);
  }

  public function testMockService(FunctionalTester $i)
  {
    $m = $i->getManager();

    $user = new \User($m);
    $user->setName('Pupkinson');
    $user->setId(123);

    $mock = $i->mockService(\Repository\Users::class);
    $mock->shouldReceive('find')->once()->andReturn(new \Base\Collection([$user]));

    $i->amOnPage('/');
    $i->seeResponseCodeIs(200);
    $i->seeLink('Pupkinson', '/form/' . 123);
  }
}
