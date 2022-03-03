<?php


namespace App\Command;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeRoleUser extends Command
{
    protected static $defaultName = 'app:change-role';
    private $repo;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->repo = $userRepository;
        $this->em = $em;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            // ...
            ->addArgument('id', InputArgument::REQUIRED, 'id of user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $id = $input->getArgument('id');

       $user = $this->repo->findOneBy(['id' => $id]);
       $user->setRoles(['ROLE_ADMIN']);
       $this->em->persist($user);
       $this->em->flush();

        $output->writeln("Vous avez bien changé le role de l'user");

        return Command::SUCCESS;
    }

}
