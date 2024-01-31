<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiCheatEventsTable extends Migration
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
		$columns = Schema::getColumnListing("anti_cheat_events");

		$func = Schema::hasTable("anti_cheat_events") ? "table" : "create";

		Schema::$func("anti_cheat_events", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("license_identifier", $columns) && $table->string("license_identifier", 50)->nullable();
			!in_array("character_id", $columns) && $table->integer("character_id")->nullable();
			!in_array("type", $columns) && $table->string("type", 50)->nullable();
			!in_array("metadata", $columns) && $table->longText("metadata")->nullable();
			!in_array("timestamp", $columns) && $table->integer("timestamp")->nullable();
			!in_array("screenshot_url", $columns) && $table->string("screenshot_url", 500)->nullable();

			!in_array("license_identifier", $indexes) && $table->index("license_identifier");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("anti_cheat_events");
	}

	/**
	 * Collect all columns that are indexed in the anti_cheat_events table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("anti_cheat_events")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("anti_cheat_events");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}