<?php
declare(strict_types=1);
namespace SchamsNet\Typo3v11\Domain\Model;

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Example extends AbstractEntity
{
    /**
     * Title
     *
     * @var string
     */
    protected $title = '';

    /**
     * Creation timestamp
     *
     * @var \DateTime
     */
    protected $crdate;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the creation timestamp
     *
     * @return \DateTime
     */
    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }
}
