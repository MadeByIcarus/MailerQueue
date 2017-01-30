<?php

namespace Icarus\QueueMailer\Console\Commands;

use DateTime;
use Icarus\QueueMailer\Model\Email;
use Icarus\QueueMailer\Model\EmailQuery;
use Joseki\LeanMapper\Query;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Linqpays\Mail\EmailRepository;
use Nette\Mail\SmtpMailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\Debugger;

class QueueMailerCommand extends Command
{
    /** @var EntityRepository */
    private $repository;

    /** @var SmtpMailer */
    private $mailer;



    /**
     * MailerCommand constructor.
     * @param EntityManager $entityManager
     * @param SmtpMailer $mailer
     */
    public function __construct(EntityManager $entityManager, SmtpMailer $mailer)
    {
        parent::__construct();
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
                $this->repository->getEntityManager()->persist($email);
            } catch (\Exception $e) {
                Debugger::log($e, Debugger::ERROR);
                $output->writeln('An error occurred during sending an email');
            }
        }
    }
}
