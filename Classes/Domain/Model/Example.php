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
     */
    protected string $title = '';

    /**
     * Creation timestamp
     */
    protected \DateTime $crdate;

    /**
     * Returns the title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the title in upper-case
     */
    public function getUpperCaseTitle(): string
    {
        return strtoupper($this->title);
    }

    /**
     * Sets the title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the creation timestamp
     */
    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }
}
