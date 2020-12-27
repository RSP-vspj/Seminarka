<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Autori;

/**
 * Autori controller.
 *
 * @Route("/autori")
 */
class AutoriController extends Controller
{
    /**
     * Lists all Autori entities.
     *
     * @Route("/", name="autori")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Autori')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($autoris, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('autori/index.html.twig', array(
            'autoris' => $autoris,
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
        $filterForm = $this->createForm('AppBundle\Form\AutoriFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('AutoriControllerFilter');
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
                $session->set('AutoriControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('AutoriControllerFilter')) {
                $filterData = $session->get('AutoriControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\AutoriFilterType', $filterData);
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
            return $me->generateUrl('autori', $requestParams);
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
     * Displays a form to create a new Autori entity.
     *
     * @Route("/new", name="autori_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $autori = new Autori();
        $form   = $this->createForm('AppBundle\Form\AutoriType', $autori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($autori);
            $em->flush();
            
            $editLink = $this->generateUrl('autori_edit', array('id' => $autori->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New autori was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'autori' : 'autori_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('autori/new.html.twig', array(
            'autori' => $autori,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Autori entity.
     *
     * @Route("/{id}", name="autori_show")
     * @Method("GET")
     */
    public function showAction(Autori $autori)
    {
        $deleteForm = $this->createDeleteForm($autori);
        return $this->render('autori/show.html.twig', array(
            'autori' => $autori,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Autori entity.
     *
     * @Route("/{id}/edit", name="autori_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Autori $autori)
    {
        $deleteForm = $this->createDeleteForm($autori);
        $editForm = $this->createForm('AppBundle\Form\AutoriType', $autori);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($autori);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('autori_edit', array('id' => $autori->getId()));
        }
        return $this->render('autori/edit.html.twig', array(
            'autori' => $autori,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Autori entity.
     *
     * @Route("/{id}", name="autori_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Autori $autori)
    {
    
        $form = $this->createDeleteForm($autori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($autori);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Autori was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Autori');
        }
        
        return $this->redirectToRoute('autori');
    }
    
    /**
     * Creates a form to delete a Autori entity.
     *
     * @param Autori $autori The Autori entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Autori $autori)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('autori_delete', array('id' => $autori->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Autori by id
     *
     * @Route("/delete/{id}", name="autori_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Autori $autori){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($autori);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Autori was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Autori');
        }

        return $this->redirect($this->generateUrl('autori'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="autori_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Autori');

                foreach ($ids as $id) {
                    $autori = $repository->find($id);
                    $em->remove($autori);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'autoris was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the autoris ');
            }
        }

        return $this->redirect($this->generateUrl('autori'));
    }
    

}
