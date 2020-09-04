<?php

namespace App\Controller;

use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login",name="app_login")
     */
    public function login(AuthorizationCheckerInterface $authorizationChecker ,AuthenticationUtils $authenticationUtils): Response
    {
        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute("cover_list");
        } else if ($authorizationChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("shop");
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

/**
* @Route("/register", name="app_register")
*/
    public function register(Request $request, EntityManagerInterface $entityManager ,UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() )
        {
            /**@var User $user*/
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('success', 'Votre compte a bien ete crée !');

            return $this -> redirectToRoute("app_login");
        }
        return $this->render('security/registrer.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

