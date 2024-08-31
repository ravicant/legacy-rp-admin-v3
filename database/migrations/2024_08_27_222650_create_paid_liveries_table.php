<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidLiveriesTable extends Migration
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

		$tableExists = Schema::hasTable("paid_liveries");

		$indexes = $tableExists ? $this->getIndexedColumns() : [];
		$columns = $tableExists ? $this->getColumns() : [];

		$func = $tableExists ? "table" : "create";

		Schema::$func("paid_liveries", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("vehicle_id", $columns) && $table->integer("vehicle_id")->nullable();
			!in_array("paid_livery_id", $columns) && $table->string("paid_livery_id", 50)->nullable();

			!in_array("vehicle_id", $indexes) && $table->index("vehicle_id");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("paid_liveries");
	}

	/**
	 * Get all columns.
	 *
	 * @return array
	 */
	private function getColumns(): array
	{
		$columns = Schema::getConnection()->select("SHOW COLUMNS FROM `paid_liveries`");

		return array_map(function ($column) {
			return $column->Field;
		}, $columns);
	}

	/**
	 * Get all indexed columns.
	 *
	 * @return array
	 */
	private function getIndexedColumns(): array
	{
		$indexes = Schema::getConnection()->select("SHOW INDEXES FROM `paid_liveries` WHERE Key_name != 'PRIMARY'");

		return array_map(function ($index) {
			return $index->Column_name;
		}, $indexes);
	}
}