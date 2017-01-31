<?php

namespace Icarus\QueueMailer\Console\Commands;


use Icarus\QueueMailer\Model\Email;
use Icarus\QueueMailer\Model\EmailQuery;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Mail\IMailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\Debugger;


class QueueMailerCommand extends Command
{

    /** @var EntityRepository */
    private $repository;

    /** @var IMailer */
    private $mailer;

    /**
     * @var EntityManager
     */
    private $entityManager;



    /**
     * MailerCommand constructor.
     * @param EntityManager $entityManager
     * @param IMailer $mailer
     */
    public function __construct(EntityManager $entityManager, IMailer $mailer)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Email::class);
        $this->mailer = $mailer;
    }



    protected function configure()
    {
        $this->setName('cron:mailer');
        $this->setDescription('Mail sender');
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = (new EmailQuery())->notSent();
        $emails = $this->repository->fetch($query);
        $emails->applyPaging(0, 50);

        foreach ($emails->getIterator() as $email) {
            /** @var Email $email */

            $message = $email->getMessage();
            try {
                $this->mailer->send($message);
                $email->setSentToNow();
                $this->entityManager->persist($email);
            } catch (\Exception $e) {
                Debugger::log($e, Debugger::ERROR);
                $output->writeln('An error occurred during sending an email');
            }
        }
        $this->entityManager->flush();
    }
}
