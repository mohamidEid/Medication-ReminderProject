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
        Schema::table('medicines', function (Blueprint $table) {
            // Inventory management
            $table->decimal('current_quantity', 10, 2)->nullable()->after('notes');
            $table->string('quantity_unit', 50)->default('pills')->after('current_quantity');
            $table->decimal('min_quantity_alert', 10, 2)->nullable()->after('quantity_unit');
            $table->boolean('low_stock_alert_sent')->default(false)->after('min_quantity_alert');

            // Smart scheduling
            $table->time('suggested_time')->nullable()->after('low_stock_alert_sent');
            $table->boolean('is_suggestion_accepted')->default(false)->after('suggested_time');
            $table->timestamp('last_suggestion_at')->nullable()->after('is_suggestion_accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'current_quantity',
                'quantity_unit',
                'min_quantity_alert',
                'low_stock_alert_sent',
                'suggested_time',
                'is_suggestion_accepted',
                'last_suggestion_at',
            ]);
        });
    }
};
