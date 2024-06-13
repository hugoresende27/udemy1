<?php


namespace App\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[AsCommand(name : "app:weather", description : "Lists the weather of the given latitude and longitude")]
class WeatherCommand extends Command
{
    private $apiKey;
    public function __construct(ParameterBagInterface $params, private readonly HttpClientInterface $httpClient, string $name = null)
    {
        $this->apiKey = $params->get('app.weather_api_key');
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('lat', InputArgument::REQUIRED,'Latitude value (can be negative).')
             ->addArgument('lng', InputArgument::REQUIRED, 'Longitude value (can be negative).')
             ->addOption(
                'days',
                'd',
                InputOption::VALUE_OPTIONAL,
                7
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // dd('Weather API Key: ' . $this->apiKey);
        //getting inputs
        $latitude = (float)$input->getArgument('lat'); 
        $longitude = (float)$input->getArgument('lng'); 
        $days = (int)$input->getOption('days'); 
        $output->writeln(sprintf( 'getting forcast for (%s,%s) the next %s days', $latitude, $longitude, $days));

        //ask mesure unit
        $helper = $this->getHelper('question');
        $question = new Question("Fahrenheit or Celsius ? \n");
        $question->setAutocompleterValues(['fahrenheit', 'celsius']);
        $temperatureUnit = $helper->ask($input, $output, $question);
        $output->writeln('Mesure unit is '. $temperatureUnit);

        //progress bar
        $progressBar = new ProgressBar($output);
        $progressBar->start();
        sleep(1);
        $progressBar->setProgress(50);

        //fetching data
        //https://api.open-meteo.com/v1/forecast?latitude=40.197139&longitude=-8.830361&daily=temperature_2m_max%2Ctemperature_2m_min&forecast_days=5&temperature_unit=celsius
        $response = $this->httpClient->request('GET', 
            'https://api.open-meteo.com/v1/forecast',
            [ 'query' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'daily' => 'temperature_2m_max,temperature_2m_min',
                'forecast_days' => $days,
                'temperature_unit' => $temperatureUnit
            ]])
            ->toArray();
           
        $output->writeln(print_r($response), true);

        //stopping progress bar
        $progressBar->setProgress(100);
        $progressBar->finish();
        $output->writeln('');

        //display data
        $table = new Table($output);
        $table->setHeaders(['Day', 'Temperature Unit', 'Temperature Max']);
        $rows = [];
        foreach($response['daily']['time'] as $key => $date) {
            $rows[] = [
                $date,
                $response['daily']['temperature_2m_min'][$key],
                $response['daily']['temperature_2m_max'][$key],
            ];
        }
        $table->setRows($rows);
        $table->render();


        return Command::SUCCESS;
    }

}