<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
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
		$columns = Schema::getColumnListing("tokens");

		$func = Schema::hasTable("tokens") ? "table" : "create";

		Schema::$func("tokens", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("token_id", $columns) && $table->integer("token_id")->autoIncrement();
			!in_array("token", $columns) && $table->string("token", 20)->nullable();
			!in_array("access_level", $columns) && $table->integer("access_level")->nullable()->default("0");
			!in_array("note", $columns) && $table->string("note", 255)->nullable();

			!in_array("token", $indexes) && $table->index("token");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("tokens");
	}

	/**
	 * Collect all columns that are indexed in the tokens table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("tokens")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("tokens");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}