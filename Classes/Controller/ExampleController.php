<?php
declare(strict_types=1);
namespace SchamsNet\Typo3v11\Controller;

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

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
