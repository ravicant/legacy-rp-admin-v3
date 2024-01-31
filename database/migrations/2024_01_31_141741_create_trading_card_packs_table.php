<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingCardPacksTable extends Migration
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
		$columns = Schema::getColumnListing("trading_card_packs");

		$func = Schema::hasTable("trading_card_packs") ? "table" : "create";

		Schema::$func("trading_card_packs", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("pack_id", $columns) && $table->integer("pack_id")->autoIncrement();
			!in_array("title", $columns) && $table->longText("title")->nullable();
			!in_array("pack_icon_url", $columns) && $table->longText("pack_icon_url")->nullable();
			!in_array("card_icon_url", $columns) && $table->longText("card_icon_url")->nullable();
			!in_array("price", $columns) && $table->integer("price")->nullable()->default("1250");
			!in_array("drop_amount", $columns) && $table->integer("drop_amount")->nullable()->default("3");
			!in_array("parent_pack_id", $columns) && $table->integer("parent_pack_id")->nullable();
			!in_array("disabled", $columns) && $table->tinyInteger("disabled")->nullable()->default("0");
			!in_array("additional_drops", $columns) && $table->longText("additional_drops")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("trading_card_packs");
	}

	/**
	 * Collect all columns that are indexed in the trading_card_packs table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("trading_card_packs")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("trading_card_packs");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}