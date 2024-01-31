<?php

namespace App\Console\Commands;

use Dotenv\Dotenv;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QueryRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a query on all clusters.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = trim($this->ask("SQL Query"));

        if (empty($query)) {
            $this->error("Query is empty");

            return;
        }

        $this->info("Iterating through all clusters...");

        $dir = base_path("envs");

        $clusters = array_diff(scandir($dir), [".", "..", "auth"]);

        chdir(base_path());

        foreach ($clusters as $cluster) {
            $cluster = trim($cluster);

            $path = $dir . "/" . $cluster;

            if (empty($cluster) || !is_dir($path)) {
                continue;
            }

            $this->info("Running query on cluster `" . $cluster . "`...");

            $result = $this->runQuery($cluster, $query);

            if (!$result[0]) {
                $this->error(" - " . $result[1]);
            } else {
                $this->comment(" - " . $result[1]);
            }
        }

        return 0;
    }

    private function runQuery(string $cluster, string $query)
    {
        $dir = base_path("envs/" . $cluster);
        $env = $dir . "/.env";

        if (empty($env) || !file_exists($env)) {
            return [false, "Failed to read .env file"];
        }

        $contents = file_get_contents($env);

        $dotenv  = Dotenv::createImmutable($dir, ".env");
        $envData = $dotenv->parse($contents);

        $dbName = "cluster_" . $cluster;

        Config::set("database.connections." . $dbName, [
            "driver"   => $envData["DB_CONNECTION"],
            "host"     => $envData["DB_HOST"],
            "port"     => $envData["DB_PORT"],
            "database" => $envData["DB_DATABASE"],
            "username" => $envData["DB_USERNAME"],
            "password" => $envData["DB_PASSWORD"],
        ]);

        try {
            /**
             * @var \Illuminate\Database\Connection
             */
            $conn = DB::connection($dbName);

            $conn->getPdo();
        } catch (\Exception $e) {
            return [false, "Failed to connect to database: " . $e->getMessage()];
        }

        $affected = 0;

        if (Str::startsWith($query, "SELECT")) {
            $affected = DB::connection($dbName)->select($query);

            $affected = count($affected);
        } else if (Str::startsWith($query, "UPDATE")) {
            $affected = DB::connection($dbName)->update($query);
        } else if (Str::startsWith($query, "INSERT")) {
            $affected = DB::connection($dbName)->insert($query);
        } else if (Str::startsWith($query, "DELETE")) {
            $affected = DB::connection($dbName)->delete($query);
        } else {
            return [false, "Unknown query type"];
        }

        return [true, "Affected " . $affected . " rows"];
    }
}
