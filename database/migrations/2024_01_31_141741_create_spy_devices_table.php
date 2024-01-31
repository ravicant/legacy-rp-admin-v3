<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpyDevicesTable extends Migration
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
		$columns = Schema::getColumnListing("spy_devices");

		$func = Schema::hasTable("spy_devices") ? "table" : "create";

		Schema::$func("spy_devices", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("device_id", $columns) && $table->integer("device_id")->autoIncrement();
			!in_array("device_type", $columns) && $table->integer("device_type")->nullable();
			!in_array("device_activation_timestamp", $columns) && $table->integer("device_activation_timestamp")->nullable();
			!in_array("entity_type", $columns) && $table->integer("entity_type")->nullable();
			!in_array("entity_identifier", $columns) && $table->integer("entity_identifier")->nullable();
			!in_array("entity_vector3", $columns) && $table->longText("entity_vector3")->nullable();

			!in_array("device_id", $indexes) && $table->index("device_id");
			!in_array("entity_type", $indexes) && $table->index("entity_type");
			!in_array("entity_identifier", $indexes) && $table->index("entity_identifier");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("spy_devices");
	}

	/**
	 * Collect all columns that are indexed in the spy_devices table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("spy_devices")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("spy_devices");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}