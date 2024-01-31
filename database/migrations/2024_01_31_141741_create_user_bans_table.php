<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBansTable extends Migration
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
		$columns = Schema::getColumnListing("user_bans");

		$func = Schema::hasTable("user_bans") ? "table" : "create";

		Schema::$func("user_bans", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("id", $columns) && $table->integer("id")->autoIncrement();
			!in_array("ban_hash", $columns) && $table->string("ban_hash", 50)->nullable();
			!in_array("identifier", $columns) && $table->string("identifier", 50)->nullable();
			!in_array("smurf_account", $columns) && $table->string("smurf_account", 50)->nullable();
			!in_array("creator_name", $columns) && $table->longText("creator_name")->nullable();
			!in_array("reason", $columns) && $table->longText("reason")->nullable();
			!in_array("timestamp", $columns) && $table->integer("timestamp")->nullable();
			!in_array("expire", $columns) && $table->integer("expire")->nullable();
			!in_array("creator_identifier", $columns) && $table->string("creator_identifier", 255)->default("");
			!in_array("locked", $columns) && $table->tinyInteger("locked")->default("0");
			!in_array("smurf_reason", $columns) && $table->string("smurf_reason", 255)->nullable();
			!in_array("scheduled_unban", $columns) && $table->integer("scheduled_unban")->nullable();

			!in_array("identifier", $indexes) && $table->index("identifier");
			!in_array("expire", $indexes) && $table->index("expire");
			!in_array("timestamp", $indexes) && $table->index("timestamp");
			!in_array("ban_hash", $indexes) && $table->index("ban_hash");
			!in_array("smurf_account", $indexes) && $table->index("smurf_account");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("user_bans");
	}

	/**
	 * Collect all columns that are indexed in the user_bans table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("user_bans")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("user_bans");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}