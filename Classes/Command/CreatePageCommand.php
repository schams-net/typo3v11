<?php
declare(strict_types=1);
namespace SchamsNet\Typo3v11\Command;

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

class CreatePageCommand extends Command
{
    // ...
    private $siteRoot;
    private $parentPageUid;

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure(): void
    {
        $this->setHelp('Creates a single page.');

        $this->addArgument(
            'pageName',
            InputArgument::REQUIRED,
            'Page name'
        );

        $this->addOption(
            'site-root',
            'r',
            InputOption::VALUE_NONE,
            'Set the new page as a site root.'
        );
        $this->addOption(
            'pid',
            'p',
            InputOption::VALUE_OPTIONAL,
            'Create the new page as a subpage of an existing page.'
        );
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Initialize backend user
        Bootstrap::initializeBackendAuthentication();

        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        // ...
        $this->pageName = $input->getArgument('pageName');
        $this->siteRoot = $input->getOption('site-root') ? intval($input->getOption('site-root')) : null;
        $this->parentPageUid = $input->getOption('pid') ? intval($input->getOption('pid')) : null;

        $foobar = $this->createPage();

        // ...
        $io->writeln('Ok');
        return Command::SUCCESS;
    }

    /**
     * Create a single page
     *
     * @return void
     */
    protected function createPage(): void
    {
        $newIdOfEntryPage = StringUtility::getUniqueId('NEW');
        $parentPageUid = $this->parentPageUid ?: 0 - $this->getUidOfLastTopLevelPage();
        $data = [
            'pages' => [
                $newIdOfEntryPage => [
                    'title' => $this->pageName,
                    'pid' => $parentPageUid,
                    'hidden' => 0
                ]
            ]
        ];

        // ...
        if ($this->siteRoot) {
            $data['pages'][$newIdOfEntryPage]['is_siteroot'] = 1;
        }

        // ...
        $this->executeDataHandler($data);
    }

    /**
     * Execute DataHandler
     *
     * @return void
     */
    protected function executeDataHandler(array $data = [], array $commands = []): void
    {
        if (!empty($data) || !empty($commands)) {
            $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
            $dataHandler->enableLogging = false;
            $dataHandler->bypassAccessCheckForRecords = true;
            $dataHandler->bypassWorkspaceRestrictions = true;
            $dataHandler->start($data, $commands);
            $dataHandler->clear_cacheCmd('all');

            empty($data) ?: $dataHandler->process_datamap();
            empty($commands) ?:$dataHandler->process_cmdmap();

            // Update signal only if not running in cli mode
            if (!Environment::isCli()) {
                BackendUtility::setUpdateSignal('updatePageTree');
            }
        }
    }

    /**
     * Returns the uid of the last "top level" page (has pid 0)
     * in the page tree. This is either a positive integer or 0
     * if no page exists in the page tree at all.
     *
     * @return int
     */
    protected function getUidOfLastTopLevelPage(): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $lastPage = $queryBuilder->select('uid')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)))
            ->orderBy('sorting', 'DESC')
            ->execute()
            ->fetchOne();
        $uid = 0;
        if (MathUtility::canBeInterpretedAsInteger($lastPage) && $lastPage > 0) {
            $uid = (int)$lastPage;
        }
        return $uid;
    }
}
