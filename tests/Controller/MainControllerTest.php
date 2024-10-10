<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterDisplaysForm()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="registration_form"]');
    }

    public function testSubmitValidRegistrationForm()
    {
        $client = static::createClient();
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $security = $this->createMock(Security::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $passwordHasher->method('hashPassword')->willReturn('hashed_password');
        $security->method('login')->willReturn($this->createMock(Response::class));

        $client->getContainer()->set('security.password_hasher', $passwordHasher);
        $client->getContainer()->set('security.helper', $security);
        $client->getContainer()->set('doctrine.orm.entity_manager', $entityManager);

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Inscription')->form([
            'registration_form[firstname]' => 'firstname',
            'registration_form[lastname]' => 'lastname',
            'registration_form[pseudo]' => 'pseudo',
            'registration_form[address]' => 'address',
            'registration_form[zipcode]' => 'zipcode',
            'registration_form[city]' => 'city',
            'registration_form[country]' => 'FR',
            'registration_form[avatar]' => 'avatar',
            'registration_form[plainPassword]' => 'password',
            'registration_form[email]' => 'testuser@example.com',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/some_redirect_route'); 
    }

    public function testAvatarUpload()
    {
        $client = static::createClient();
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $security = $this->createMock(Security::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $passwordHasher->method('hashPassword')->willReturn('hashed_password');
        $security->method('login')->willReturn($this->createMock(Response::class));

        $client->getContainer()->set('security.password_hasher', $passwordHasher);
        $client->getContainer()->set('security.helper', $security);
        $client->getContainer()->set('doctrine.orm.entity_manager', $entityManager);

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form([
            'registration_form[username]' => 'testuser',
            'registration_form[plainPassword]' => 'password',
            'registration_form[email]' => 'testuser@example.com',
            'registration_form[avatar]' => new UploadedFile(
                __DIR__.'/fixtures/avatar.png',
                'avatar.png',
                'image/png',
                null
            ),
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/some_redirect_route'); // Remplacez par la route de redirection appropriée
    }
}


?>