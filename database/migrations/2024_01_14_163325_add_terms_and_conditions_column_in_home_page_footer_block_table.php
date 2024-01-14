<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_page_footer_block', function (Blueprint $table) {
            $table->string('terms_and_condition')
                ->nullable()
                ->after('privacy_policy_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_footer_block', function (Blueprint $table) {
            $table->dropColumn('terms_and_condition');
        });
    }
};
