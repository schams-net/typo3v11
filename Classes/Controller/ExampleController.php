<?php
declare(strict_types=1);
namespace SchamsNet\Typo3v11\Controller;

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use \Psr\Http\Message\ResponseInterface;
use \SchamsNet\Typo3v11\Domain\Model\Example;
use \SchamsNet\Typo3v11\Domain\Repository\ExampleRepository;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ExampleController extends ActionController
{
    private $exampleRepository;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct(
        ExampleRepository $exampleRepository
    ) {
        $this->exampleRepository = $exampleRepository;
    }

    /**
     * List action
     *
     * @access public
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $items = $this->exampleRepository->findAll();
        $this->view->assign('items', $items);
        return $this->htmlResponse();
    }

    /**
     * Detail view action
     *
     * @access public
     * @param Example $item
     * @return ResponseInterface
     */
    public function showAction(Example $item): ResponseInterface
    {
        $this->view->assign('item', $item);
        return $this->htmlResponse();
    }
}
