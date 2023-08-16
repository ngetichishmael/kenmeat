<?php

use App\Models\customer\customers;
use App\Models\products\product_information;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returnables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('quantity')->default(0);
            $table->enum('status', ['Not Returned', 'Returned'])->default('Not Returned');
            $table->date('expiry_date')->nullable();
            $table->foreignIdFor(customers::class);
            $table->foreignIdFor(product_information::class);
            $table->foreignIdFor(User::class);
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
        Schema::dropIfExists('returnables');
    }
}
