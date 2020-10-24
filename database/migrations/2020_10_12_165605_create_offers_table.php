<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('request_id');
            $table->string('lead_id');
            $table->string('deal_id');
            $table->integer('supplier_type');
            $table->text('project_name');
            $table->text('project_type');
            $table->integer('advance');
            $table->integer('leasing_term');
            $table->string('amount_of_financing');
            $table->text('leasing_object_name');
            $table->integer('quantity');
            $table->string('insurance_program');
            $table->string('franchise');
            $table->text('non_standart_comment')->nullable();
            $table->string('lead_source');
            $table->text('agent_info')->nullable();
            $table->text('front_manager_comment')->nullable();
            $table->text('supplier_name');
            $table->string('leasing_amount_dkp');
            $table->text('availability_leasing_object')->nullable();
            $table->string('supplier_prepayment')->nullable();
            $table->string('preliminary_financing')->nullable();
            $table->string('gps_tracker')->nullable();
            $table->text('contact_name')->nullable();
            $table->text('contact_position')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('service_agreement')->nullable();
            $table->text('fuel_card_agreement')->nullable();
            $table->string('signing_agreement_date')->nullable();
            $table->string('advance_payment_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('shipment_leasing_object')->nullable();
            $table->string('shipment_city')->nullable();
            $table->string('finance_monitor')->nullable();
            $table->text('real_owner')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('front_manager')->nullable();
            $table->string('middle_manager')->nullable();
            $table->string('sales_director')->default('Нечаєв В.Є.');
            $table->timestamps();
            $table->index(['request_id', 'lead_id', 'deal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
