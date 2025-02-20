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
        Schema::create('monthly_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->string('year');
            $table->tinyInteger('month');
            $table->decimal('savings')->default(0);
            $table->decimal('down_payment_amount')->default(0)->comment('debt tirna pay gareko amount');
            $table->decimal('interest')->default(0);
            $table->decimal('fined')->default(0);
            $table->decimal('total_collected_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('monthly_collections', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->tinyInteger('month');
            $table->decimal('total_collected_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('final_savings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->decimal('total_savings')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('monthly_invested_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->string('year');
            $table->tinyInteger('month');
            $table->decimal('debt_amount')->default(0);
            $table->decimal('charges')->default(0);
            $table->decimal('final_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('remaining_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->decimal('debt_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('total_debt_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->decimal('total_debt_collected_till_now')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('monthly_down_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('member_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index('user_id');
            $table->decimal('down_payment_amount')->default(0);
            $table->string('year');
            $table->tinyInteger('month');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function(Blueprint $table){
            $table->foreignId('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade')->after('email');
            $table->softDeletes();
        });

        // Schema::create('activities', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('activity',['montly'])
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('monthly_down_payments');
        Schema::dropIfExists('total_debt_collections');
        Schema::dropIfExists('remaining_debts');
        Schema::dropIfExists('monthly_invested_debts');
        Schema::dropIfExists('final_savings');
        Schema::dropIfExists('monthly_collections');
        Schema::dropIfExists('monthly_transactions');
    }
};
