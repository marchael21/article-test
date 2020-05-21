<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('contact_number', 50)->nullable()->default(null);
            $table->integer('role_id')->unsigned()->index();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->boolean('dev')->nullable()->default(null);
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            // $table->boolean('status')->nullable()->default(0);
            $table->boolean('active')->nullable()->default(0);
            $table->boolean('block')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('users', function($table) {
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
        });

        $data = array(
            array(
                'name'                  => 'Admin Demo',
                'username'              => 'admin',
                'email'                 => 'admindemo@test.com',
                'email_verified_at'     => date('Y-m-d H:i:s'),
                'contact_number'        => NULL,
                'role_id'               => 1,
                'password'              => Hash::make('password1234'),
                'api_token'             => Str::random(80),
                'remember_token'        => null,
                'dev'                   => 1,
                'facebook_id'           => null, 
                'google_id'             => null,
                'last_login_at'         => null,
                'last_login_ip'         => null,
                'active'                => 1,
                'block'                 => 0,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ),
            array(
                'name'                  => 'User Demo',
                'username'              => 'user',
                'email'                 => 'userdemo@test.com',
                'email_verified_at'     => date('Y-m-d H:i:s'),
                'contact_number'        => NULL,
                'role_id'               => 2,
                'password'              => Hash::make('password1234'),
                'api_token'             => Str::random(80),
                'remember_token'        => null,
                'dev'                   => null,
                'facebook_id'           => null, 
                'google_id'             => null,
                'last_login_at'         => null,
                'last_login_ip'         => null,
                'active'                => 1,
                'block'                 => 0,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ),        
        );

        DB::table('users')->insert($data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
