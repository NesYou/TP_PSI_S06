<?php
    
namespace OC\PlatformBundle\Controller;
    
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
    
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;


    
class AdvertController extends Controller {
    
    public function testAction(){
//      $advert = new Advert();
//      $advert->setTitle("Recherche développeur !");
//      $advert->setAuthor("Jean");
//      $advert->setContent("Recherche un développeur !");
//
//      $em = $this->getDoctrine()->getManager();
//      $em->persist($advert);
//      $em->flush(); // C'est à ce moment qu'est généré le slug
//
//      return new Response('Slug généré : '.$advert->getSlug());
//      // Affiche « Slug généré : recherche-developpeur »
        $advert = new Advert;
        
        $advert->setDate(new \Datetime());  // Champ « date » OK
        $advert->setTitle('abc');           // Champ « title » incorrect : moins de 10 caractères
        //$advert->setContent('blabla');    // Champ « content » incorrect : on ne le définit pas
        $advert->setAuthor('A');            // Champ « author » incorrect : moins de 2 caractères
        
        // On récupère le service validator
        $validator = $this->get('validator');
        
        // On déclenche la validation sur notre object
        $listErrors = $validator->validate($advert);

        // Si $listErrors n'est pas vide, on affiche les erreurs
        if(count($listErrors) > 0) {
        // $listErrors est un objet, sa méthode __toString permet de lister joliement les erreurs
            return new Response((string) $listErrors);
        } else {
            return new Response("L'annonce est valide !");
        }
    }
    
    public function indexAction($page) {
               
        $nbPerPage = 3;
        
        //Ici, on récupére la liste des annonces, puis on la passe au template
        $listAdverts = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('OCPlatformBundle:Advert')
                        ->getAdverts($page, $nbPerPage)
        ;
        
        $nbPages = ceil(count($listAdverts) / $nbPerPage);
        
        //Une page ne peut être négative
        if($page > $nbPages) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
                       
        //Appel du template index.html.twig
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }
        
    public function viewAction($id) {
        
        $em = $this->getDoctrine()->getManager();
            
        //On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
            
        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
            
        //On récupère la liste des candidatures de cette annonce
        $listApplications = $em
                ->getRepository('OCPlatformBundle:Application')
                ->findBy(array('advert' => $advert))
        ;
            
        //On récupère la liste des AdvertSkill
        $listAdvertSkills = $em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findBy(array('advert' => $advert))
        ;
            
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills
        ));
            
    }
        
    public function addAction(Request $request){
        $advert = new Advert();
        $form   = $this->get('form.factory')->create(AdvertType::class, $advert);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

          return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
          'form' => $form->createView(),
        ));
  }
        
    public function editAction($id, Request $request) {
        
        $em = $this->getDoctrine()->getManager();    
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
        $form = $this->createForm(AdvertEditType::class, $advert);
                 
        //Si la requête est en POST, c'est que le visiteur qui a soumis le formulaire
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée');
            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }
            
        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'form'      => $form->createView(),
            'advert'    => $advert,
        ));
    }
        
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em->remove($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

          return $this->redirectToRoute('oc_platform_home');
        }

        return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
          'advert' => $advert,
          'form'   => $form->createView(),
        ));
    }
        
    public function menuAction($limit) {
        
        $em = $this
                ->getDoctrine()
                ->getManager()
        ;
            
        $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
                array(),                    //Pas de critère
                array('date' => 'desc'),    //On trie par date décroissante
                $limit,                     //On sélectionne $limit annonces
                0                           //A partir du premier
        );
            
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }    
}