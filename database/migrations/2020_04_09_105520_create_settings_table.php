<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ar_title')->nullable();
            $table->string('en_title')->nullable();
            $table->longText('ar_desc')->nullable();
            $table->longText('en_desc')->nullable();

            $table->string('tax_number')->nullable();
            $table->double('tax')->default(1);
            $table->string('units')->nullable();
            $table->date('start_fiscal_year')->nullable();
            $table->date('end_fiscal_year')->nullable();

            $table->string('email1')->nullable();
            $table->string('email2')->nullable();

            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();


            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();

            $table->string('login_banner')->nullable();
            $table->string('image_slider')->nullable();

            $table->longText('ar_footer_desc')->nullable();
            $table->longText('en_footer_desc')->nullable();
            $table->string('company_profile_pdf')->nullable();


            $table->string('terms_condition_link')->nullable();
            $table->string('about_us_link')->nullable();
            $table->string('privacy_policy_link')->nullable();


            $table->string('fax')->nullable();

            $table->string('android_app')->nullable();
            $table->string('ios_app')->nullable();

            $table->string('link')->nullable();

            $table->string('sms_user_name')->nullable();
            $table->string('sms_user_pass')->nullable();

            $table->string('sms_sender')->nullable();

            $table->string('publisher')->nullable();

            $table->string('default_language')->default('ar');
            $table->string('default_theme')->nullable();
            $table->string('offer_muted')->nullable();
            $table->integer('offer_notification')->default(1);

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('telegram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('snapchat_ghost')->nullable();
            $table->string('whatsapp')->nullable();

            $table->longText('ar_about_app')->nullable();
            $table->longText('en_about_app')->nullable();
            $table->longtext('ar_terms_condition')->nullable();
            $table->longtext('en_terms_condition')->nullable();
            $table->longText('privacy_policy')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
