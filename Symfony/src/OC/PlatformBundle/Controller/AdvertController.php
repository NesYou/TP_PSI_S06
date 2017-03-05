<?php
    
namespace OC\PlatformBundle\Controller;
    
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
    
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    
class AdvertController extends Controller {
    
    public function indexAction($page) {
        //Une page ne peut être négative
        if($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
            
        //Ici, on récupérera la liste des annonces, puis on la passera au template
            
        $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime())
    );
        
        //Appel du template index.html.twig
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
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
        
    public function addAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        //Création de l'entité Advert
        $advert = new Advert();
        $advert->setTitle('Recherche développeur Symfony');
        $advert->setAuthor('Alexandre');
        $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon.");
        
        $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();
        
        //Pour chaque compétences
        foreach($listSkills as $skill) {
            $advertSkill = new AdvertSkill();
            $advertSkill->setAdvert($advert);
            $advertSkill->setSkill($skill);
            
            $advertSkill->setLevel('Expert');
            
            $em->persist($advertSkill);
        }
            
        //Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');
            
        //On lie l'image à l'annonce
        $advert->setImage($image);
            
        //Création d'une première candidature
        $application1 = new Application();
        $application1->setAuthor('Pierre');
        $application1->setContent("Je suis très motivé.");
            
        //Création d'une deuxième candidature
        $application2 = new Application();
        $application2->setAuthor('Marie');
        $application2->setContent("J'ai toutes les qualités requises.");
            
        //On lie les candidatures à l'annonce
        $application1->setAdvert($advert);
        $application2->setAdvert($advert);
        
        //Etape 1 : On "persiste" l'entité
        $em->persist($advert);
            
        //Pas de cascade donc on persiste les candidatures à la main
        $em->persist($application1);
        $em->persist($application2);
            
        //Etape 2 : On "flush" tout ce qui a été persisté avant
        $em->flush();
            
        //Si la requête est en POST, c'est que le visiteur qui a soumis le formulaire
        if($request->isMethod('POST')) {
            //Ici on s'occupera de la création et de la gestion du formulaire
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                
            //Puis on redirige vers la page de visualisation de cette annonce
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
            
        //Si on est pas en POST, alors on affiche le formulaire
        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }
        
    public function editAction($id, Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        if(null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
        $listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();
        
        foreach($listCategories as $category) {
            $advert->addCategory($category);
        }
               
        $em->flush();
            
        //Si la requête est en POST, c'est que le visiteur qui a soumis le formulaire
        if($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée');
            return $this->redirectToRoute('oc_platform_edit', array('id' => 5));
        }
            
        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }
        
    public function deleteAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        foreach($advert->getCategories() as $category) {
            $advert->removeCategory($category);
        }
        
        $em->flush();
        
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }
        
    public function menuAction() {
        $listAdverts = array(
            array('id' => 2, 'title' => 'recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );
            
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }    
}