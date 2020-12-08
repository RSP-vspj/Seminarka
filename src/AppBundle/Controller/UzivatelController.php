<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use AppBundle\Entity\Uzivatel;

/**
 * Uzivatel controller.
 *
 * @Route("/uzivatel")
 */
class UzivatelController extends Controller
{
    /**
     * Lists all Uzivatel entities.
     *
     * @Route("/", name="uzivatel")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Uzivatel')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($uzivatels, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('uzivatel/index.html.twig', array(
            'uzivatels' => $uzivatels,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, Request $request)
    {
        $session = $request->getSession();
        $filterForm = $this->createForm('AppBundle\Form\UzivatelFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('UzivatelControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->handleRequest($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('UzivatelControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('UzivatelControllerFilter')) {
                $filterData = $session->get('UzivatelControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\UzivatelFilterType', $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }


    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('uzivatel', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
        ));

        return array($entities, $pagerHtml);
    }



    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Showing $startRecord - $endRecord of $totalOfRecords Records.";
    }



    /**
     * Displays a form to create a new Uzivatel entity.
     *
     * @Route("/new", name="uzivatel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $uzivatel = new Uzivatel();
        $form   = $this->createForm('AppBundle\Form\UzivatelType', $uzivatel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $uzivatel->getHeslo();
            $encoded = $encoder->encodePassword($uzivatel, $plainPassword);
            $uzivatel->setHeslo($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($uzivatel);
            $em->flush();

            $editLink = $this->generateUrl('uzivatel_edit', array('id' => $uzivatel->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New uzivatel was created successfully.</a>" );

            $nextAction=  $request->get('submit') == 'save' ? 'uzivatel' : 'uzivatel_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('uzivatel/new.html.twig', array(
            'uzivatel' => $uzivatel,
            'form'   => $form->createView(),
        ));
    }



    /**
     * Finds and displays a Uzivatel entity.
     *
     * @Route("/{id}", name="uzivatel_show")
     * @Method("GET")
     */
    public function showAction(Uzivatel $uzivatel)
    {
        $deleteForm = $this->createDeleteForm($uzivatel);
        return $this->render('uzivatel/show.html.twig', array(
            'uzivatel' => $uzivatel,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Uzivatel entity.
     *
     * @Route("/{id}/edit", name="uzivatel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Uzivatel $uzivatel, UserPasswordEncoderInterface $encoder)
    {
        $deleteForm = $this->createDeleteForm($uzivatel);
        $editForm = $this->createForm('AppBundle\Form\UzivatelType', $uzivatel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $plainPassword = $uzivatel->getHeslo();
            $encoded = $encoder->encodePassword($uzivatel, $plainPassword);
            $uzivatel->setHeslo($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($uzivatel);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('uzivatel_edit', array('id' => $uzivatel->getId()));
        }
        return $this->render('uzivatel/edit.html.twig', array(
            'uzivatel' => $uzivatel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Uzivatel entity.
     *
     * @Route("/{id}", name="uzivatel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Uzivatel $uzivatel)
    {
    
        $form = $this->createDeleteForm($uzivatel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($uzivatel);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Uzivatel was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Uzivatel');
        }
        
        return $this->redirectToRoute('uzivatel');
    }
    
    /**
     * Creates a form to delete a Uzivatel entity.
     *
     * @param Uzivatel $uzivatel The Uzivatel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Uzivatel $uzivatel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('uzivatel_delete', array('id' => $uzivatel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Uzivatel by id
     *
     * @Route("/delete/{id}", name="uzivatel_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Uzivatel $uzivatel){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($uzivatel);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Uzivatel was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Uzivatel');
        }

        return $this->redirect($this->generateUrl('uzivatel'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="uzivatel_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Uzivatel');

                foreach ($ids as $id) {
                    $uzivatel = $repository->find($id);
                    $em->remove($uzivatel);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'uzivatels was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the uzivatels ');
            }
        }

        return $this->redirect($this->generateUrl('uzivatel'));
    }
    

}
