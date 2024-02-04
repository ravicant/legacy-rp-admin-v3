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

		$tableExists = Schema::hasTable("tokens");

		$indexes = $tableExists ? $this->getIndexedColumns() : [];
		$columns = $tableExists ? $this->getColumns() : [];

		$func = $tableExists ? "table" : "create";

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
	 * Get all columns.
	 *
	 * @return array
	 */
	private function getColumns(): array
	{
		$columns = Schema::getConnection()->select("SHOW COLUMNS FROM `tokens`");

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
		$indexes = Schema::getConnection()->select("SHOW INDEXES FROM `tokens` WHERE Key_name != 'PRIMARY'");

		return array_map(function ($index) {
			return $index->Column_name;
		}, $indexes);
	}
}