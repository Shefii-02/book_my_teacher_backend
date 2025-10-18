<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderCredentialsTable extends Migration
{
    public function up()
    {
        Schema::create('provider_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stream_provider_id')->constrained('stream_providers')->onDelete('cascade');
            $table->string('app_id')->nullable();
            $table->string('app_sign')->nullable();
            $table->string('server_secret')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->json('extra_config')->nullable(); // store extra fields per provider
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('provider_credentials');
    }
}
