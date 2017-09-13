<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'username' => 'valid',
            'location' => [
                'zipCode' => 'valid',
                'address' => 'valid',
            ]
        );

        $form = $this->factory->create(UserType::class);

        $validUser = new User();
        $validUser->setAddress($formData['location']['address']);
        $validUser->setZipCode($formData['location']['zipCode']);
        $validUser->setUsername($formData['username']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($validUser, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
