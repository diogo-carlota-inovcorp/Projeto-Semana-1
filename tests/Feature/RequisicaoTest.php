// tests/Feature/RequisicaoTest.php
<?php

use App\Models\User;
use App\Models\Livro;
use App\Models\Requisicao;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->actingAs($this->user);
});

// Teste 1: Criação de Requisição de Livro
test('utilizador pode criar uma requisição de livro corretamente', function () {
    $livro = Livro::factory()->create();

    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    $this->assertDatabaseHas('requisicoes', [
        'user_id' => $this->user->id,
        'livro_id' => $livro->id,
        'status' => 'pendente',
    ]);

    $response->assertRedirect(route('requisicoes.minhas'));
    $response->assertSessionHas('success');
});

// Teste 2: Validação de Requisição
test('nao pode criar requisicao sem um livro valido', function () {
    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => 99999,
    ]);

    $response->assertSessionHasErrors('livro_id');
    $response->assertRedirect();
});

// Teste 3: Devolução de Livro
test('utilizador pode pedir devolucao de um livro', function () {
    $livro = Livro::factory()->create();

    // Criar requisição com status 'ativa' (ou 'pendente')
    $requisicao = Requisicao::factory()->create([
        'user_id' => $this->user->id,
        'livro_id' => $livro->id,
        'status' => 'ativa', // Usar 'ativa' que é permitido no controller
        'requisitado_em' => now(),
        'fim_previsto' => now()->addDays(5),
    ]);

    $response = $this->patch(route('requisicoes.pedirDevolucao', $requisicao));

    $requisicao->refresh();

    // No controller, o status muda para 'por_confirmar'
    expect($requisicao->status)->toBe('por_confirmar');

    $response->assertRedirect(route('requisicoes.minhas'));
    $response->assertSessionHas('success');
});

// Teste 4: Listagem de Requisições por Utilizador
test('utilizador consegue ver apenas as suas requisicoes', function () {
    $outroUser = User::factory()->create(['role' => 'user']);

    // Criar requisições para o utilizador atual
    $requisicoesUser = Requisicao::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'status' => 'pendente'
    ]);

    // Criar requisições para outro utilizador
    $requisicoesOutroUser = Requisicao::factory()->count(2)->create([
        'user_id' => $outroUser->id,
        'status' => 'pendente'
    ]);

    $response = $this->get(route('requisicoes.minhas'));

    $response->assertOk();

    foreach ($requisicoesUser as $requisicao) {
        $response->assertSee($requisicao->id);
    }
});

// Teste 5: Limite de 3 requisições simultâneas
test('utilizador nao pode ter mais de 3 requisicoes simultaneas', function () {
    $livros = Livro::factory()->count(4)->create();

    // Criar 3 requisições ativas
    for ($i = 0; $i < 3; $i++) {
        Requisicao::factory()->create([
            'user_id' => $this->user->id,
            'livro_id' => $livros[$i]->id,
            'status' => 'pendente',
            'requisitado_em' => now(),
            'fim_previsto' => now()->addDays(5),
        ]);
    }

    // Tentar criar a 4ª requisição
    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livros[3]->id,
    ]);

    $response->assertSessionHas('error', 'Só podes ter 3 livros requisitados em simultâneo.');

    // Verificar que a 4ª requisição não foi criada
    $this->assertDatabaseMissing('requisicoes', [
        'user_id' => $this->user->id,
        'livro_id' => $livros[3]->id,
    ]);
});

// Teste 6: Não pode requisitar livro já ocupado
test('nao pode requisitar livro que ja esta em requisicao', function () {
    $livro = Livro::factory()->create();
    $outroUser = User::factory()->create(['role' => 'user']);

    // Outro utilizador já requisitou o livro
    Requisicao::factory()->create([
        'user_id' => $outroUser->id,
        'livro_id' => $livro->id,
        'status' => 'pendente',
        'requisitado_em' => now(),
        'fim_previsto' => now()->addDays(5),
    ]);

    // Tentar requisitar o mesmo livro
    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    $response->assertSessionHas('error', 'Este livro já está em processo de requisição.');

    // Verificar que a requisição não foi criada
    $this->assertDatabaseMissing('requisicoes', [
        'user_id' => $this->user->id,
        'livro_id' => $livro->id,
    ]);
});

// tests/Feature/RequisicaoTest.php
test('nao pode requisitar livro sem stock disponivel', function () {
    // Criar um livro com stock = 0
    $livro = Livro::factory()->create(['stock' => 0]);

    // Tentar criar uma requisição
    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    // Verificar se retorna erro de stock
    $response->assertSessionHas('error', 'Este livro não tem stock disponível no momento.');

    // Verificar que a requisição NÃO foi criada
    $this->assertDatabaseMissing('requisicoes', [
        'user_id' => $this->user->id,
        'livro_id' => $livro->id,
    ]);

    // Verificar que o stock continua 0
    $this->assertEquals(0, $livro->fresh()->stock);
});

test('stock e reduzido quando livro e requisitado', function () {
    // Criar um livro com stock = 5
    $livro = Livro::factory()->create(['stock' => 5]);

    // Fazer requisição
    $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    // Verificar que o stock foi reduzido para 4
    $this->assertEquals(4, $livro->fresh()->stock);
});

test('stock e reposto quando livro e devolvido', function () {
    // Criar um livro com stock = 5
    $livro = Livro::factory()->create(['stock' => 5]);

    // FAZER A REQUISIÇÃO PELO CONTROLLER (não pela factory)
    $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    // Buscar a requisição criada
    $requisicao = Requisicao::where('user_id', $this->user->id)
        ->where('livro_id', $livro->id)
        ->first();

    // Stock atual deve ser 4 (porque a requisição reduziu)
    expect($livro->fresh()->stock)->toBe(4);

    // Mudar o status da requisição para 'por_confirmar' (como se o user pedisse devolução)
    $requisicao->update(['status' => 'por_confirmar']);

    // Admin confirma a devolução
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $response = $this->patch(route('admin.requisicoes.confirmarDevolucao', $requisicao));

    // Verificar que o stock voltou a 5
    $this->assertEquals(5, $livro->fresh()->stock);

    $response->assertRedirect();
    $response->assertSessionHas('success');



});
