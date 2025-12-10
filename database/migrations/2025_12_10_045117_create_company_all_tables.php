<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    /* ------------------------------------------------------
        | 1. COMPANIES (MAIN TENANT TABLE)
        ------------------------------------------------------ */
    Schema::table('companies', function (Blueprint $table) {
      $table->string('slug')->unique();
      $table->string('white_logo')->nullable();
      $table->string('black_logo')->nullable();
      $table->string('favicon')->nullable();
      $table->string('phone')->nullable();
      $table->string('whatsapp')->nullable();
      $table->string('website')->nullable();
      $table->string('address_line1')->nullable();
      $table->string('address_line2')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('country')->nullable();
      $table->string('pincode')->nullable();
      $table->string('timezone')->default('Asia/Kolkata');
      $table->string('date_format')->default('d-m-Y');
      $table->string('currency')->default('INR');
      $table->unsignedBigInteger('plan_id')->nullable();
      $table->date('financial_year_start')->nullable();
      $table->date('financial_year_end')->nullable();
      $table->timestamp('trial_ends_at')->nullable();
      $table->boolean('is_active')->default(1);
    });

    /* ------------------------------------------------------
        | 2. COMPANY SETTINGS (KEY-VALUE)
        ------------------------------------------------------ */
    Schema::create('company_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('key');
      $table->longText('value')->nullable(); // JSON or string
      $table->timestamps();
    });

    /* ------------------------------------------------------
        | 3. SOCIAL LINKS
        ------------------------------------------------------ */
    Schema::table('social_links', function (Blueprint $table) {
      $table->json('style')->nullable();
      $table->boolean('is_active')->default(true);
      $table->integer('sort_order')->default(0);
    });

    /* ------------------------------------------------------
        | 4. COMPANY BRANDING (UI/UX CUSTOMIZATION)
        ------------------------------------------------------ */
    Schema::create('company_branding', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('theme_color')->nullable();
      $table->string('theme_secondary_color')->nullable();
      $table->string('sidebar_color')->nullable();
      $table->string('navbar_color')->nullable();
      $table->string('button_style')->nullable(); //-rounded/pill
      $table->string('font_family')->nullable();
      $table->boolean('dark_mode_enabled')->default(false);
      $table->string('login_background_image')->nullable();
      $table->text('welcome_text')->nullable();
      $table->longText('custom_css')->nullable();
      $table->longText('custom_js')->nullable();
      $table->timestamps();
    });

    /* ------------------------------------------------------
        | 5. COMPANY CONTACTS (OPTIONAL MULTIPLE)
        ------------------------------------------------------ */
    Schema::table('company_contacts', function (Blueprint $table) {
      $table->string('label'); // Support, Billing, HR
      $table->boolean('is_primary')->default(false);

    });

    /* ------------------------------------------------------
        | 6. PAYMENT SETTINGS (PHONEPE/RAZORPAY/STRIPE)
        ------------------------------------------------------ */
    Schema::create('company_payment_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('gateway_name');     // phonepe/stripe/paypal
      $table->string('merchant_id')->nullable();
      $table->string('api_key')->nullable();
      $table->string('api_secret')->nullable();
      $table->string('salt_key')->nullable();
      $table->string('salt_index')->nullable();
      $table->string('webhook_secret')->nullable();
      $table->boolean('is_active')->default(true);
      $table->string('mode')->default('test'); // test/live
      $table->timestamps();
    });

    /* ------------------------------------------------------
        | 7. STORAGE SETTINGS (S3, DO SPACES, LOCAL)
        ------------------------------------------------------ */
    Schema::create('company_storage_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('disk_type')->default('local'); // s3/local/spaces
      $table->string('bucket')->nullable();
      $table->string('access_key')->nullable();
      $table->string('secret_key')->nullable();
      $table->string('region')->nullable();
      $table->string('folder_path')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    /* ------------------------------------------------------
        | 8. SECURITY SETTINGS
        ------------------------------------------------------ */
    Schema::create('company_security_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->boolean('two_factor_enabled')->default(false);
      $table->integer('max_login_attempts')->default(5);
      $table->integer('lockout_minutes')->default(15);
      $table->json('allowed_ip_range')->nullable();
      $table->json('block_countries')->nullable();
      $table->timestamps();
    });

    /* ------------------------------------------------------
        | 9. INTEGRATIONS (GOOGLE, FACEBOOK, MAILCHIMP, ETC)
        ------------------------------------------------------ */
    Schema::create('company_integrations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('integration_name');
      $table->json('config')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('company_integrations');
    Schema::dropIfExists('company_security_settings');
    Schema::dropIfExists('company_storage_settings');
    Schema::dropIfExists('company_payment_settings');
    Schema::dropIfExists('company_contacts');
    Schema::dropIfExists('company_branding');
    Schema::dropIfExists('social_links');
    Schema::dropIfExists('company_settings');
    Schema::dropIfExists('companies');
  }
};
