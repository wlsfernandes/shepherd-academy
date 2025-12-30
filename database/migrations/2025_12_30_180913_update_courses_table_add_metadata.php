<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            // 🔗 Public identity
            $table->string('slug')->unique()->after('title');
            $table->string('summary', 500)->nullable()->after('slug');

            // 🖼️ Optional featured image
            $table->string('image_url')->nullable()->after('summary');

            // 💰 Pricing (simple, per-course)
            $table->decimal('price', 8, 2)->nullable()->after('image_url');
            $table->boolean('allow_installments')->default(false)->after('price');
            $table->integer('installment_count')->nullable()->after('allow_installments');

            // 🗓️ Course timeline
            $table->date('start_date')->nullable()->after('allow_installments');
            $table->date('end_date')->nullable()->after('start_date');

            // 🌍 Public visibility
            $table->boolean('is_published')->default(false)->after('end_date');
            $table->date('publish_start_at')->nullable()->after('is_published');
            $table->date('publish_end_at')->nullable()->after('publish_start_at');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'summary',
                'image_url',
                'price',
                'allow_installments',
                'start_date',
                'end_date',
                'is_published',
                'publish_start_at',
                'publish_end_at',
            ]);
        });
    }
};
