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

		$tableExists = Schema::hasTable("stocks_companies");

		$indexes = $tableExists ? $this->getIndexedColumns() : [];
		$columns = $tableExists ? $this->getColumns() : [];

		$func = $tableExists ? "table" : "create";

		Schema::$func("stocks_companies", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("company_id", $columns) && $table->integer("company_id")->autoIncrement();
			!in_array("owner_cid", $columns) && $table->integer("owner_cid")->nullable();
			!in_array("owner_name", $columns) && $table->longText("owner_name")->nullable();
			!in_array("company_name", $columns) && $table->longText("company_name")->nullable();
			!in_array("company_description", $columns) && $table->longText("company_description")->nullable();
			!in_array("company_logo", $columns) && $table->longText("company_logo")->nullable();
			!in_array("company_balance", $columns) && $table->double("company_balance")->nullable()->default("0");
			!in_array("company_reg_timestamp", $columns) && $table->timestamp("company_reg_timestamp")->useCurrent();
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
	 * Get all columns.
	 *
	 * @return array
	 */
	private function getColumns(): array
	{
		$columns = Schema::getConnection()->select("SHOW COLUMNS FROM `stocks_companies`");

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
		$indexes = Schema::getConnection()->select("SHOW INDEXES FROM `stocks_companies` WHERE Key_name != 'PRIMARY'");

		return array_map(function ($index) {
			return $index->Column_name;
		}, $indexes);
	}
}