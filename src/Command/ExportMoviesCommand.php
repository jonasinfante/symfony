<?php

namespace App\Command;
use App\Entity\Genre;
use App\Repository\MovieRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

#[AsCommand(
    name: 'app:export-movies',
    description: 'Exports movies in csv',
)]
class ExportMoviesCommand extends Command
{

    public function __construct(
        private readonly MovieRepository $movieRepository,
        private readonly PropertyAccessorInterface $accessor,
        string $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Filename')
            ->addOption('separator', 's', InputArgument::OPTIONAL, 'Separator', ',')
            ->addOption('column', 'c', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'column', [])
            ->addOption('genres', 'g', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'list of genre names to include')
        ;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');
        if (is_file($file)) {
            $overwrite = $io->choice("Le fichier existe déjà, voulez vous l'écraser ?", ['yes', 'no'], 'yes') === 'yes';
            if (!$overwrite) {
                return Command::FAILURE;
            }
        }

        $includedGenres = $input->getOption('genres');
        if (empty($includedGenres)) {
            $movies = $this->movieRepository->findAll();
        } else {
            $movies = $this->movieRepository->findByGenresNames($includedGenres);
        }

        $cols = ['id', 'title', 'plot', 'releasedAt', 'genres'];
        if ($c = $input->getOption('column')) {
            $cols = array_intersect($cols, $c);
        }

        $separator = $input->getOption('separator');


        $f = fopen($file, 'w');
        fputcsv($f, $cols, $separator);
        foreach ($movies as $m) {


            $csvMovie = array_map(
                function ($c) use ($m) {
                    $value = $this->accessor->getValue($m, $c);
                    if ($value instanceof \DateTimeImmutable) {
                        return $value->format('d-m-Y');
                    }
                    if (is_iterable($value)) {
                        return implode(',', array_map(fn(Genre $g) => $g->getName(), $value->toArray()));
                    }


                    return  $value;
                },
                $cols
            );


            fputcsv($f, $csvMovie, $separator);
        }

        $io->success(sprintf('Le fichier %s a bient été écrit', $file));

        return Command::SUCCESS;
    }
}
