<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFireEventsTable extends Migration
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

		$tableExists = Schema::hasTable("fire_events");

		$indexes = $tableExists ? $this->getIndexedColumns() : [];
		$columns = $tableExists ? $this->getColumns() : [];

		$func = $tableExists ? "table" : "create";

		Schema::$func("fire_events", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("license_identifier", $columns) && $table->string("license_identifier", 50)->nullable();
			!in_array("timestamp", $columns) && $table->bigInteger("timestamp")->nullable();
			!in_array("index", $columns) && $table->integer("index")->nullable();
			!in_array("fire_type", $columns) && $table->integer("fire_type")->nullable();
			!in_array("is_entity", $columns) && $table->tinyInteger("is_entity")->nullable();
			!in_array("entity_global_id", $columns) && $table->integer("entity_global_id")->nullable();
			!in_array("parent_position_x", $columns) && $table->double("parent_position_x")->nullable();
			!in_array("parent_position_y", $columns) && $table->double("parent_position_y")->nullable();
			!in_array("parent_position_z", $columns) && $table->double("parent_position_z")->nullable();
			!in_array("fire_position_x", $columns) && $table->double("fire_position_x")->nullable();
			!in_array("fire_position_y", $columns) && $table->double("fire_position_y")->nullable();
			!in_array("fire_position_z", $columns) && $table->double("fire_position_z")->nullable();
			!in_array("owner_id", $columns) && $table->integer("owner_id")->nullable();
			!in_array("is_scripted", $columns) && $table->tinyInteger("is_scripted")->nullable();
			!in_array("max_generations", $columns) && $table->integer("max_generations")->nullable();
			!in_array("burn_time", $columns) && $table->double("burn_time")->nullable();
			!in_array("burn_strength", $columns) && $table->double("burn_strength")->nullable();
			!in_array("weapon_hash", $columns) && $table->bigInteger("weapon_hash")->nullable();
			!in_array("fire_id", $columns) && $table->integer("fire_id")->nullable();

			!in_array("license_identifier", $indexes) && $table->index("license_identifier");
			!in_array("timestamp", $indexes) && $table->index("timestamp");
			!in_array("fire_type", $indexes) && $table->index("fire_type");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("fire_events");
	}

	/**
	 * Get all columns.
	 *
	 * @return array
	 */
	private function getColumns(): array
	{
		$columns = Schema::getConnection()->select("SHOW COLUMNS FROM `fire_events`");

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
		$indexes = Schema::getConnection()->select("SHOW INDEXES FROM `fire_events` WHERE Key_name != 'PRIMARY'");

		return array_map(function ($index) {
			return $index->Column_name;
		}, $indexes);
	}
}