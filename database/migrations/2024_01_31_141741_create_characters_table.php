<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
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
		$columns = Schema::getColumnListing("characters");

		$func = Schema::hasTable("characters") ? "table" : "create";

		Schema::$func("characters", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("character_id", $columns) && $table->integer("character_id")->autoIncrement();
			!in_array("license_identifier", $columns) && $table->string("license_identifier", 50)->nullable();
			!in_array("character_slot", $columns) && $table->integer("character_slot")->nullable();
			!in_array("character_created", $columns) && $table->integer("character_created")->nullable()->default("0");
			!in_array("character_deleted", $columns) && $table->integer("character_deleted")->nullable()->default("0");
			!in_array("first_name", $columns) && $table->longText("first_name")->nullable();
			!in_array("last_name", $columns) && $table->longText("last_name")->nullable();
			!in_array("date_of_birth", $columns) && $table->longText("date_of_birth")->nullable();
			!in_array("gender", $columns) && $table->integer("gender")->nullable();
			!in_array("backstory", $columns) && $table->longText("backstory")->nullable();
			!in_array("cash", $columns) && $table->integer("cash")->nullable()->default("0");
			!in_array("bank", $columns) && $table->integer("bank")->nullable()->default("0");
			!in_array("blood_type", $columns) && $table->integer("blood_type")->nullable();
			!in_array("coords", $columns) && $table->longText("coords")->nullable();
			!in_array("status_data", $columns) && $table->longText("status_data")->nullable();
			!in_array("job_name", $columns) && $table->longText("job_name")->nullable();
			!in_array("department_name", $columns) && $table->longText("department_name")->nullable();
			!in_array("position_name", $columns) && $table->longText("position_name")->nullable();
			!in_array("ammo_data", $columns) && $table->longText("ammo_data")->nullable();
			!in_array("tattoos_data", $columns) && $table->longText("tattoos_data")->nullable();
			!in_array("phone_number", $columns) && $table->longText("phone_number")->nullable();
			!in_array("is_dead", $columns) && $table->tinyInteger("is_dead")->nullable();
			!in_array("model", $columns) && $table->longText("model")->nullable();
			!in_array("stocks_balance", $columns) && $table->double("stocks_balance")->nullable()->default("0");
			!in_array("jail", $columns) && $table->integer("jail")->nullable();
			!in_array("character_creation_timestamp", $columns) && $table->integer("character_creation_timestamp")->nullable();
			!in_array("character_deletion_timestamp", $columns) && $table->integer("character_deletion_timestamp")->nullable();
			!in_array("character_data", $columns) && $table->longText("character_data")->nullable();
			!in_array("is_hardcore_dead", $columns) && $table->tinyInteger("is_hardcore_dead")->nullable()->default("0");
			!in_array("on_duty_time", $columns) && $table->longText("on_duty_time")->nullable();
			!in_array("gcphone_config", $columns) && $table->longText("gcphone_config")->nullable();
			!in_array("ped_model_hash", $columns) && $table->integer("ped_model_hash")->nullable();
			!in_array("ped_model_data", $columns) && $table->longText("ped_model_data")->nullable();
			!in_array("has_ever_been_loaded", $columns) && $table->tinyInteger("has_ever_been_loaded")->nullable()->default("0");
			!in_array("apartment", $columns) && $table->longText("apartment")->nullable();
			!in_array("playtime", $columns) && $table->integer("playtime")->nullable()->default("0");
			!in_array("email_address", $columns) && $table->longText("email_address")->nullable();
			!in_array("email_password", $columns) && $table->longText("email_password")->nullable();
			!in_array("mugshot_url", $columns) && $table->longText("mugshot_url")->nullable();
			!in_array("weekly_playtime", $columns) && $table->longText("weekly_playtime")->nullable();
			!in_array("character_creation_time", $columns) && $table->integer("character_creation_time")->nullable();
			!in_array("last_loaded", $columns) && $table->integer("last_loaded")->nullable();
			!in_array("is_one_life", $columns) && $table->tinyInteger("is_one_life")->nullable()->default("0");

			!in_array("license_identifier", $indexes) && $table->index("license_identifier");
			!in_array("character_created", $indexes) && $table->index("character_created");
			!in_array("character_id", $indexes) && $table->index("character_id");
			!in_array("character_deleted", $indexes) && $table->index("character_deleted");
			!in_array("character_slot", $indexes) && $table->index("character_slot");
			!in_array("first_name", $indexes) && $table->index("first_name");
			!in_array("last_name", $indexes) && $table->index("last_name");
			!in_array("email_address", $indexes) && $table->index("email_address");
			!in_array("last_loaded", $indexes) && $table->index("last_loaded");
			!in_array("ped_model_hash", $indexes) && $table->index("ped_model_hash");
			!in_array("playtime", $indexes) && $table->index("playtime");
			!in_array("phone_number", $indexes) && $table->index("phone_number");
			!in_array("character_data", $indexes) && $table->index("character_data");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("characters");
	}

	/**
	 * Collect all columns that are indexed in the characters table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("characters")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("characters");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}