<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Recenzenti;

/**
 * Recenzenti controller.
 *
 * @Route("/recenzenti")
 */
class RecenzentiController extends Controller
{
    /**
     * Lists all Recenzenti entities.
     *
     * @Route("/", name="recenzenti")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Recenzenti')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($recenzentis, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('recenzenti/index.html.twig', array(
            'recenzentis' => $recenzentis,
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
        $filterForm = $this->createForm('AppBundle\Form\RecenzentiFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('RecenzentiControllerFilter');
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
                $session->set('RecenzentiControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RecenzentiControllerFilter')) {
                $filterData = $session->get('RecenzentiControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\RecenzentiFilterType', $filterData);
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
            return $me->generateUrl('recenzenti', $requestParams);
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
     * Displays a form to create a new Recenzenti entity.
     *
     * @Route("/new", name="recenzenti_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $recenzenti = new Recenzenti();
        $form   = $this->createForm('AppBundle\Form\RecenzentiType', $recenzenti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recenzenti);
            $em->flush();
            
            $editLink = $this->generateUrl('recenzenti_edit', array('id' => $recenzenti->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New recenzenti was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'recenzenti' : 'recenzenti_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('recenzenti/new.html.twig', array(
            'recenzenti' => $recenzenti,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Recenzenti entity.
     *
     * @Route("/{id}", name="recenzenti_show")
     * @Method("GET")
     */
    public function showAction(Recenzenti $recenzenti)
    {
        $deleteForm = $this->createDeleteForm($recenzenti);
        return $this->render('recenzenti/show.html.twig', array(
            'recenzenti' => $recenzenti,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Recenzenti entity.
     *
     * @Route("/{id}/edit", name="recenzenti_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recenzenti $recenzenti)
    {
        $deleteForm = $this->createDeleteForm($recenzenti);
        $editForm = $this->createForm('AppBundle\Form\RecenzentiType', $recenzenti);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recenzenti);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('recenzenti_edit', array('id' => $recenzenti->getId()));
        }
        return $this->render('recenzenti/edit.html.twig', array(
            'recenzenti' => $recenzenti,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Recenzenti entity.
     *
     * @Route("/{id}", name="recenzenti_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Recenzenti $recenzenti)
    {
    
        $form = $this->createDeleteForm($recenzenti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recenzenti);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Recenzenti was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Recenzenti');
        }
        
        return $this->redirectToRoute('recenzenti');
    }
    
    /**
     * Creates a form to delete a Recenzenti entity.
     *
     * @param Recenzenti $recenzenti The Recenzenti entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recenzenti $recenzenti)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recenzenti_delete', array('id' => $recenzenti->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Recenzenti by id
     *
     * @Route("/delete/{id}", name="recenzenti_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Recenzenti $recenzenti){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($recenzenti);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Recenzenti was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Recenzenti');
        }

        return $this->redirect($this->generateUrl('recenzenti'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="recenzenti_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Recenzenti');

                foreach ($ids as $id) {
                    $recenzenti = $repository->find($id);
                    $em->remove($recenzenti);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'recenzentis was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the recenzentis ');
            }
        }

        return $this->redirect($this->generateUrl('recenzenti'));
    }
    

}
