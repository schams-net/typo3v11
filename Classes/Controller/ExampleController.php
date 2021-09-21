<?php
namespace SchamsNet\Typo3v11\Controller;

use \Psr\Http\Message\ResponseInterface;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ExampleController extends ActionController
{
    /**
     * List action
     *
     * @access public
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * Detail view action
     *
     * @access public
     * @return ResponseInterface
     */
    public function detailAction(): ResponseInterface
    {
        return $this->htmlResponse();
        //return $this->jsonResponse();
    }
}
