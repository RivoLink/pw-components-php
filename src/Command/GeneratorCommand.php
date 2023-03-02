<?php

namespace Pw\Command;

use Pw\Generator\MethodGenerator;
use Pw\Generator\WebpackGenerator;
use Pw\Generator\ControllerGenerator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: "pw-generator:generate", description: "PW generator command")]
class GeneratorCommand extends Command {

    public function __construct(){
        parent::__construct();
    }

    // symfony console pw-generator:generate
    protected function execute(InputInterface $input, OutputInterface $output): int {

        $path = ControllerGenerator::createController("FrontController");
        MethodGenerator::insertPageMethod($path, [
            "route_url" => "/protection-des-donnees",
            "route_name" => "protection_des_donnees",
            "name" => "protectionDesDonnees",
            "twig" => "/protection_des_donnees.html.twig",
        ]);

        $path = ControllerGenerator::createController("src/Controller/Api/FrontApiController");
        MethodGenerator::insertApiMethod($path, [
            "route_url" => "/api/connexion",
            "route_name" => "api_connexion",
            "name" => "apiConnexion",
        ]);

        WebpackGenerator::createConfig("front");
        WebpackGenerator::createConfig("admin");

        return Command::SUCCESS;
    }
}
