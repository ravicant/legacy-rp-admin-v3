<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksCompaniesTable extends Migration
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
		$columns = Schema::getColumnListing("stocks_companies");

		$func = Schema::hasTable("stocks_companies") ? "table" : "create";

		Schema::$func("stocks_companies", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("company_id", $columns) && $table->integer("company_id")->autoIncrement();
			!in_array("owner_cid", $columns) && $table->integer("owner_cid")->nullable();
			!in_array("owner_name", $columns) && $table->longText("owner_name")->nullable();
			!in_array("company_name", $columns) && $table->longText("company_name")->nullable();
			!in_array("company_description", $columns) && $table->longText("company_description")->nullable();
			!in_array("company_logo", $columns) && $table->longText("company_logo")->nullable();
			!in_array("company_balance", $columns) && $table->double("company_balance")->nullable()->default("0");
			!in_array("company_reg_timestamp", $columns) && $table->timestamp("company_reg_timestamp")->default("current_timestamp()");
			!in_array("total_shares", $columns) && $table->integer("total_shares")->nullable()->default("0");
			!in_array("total_shares_purchased", $columns) && $table->integer("total_shares_purchased")->nullable()->default("0");
			!in_array("max_shares", $columns) && $table->integer("max_shares")->nullable()->default("1000000");
			!in_array("share_price", $columns) && $table->double("share_price")->nullable()->default("0.01");
			!in_array("share_change", $columns) && $table->double("share_change")->nullable()->default("0");
			!in_array("bankrupt", $columns) && $table->integer("bankrupt")->nullable();

			!in_array("company_id", $indexes) && $table->index("company_id");
			!in_array("owner_cid", $indexes) && $table->index("owner_cid");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("stocks_companies");
	}

	/**
	 * Collect all columns that are indexed in the stocks_companies table.
	 *
	 * @return array
	 */
	private function collectIndexedColumns(): array
	{
		if (!Schema::hasTable("stocks_companies")) {
			return [];
		}

		$sm  = Schema::getConnection()->getDoctrineSchemaManager();
		$tbl = $sm->introspectTable("stocks_companies");

		$indexes = array_reduce($tbl->getIndexes(), function ($carry, $index) {
			return array_merge($carry, $index->getColumns());
		}, []);

		return array_values(array_unique($indexes));
	}
}