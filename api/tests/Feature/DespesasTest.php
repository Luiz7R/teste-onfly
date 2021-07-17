<?php

namespace Tests\Feature;

use App\Models\Despesas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DespesasTest extends TestCase
{

    use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_despesa()
    {
        // Prepare User Login

         //   $user = User::factory()->create();


         //   $credentials = [
         //        'email' => $user->email,
         //        'password' => 'password'
         //   ];

         //   $response = $this->post(route('auth.user'), $credentials);


        // Create Despesa

         //   $post = Despesas::factory()->create();

         //   $data = $post->only(['descricao', 'valor', 'id_usuario']);
         //   $data['data_criacao'] = Carbon::now();

         //   Despesas::create($data);

         //   $response = $this->post(route('new-post'), $data);

         //   $response->assertStatus(302);
    }


   /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_delete_despesa()
    {
        // Prepare User Login

         //   $user = User::factory()->create();
           
         //   $credentials = [
         //        'email' => $user->email,
         //        'password' => 'password'
         //   ];

         //   $this->post(route('auth.user'), $credentials);


        // Create Post

         //   $Despesa = Despesas::factory()->create();
         //   $DespesaId =  $Despesa->id;

         //   $data = $Despesa->only(['descricao', 'valor', 'id_usuario']);

         //   Despesas::create($data);

         //   $this->post(route('new-post'), $data);

         //   $response = $this->get( route('del-post', ['id' => $DespesaId]) );

         //   $response->assertStatus(200);
    }



   /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_update_despesa()
    {
        // Prepare User Login

         //   $user = User::factory()->create();

         //   $credentials = [
         //        'email' => $user->email,
         //        'password' => 'password'
         //   ];

         //   $this->post(route('auth.user'), $credentials);


        // Create Despesas

         //   $despesaFac = Despesas::factory()->create();
         //   $despesaId =  $despesaFac->id;

         //   $data = $despesaFac->only(['descricao', 'valor', 'id_usuario']);

         //   $Despesa = Despesas::create($data);

         //   $this->post(route('new-post'), $data);

         //   $DespesaData = [
         //       'id' => $despesaId,
         //       'descricao' => 'Description test Update',
         //       'valor' => 10000
         //   ];

         //   $response = $this->post( route('update-post'), $DespesaData );

         //   $response->assertStatus(200);
    }

}


