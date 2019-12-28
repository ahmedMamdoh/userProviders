<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\UserProvider;
class UserProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function get_all_users_test(){
        $user_provider = factory(UserProvider::class)->create();
        $another_user_provider = factory(UserProvider::class)->create();
        $response      = $this->get('api/v1/users');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$user_provider->id,'id'=>$another_user_provider->id]);
    }

    /** @test */
      public function provider_filter_test(){
        $user_provider = factory(UserProvider::class)->create(['provider'=>'DataProviderX']);
        $another_user_provider = factory(UserProvider::class)->create(['provider'=>'DataProviderY']);
        $response      = $this->get('api/v1/users?provider=DataProviderX');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$user_provider->id]);
        $response->assertJsonMissing(['id'=>$another_user_provider->id]);
    }
       /** @test */
    public function currency_filter_test(){
        $user_provider = factory(UserProvider::class)->create(['currency'=>'EGP']);
        $another_user_provider = factory(UserProvider::class)->create(['currency'=>'USD']);
        $response      = $this->get('api/v1/users?currency=EGP');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$user_provider->id]);
        $response->assertJsonMissing(['id'=>$another_user_provider->id]);
    }

      /** @test */
    public function authorised_status_filter_test(){
        $authorised_user_provider = factory(UserProvider::class)->create(['status'=>'1']);
        $another_authorised_user_provider = factory(UserProvider::class)->create(['status'=>'100']);
        $unauthorised_user_provider = factory(UserProvider::class)->create(['status'=>'2']);
        $response      = $this->get('api/v1/users?statusCode=authorised');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$authorised_user_provider->id, 'id'=>$another_authorised_user_provider->id]);
        $response->assertJsonMissing(['id'=>$unauthorised_user_provider->id]);
    }

     /** @test */
     public function decline_status_filter_test(){
        $declined_user_provider = factory(UserProvider::class)->create(['status'=>'2']);
        $another_declined_user_provider = factory(UserProvider::class)->create(['status'=>'200']);
        $not_declined_user_provider = factory(UserProvider::class)->create(['status'=>'3']);
        $response      = $this->get('api/v1/users?statusCode=decline');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$declined_user_provider->id, 'id'=>$another_declined_user_provider->id ]);
        $response->assertJsonMissing(['id'=>$not_declined_user_provider->id]);
    }

     /** @test */
     public function refunded_status_filter_test(){
        $refunded_user_provider = factory(UserProvider::class)->create(['status'=>'3']);
        $another_refunded_user_provider = factory(UserProvider::class)->create(['status'=>'300']);
        $not_refunded_user_provider = factory(UserProvider::class)->create(['status'=>'1']);
        $response      = $this->get('api/v1/users?statusCode=refunded');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$refunded_user_provider->id, 'id'=>$another_refunded_user_provider->id ]);
        $response->assertJsonMissing(['id'=>$not_refunded_user_provider->id]);
    }

     /** @test */
     public function balance_range_filter_test(){
        $min_balance = factory(UserProvider::class)->create(['balance'=>'200']);
        $max_balance = factory(UserProvider::class)->create(['balance'=>'500']);
        $min_balance_out_of_range = factory(UserProvider::class)->create(['balance'=>'1000']);
        $max_balance_out_of_range = factory(UserProvider::class)->create(['balance'=>'2000']);
        $response      = $this->get('api/v1/users?balanceMin=200&balanceMax=500');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$min_balance->id, 'id'=>$max_balance->id ]);
        $response->assertJsonMissing(['id'=>$min_balance_out_of_range->id, 'id'=>$max_balance_out_of_range->id]);
    }

     /** @test */
     public function combined_filter_test(){
        $user_provider = factory(UserProvider::class)->create(['provider'=>'DataProviderX', 'balance' => '200', 'currency' => 'EUR', 'status' => '1']);
        $another_user_provider = factory(UserProvider::class)->create(['provider'=>'DataProviderY', 'balance' => '500', 'currency' => 'USD', 'status' => '2']);
        
        $response      = $this->get('api/v1/users?provider=DataProviderX&balanceMin=200&balanceMax=500&currency=EUR&statusCode=1');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id'=>$user_provider->id]);
        $response->assertJsonMissing(['id'=>$another_user_provider->id]);
    }
 
}
