<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
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
		$columns = Schema::getColumnListing("inventories");

		$func = Schema::hasTable("inventories") ? "table" : "create";

		Schema::$func("inventories", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("item_name", $columns) && $table->string("item_name", 50)->nullable();
			!in_array("item_metadata", $columns) && $table->longText("item_metadata")->nullable();
			!in_array("inventory_name", $columns) && $table->string("inventory_name", 50)->nullable();
			!in_array("inventory_slot", $columns) && $table->integer("inventory_slot")->nullable();

			!in_array("inventory_name", $indexes) && $table->index("inventory_name");
			!in_array("item_name", $indexes) && $table->index("item_name");
			!in_array("id", $indexes) && $table->index("id");
			!in_array("item_metadata", $indexes) && $table->index("item_metadata");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("inventories");
	}

	/**
	 * Collect all columns that are indexed in the inventories table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("inventories")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("inventories");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}