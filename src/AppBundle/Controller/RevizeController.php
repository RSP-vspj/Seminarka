<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Revize;

/**
 * Revize controller.
 *
 * @Route("/revize")
 */
class RevizeController extends Controller
{
    /**
     * Lists all Revize entities.
     *
     * @Route("/", name="revize")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Revize')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($revizes, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('revize/index.html.twig', array(
            'revizes' => $revizes,
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
        $filterForm = $this->createForm('AppBundle\Form\RevizeFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('RevizeControllerFilter');
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
                $session->set('RevizeControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RevizeControllerFilter')) {
                $filterData = $session->get('RevizeControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\RevizeFilterType', $filterData);
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
            return $me->generateUrl('revize', $requestParams);
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
     * Displays a form to create a new Revize entity.
     *
     * @Route("/new", name="revize_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $revize = new Revize();
        $form   = $this->createForm('AppBundle\Form\RevizeType', $revize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($revize);
            $em->flush();
            
            $editLink = $this->generateUrl('revize_edit', array('id' => $revize->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New revize was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'revize' : 'revize_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('revize/new.html.twig', array(
            'revize' => $revize,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Revize entity.
     *
     * @Route("/{id}", name="revize_show")
     * @Method("GET")
     */
    public function showAction(Revize $revize)
    {
        $deleteForm = $this->createDeleteForm($revize);
        return $this->render('revize/show.html.twig', array(
            'revize' => $revize,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Revize entity.
     *
     * @Route("/{id}/edit", name="revize_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Revize $revize)
    {
        $deleteForm = $this->createDeleteForm($revize);
        $editForm = $this->createForm('AppBundle\Form\RevizeType', $revize);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($revize);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('revize_edit', array('id' => $revize->getId()));
        }
        return $this->render('revize/edit.html.twig', array(
            'revize' => $revize,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Revize entity.
     *
     * @Route("/{id}", name="revize_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Revize $revize)
    {
    
        $form = $this->createDeleteForm($revize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($revize);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Revize was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Revize');
        }
        
        return $this->redirectToRoute('revize');
    }
    
    /**
     * Creates a form to delete a Revize entity.
     *
     * @param Revize $revize The Revize entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Revize $revize)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('revize_delete', array('id' => $revize->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Revize by id
     *
     * @Route("/delete/{id}", name="revize_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Revize $revize){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($revize);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Revize was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Revize');
        }

        return $this->redirect($this->generateUrl('revize'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="revize_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Revize');

                foreach ($ids as $id) {
                    $revize = $repository->find($id);
                    $em->remove($revize);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'revizes was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the revizes ');
            }
        }

        return $this->redirect($this->generateUrl('revize'));
    }
    

}
