<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) { $t->string('avatar')->nullable()->after('is_admin'); });

        Schema::create('social_links', function (Blueprint $t) {
            $t->id(); $t->string('platform', 30); $t->string('label')->nullable(); $t->string('url', 500);
            $t->boolean('is_active')->default(true); $t->unsignedInteger('sort_order')->default(0); $t->timestamps();
        });

        Schema::create('message_replies', function (Blueprint $t) {
            $t->id(); $t->foreignId('contact_message_id')->constrained('contact_messages')->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('to_email'); $t->string('subject'); $t->longText('body'); $t->boolean('sent')->default(false); $t->text('error')->nullable(); $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_replies');
        Schema::dropIfExists('social_links');
        Schema::table('users', function (Blueprint $t) { $t->dropColumn('avatar'); });
    }
};
