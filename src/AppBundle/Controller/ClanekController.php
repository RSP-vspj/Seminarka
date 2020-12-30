<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Clanek;

/**
 * Clanek controller.
 *
 * @Route("/clanek")
 */
class ClanekController extends Controller
{
    /**
     * Lists all Clanek entities.
     *
     * @Route("/", name="clanek")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Clanek')->createQueryBuilder('e');


        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($claneks, $pagerHtml) = $this->paginator($queryBuilder, $request);

        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('clanek/index.html.twig', array(
            'claneks' => $claneks,
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
        $filterForm = $this->createForm('AppBundle\Form\ClanekFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('ClanekControllerFilter');
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
                $session->set('ClanekControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ClanekControllerFilter')) {
                $filterData = $session->get('ClanekControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\ClanekFilterType', $filterData);
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
            return $me->generateUrl('clanek', $requestParams);
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
     * Displays a form to create a new Clanek entity.
     *
     * @Route("/new", name="clanek_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $clanek = new Clanek();
        $form   = $this->createForm('AppBundle\Form\ClanekType', $clanek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clanek);
            $em->flush();
            
            $editLink = $this->generateUrl('clanek_edit', array('id' => $clanek->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New clanek was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'clanek' : 'clanek_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('clanek/new.html.twig', array(
            'clanek' => $clanek,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Clanek entity.
     *
     * @Route("/{id}", name="clanek_show")
     * @Method("GET")
     */
    public function showAction(Clanek $clanek)
    {
        $deleteForm = $this->createDeleteForm($clanek);
        return $this->render('clanek/show.html.twig', array(
            'clanek' => $clanek,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Clanek entity.
     *
     * @Route("/{id}/edit", name="clanek_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Clanek $clanek)
    {
        $deleteForm = $this->createDeleteForm($clanek);
        $editForm = $this->createForm('AppBundle\Form\ClanekType', $clanek);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clanek);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('clanek_edit', array('id' => $clanek->getId()));
        }
        return $this->render('clanek/edit.html.twig', array(
            'clanek' => $clanek,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Clanek entity.
     *
     * @Route("/{id}", name="clanek_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Clanek $clanek)
    {
    
        $form = $this->createDeleteForm($clanek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($clanek);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Clanek was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Clanek');
        }
        
        return $this->redirectToRoute('clanek');
    }
    
    /**
     * Creates a form to delete a Clanek entity.
     *
     * @param Clanek $clanek The Clanek entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Clanek $clanek)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clanek_delete', array('id' => $clanek->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Clanek by id
     *
     * @Route("/delete/{id}", name="clanek_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Clanek $clanek){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($clanek);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Clanek was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Clanek');
        }

        return $this->redirect($this->generateUrl('clanek'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="clanek_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Clanek');

                foreach ($ids as $id) {
                    $clanek = $repository->find($id);
                    $em->remove($clanek);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'claneks was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the claneks ');
            }
        }

        return $this->redirect($this->generateUrl('clanek'));
    }
    

}
