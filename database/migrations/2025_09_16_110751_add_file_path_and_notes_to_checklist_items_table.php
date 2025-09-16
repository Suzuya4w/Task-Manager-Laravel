<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilePathAndNotesToChecklistItemsTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_items', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('completed');
            $table->text('notes')->nullable()->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('checklist_items', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'notes']);
        });
    }
}