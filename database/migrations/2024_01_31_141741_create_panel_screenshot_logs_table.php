<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelScreenshotLogsTable extends Migration
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
		$columns = Schema::getColumnListing("panel_screenshot_logs");

		$func = Schema::hasTable("panel_screenshot_logs") ? "table" : "create";

		Schema::$func("panel_screenshot_logs", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("source_license", $columns) && $table->string("source_license", 50)->nullable();
			!in_array("target_license", $columns) && $table->string("target_license", 50)->nullable();
			!in_array("target_character", $columns) && $table->integer("target_character")->nullable();
			!in_array("type", $columns) && $table->string("type", 50)->nullable();
			!in_array("url", $columns) && $table->longText("url")->nullable();
			!in_array("timestamp", $columns) && $table->integer("timestamp")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("panel_screenshot_logs");
	}

	/**
	 * Collect all columns that are indexed in the panel_screenshot_logs table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("panel_screenshot_logs")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("panel_screenshot_logs");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}