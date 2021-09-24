<?php
declare(strict_types=1);
namespace SchamsNet\Typo3v11\Command;

/**
 * TYPO3 v11 Test Extension
 * @author Michael Schams | https://schams.net
 */

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

class CreateDemoPageTreeCommand extends Command
{
    private $subPages = [
        'Page A',
        'Page B',
        'Page C',
        'Page D'
    ];

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setHelp('Creates some demo pages.' . LF . 'If you want to get more detailed information, use the --verbose option.');
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

        if ($this->demoPagesExist()) {
            // ...
            $io->writeln('Demo pages already exist.');
            return Command::FAILURE;
        }

        // ...
        $this->createPageTree();

        // ...
        $io->writeln('Ok');
        return Command::SUCCESS;
    }

    /**
     * Check if demo pages already exist
     *
     * @return bool
     */
    protected function demoPagesExist(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();

        $rows = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('tx_typo3v11_demopage', $queryBuilder->createNamedParameter('true', \PDO::PARAM_STR))
            )
            ->execute()
            ->fetchAll();

        // ...
        return count($rows) === 0 ? false : true;
    }

    /**
     * Create page tree
     *
     * @return void
     */
    protected function createPageTree(): void
    {
        $newIdOfEntryPage = StringUtility::getUniqueId('NEW');
        $data = [
            'pages' => [
                $newIdOfEntryPage => [
                    'title' => 'Demo page tree',
                    'pid' => 0 - $this->getUidOfLastTopLevelPage(),
                    'is_siteroot' => 1,
                    'tx_typo3v11_demopage' => 'true',
                    'hidden' => 0
                ]
            ]
        ];

        $sorting = 0;
        $parentPage = $newIdOfEntryPage;
        $subPages = array_reverse($this->subPages);
        foreach ($subPages as $subPage) {
            $newIdOfPage = StringUtility::getUniqueId('NEW');
            $data['pages'][$newIdOfPage] = [
                'title' => $subPage,
                'pid' => $parentPage,
                'tx_typo3v11_demopage' => 'true',
                'sorting' => $sorting++,
                'hidden' => 0
            ];
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
