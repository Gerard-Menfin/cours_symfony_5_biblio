<?php

namespace App\Security;

use App\Entity\Abonne;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    /* COURS 1- on ajoute une propriété  */
    private $security;

    /* COURS 2- Il faut utiliser la classe Security avec l'injection de dépendance */
    public function __construct(private UrlGeneratorInterface $urlGenerator, Security $security)
    // public function __construct(Security $security, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, 
    //                             CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        /* COURS 3- on affecte la propriété $security */
        $this->security = $security;

    }

    //// public function supports(Request $request)
    //// {
    ////     return self::LOGIN_ROUTE === $request->attributes->get('_route')
    ////         && $request->isMethod('POST');
    //// }

    //// public function getCredentials(Request $request)
    //// {
    ////     $credentials = [
    ////         'pseudo' => $request->request->get('pseudo'),
    ////         'password' => $request->request->get('password'),
    ////         'csrf_token' => $request->request->get('_csrf_token'),
    ////     ];
    ////     $request->getSession()->set(
    ////         Security::LAST_USERNAME,
    ////         $credentials['pseudo']
    ////     );
//
    ////     return $credentials;
    //// }

    //// public function getUser($credentials, UserProviderInterface $userProvider)
    //// {
    ////     $token = new CsrfToken('authenticate', $credentials['csrf_token']);
    ////     if (!$this->csrfTokenManager->isTokenValid($token)) {
    ////         throw new InvalidCsrfTokenException();
    ////     }
    ////     $user = $this->entityManager->getRepository(Abonne::class)->findOneBy(['pseudo' => $credentials['pseudo']]);
    ////     if (!$user) {
    ////         // fail authentication with a custom error
    ////         throw new CustomUserMessageAuthenticationException('Pseudo could not be found.');
    ////     }
    ////     return $user;
    //// }

    //// public function checkCredentials($credentials, UserInterface $user)
    //// {
    ////     return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    //// }

    //// /**
    ////   Used to upgrade (rehash) the user's password automatically over time.
    ////  /
    //// public function getPassword($credentials): ?string
    //// {
    ////     return $credentials['password'];
    //// }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $pseudo = $request->request->get('pseudo', '');

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        /* COURS 0- pour pouvoir faire une redirection selon le rôle de l'utilisateur, il faut utiliser la classe Security 
            (cf. constructeur) */
        
        /* COURS 4- on peut définir une route de redirection selon le rôle de l'utilisateur qui vient de se connecter 
            grâce à la méthode "isGranted" */
        if($this->security->isGranted("ROLE_ADMIN")){
            $route = "admin_gestion";
        } elseif($this->security->isGranted("ROLE_BIBLIOTHECAIRE")) {
            $route = "biblio_gestion";
        } else {
            $route = "profil";
        }

        return new RedirectResponse($this->urlGenerator->generate("app_$route"));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    public function authenticate(Request $request): Passport
    {
        $pseudo = $request->request->get('pseudo', '');

        $request->getSession()->set(Security::LAST_USERNAME, $pseudo);

        return new Passport(
            new UserBadge($pseudo),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }    
}
