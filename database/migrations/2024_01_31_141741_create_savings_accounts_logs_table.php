<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsAccountsLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Make enums work pre laravel 10
		Schema::getConnection()->getDoctrineConnection()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");

		$indexes = $this->collectIndexedColumns();
		$columns = Schema::getColumnListing("savings_accounts_logs");

		$func = Schema::hasTable("savings_accounts_logs") ? "table" : "create";

		Schema::$func("savings_accounts_logs", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("account_id", $columns) && $table->integer("account_id");
			!in_array("character_id", $columns) && $table->integer("character_id");
			!in_array("action", $columns) && $table->string("action", 255)->nullable();
			!in_array("amount", $columns) && $table->integer("amount")->nullable();
			!in_array("timestamp", $columns) && $table->integer("timestamp")->nullable();
			!in_array("reason", $columns) && $table->string("reason", 255)->nullable();

			!in_array("id", $indexes) && $table->index("id");
			!in_array("account_id", $indexes) && $table->index("account_id");
			!in_array("character_id", $indexes) && $table->index("character_id");
			!in_array("timestamp", $indexes) && $table->index("timestamp");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("savings_accounts_logs");
	}

	/**
	 * Collect all columns that are indexed in the savings_accounts_logs table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("savings_accounts_logs")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("savings_accounts_logs");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}