<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCommentToReplyCommentOnInquiryRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiry_replies', function (Blueprint $table) {
            $table->renameColumn('comment', 'reply_comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiry_replies', function (Blueprint $table) {
            $table->renameColumn('reply_comment', 'comment');
        });
    }
}
