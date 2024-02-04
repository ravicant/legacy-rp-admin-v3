<?php
// Auto generated by the build:migrations command

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailMailsTable extends Migration
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

		$tableExists = Schema::hasTable("email_mails");

		$indexes = $tableExists ? $this->getIndexedColumns() : [];
		$columns = $tableExists ? $this->getColumns() : [];

		$func = $tableExists ? "table" : "create";

		Schema::$func("email_mails", function (Blueprint $table) use ($columns, $indexes) {
			!in_array("mail_id", $columns) && $table->integer("mail_id")->autoIncrement();
			!in_array("sender_cid", $columns) && $table->integer("sender_cid")->nullable();
			!in_array("receiver_cid", $columns) && $table->integer("receiver_cid")->nullable();
			!in_array("sender_email", $columns) && $table->longText("sender_email")->nullable();
			!in_array("receiver_email", $columns) && $table->longText("receiver_email")->nullable();
			!in_array("subject", $columns) && $table->longText("subject")->nullable();
			!in_array("body", $columns) && $table->longText("body")->nullable();
			!in_array("sent_at", $columns) && $table->integer("sent_at")->nullable()->default("0");
			!in_array("read_at", $columns) && $table->integer("read_at")->nullable()->default("0");
			!in_array("archived", $columns) && $table->tinyInteger("archived")->nullable()->default("0");

			!in_array("sender_cid", $indexes) && $table->index("sender_cid");
			!in_array("receiver_cid", $indexes) && $table->index("receiver_cid");
			!in_array("sent_at", $indexes) && $table->index("sent_at");
			!in_array("mail_id", $indexes) && $table->index("mail_id");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("email_mails");
	}

	/**
	 * Get all columns.
	 *
	 * @return array
	 */
	private function getColumns(): array
	{
		$columns = Schema::getConnection()->select("SHOW COLUMNS FROM `email_mails`");

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
		$indexes = Schema::getConnection()->select("SHOW INDEXES FROM `email_mails` WHERE Key_name != 'PRIMARY'");

		return array_map(function ($index) {
			return $index->Column_name;
		}, $indexes);
	}
}