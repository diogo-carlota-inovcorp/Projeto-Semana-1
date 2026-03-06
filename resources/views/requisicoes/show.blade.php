<x-layouts.layout>

        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Requisição {{ $requisicao->codigo ?? ('REQ-' . str_pad($requisicao->id, 4, '0', STR_PAD_LEFT)) }}</h1>

                <a href="{{ route('requisicoes.minhas') }}" class="btn btn-outline-secondary">
                    Voltar
                </a>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h4 class="mb-4">Informações da Requisição</h4>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Código</small>
                                    <strong>{{ $requisicao->codigo ?? ('REQ-' . str_pad($requisicao->id, 4, '0', STR_PAD_LEFT)) }}</strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Status</small>
                                    <strong>{{ ucfirst($requisicao->status) }}</strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Data da Requisição</small>
                                    <strong>{{ optional($requisicao->created_at)->format('d/m/Y H:i') }}</strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Data Prevista Devolução</small>
                                    <strong>{{ $requisicao->fim_previsto ? \Carbon\Carbon::parse($requisicao->fim_previsto)->format('d/m/Y') : '-' }}</strong>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block">Devolução Real</small>
                                    <strong>
                                        {{ $requisicao->status === 'entregue' ? optional($requisicao->updated_at)->format('d/m/Y H:i') : '-' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="mb-4">Livro</h4>

                            <div class="d-flex gap-4 align-items-start">
                                <div>
                                    @if(!empty($requisicao->livro->imagem_capa))
                                        <img src="{{ asset('storage/' . $requisicao->livro->imagem_capa) }}"
                                             alt="{{ $requisicao->livro->nome }}"
                                             style="width:120px;height:170px;object-fit:cover;border-radius:10px;">
                                    @else
                                        <div style="width:120px;height:170px;background:#ddd;border-radius:10px;"></div>
                                    @endif
                                </div>

                                <div>
                                    <h5 class="mb-2">{{ $requisicao->livro->nome ?? 'Sem nome' }}</h5>

                                    <div class="mb-1">
                                        <strong>ISBN:</strong> {{ $requisicao->livro->isbn ?? '-' }}
                                    </div>

                                    <div class="mb-1">
                                        <strong>Editora:</strong> {{ $requisicao->livro->editora->nome ?? '-' }}
                                    </div>

                                    @if(!empty($requisicao->livro->preco))
                                        <div class="mb-1">
                                            <strong>Preço:</strong> € {{ number_format($requisicao->livro->preco, 2, ',', '.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="mb-4">Cidadão</h4>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img
                                    src="{{ $requisicao->user->foto_perfil ? asset('storage/' . $requisicao->user->foto_perfil) : asset('images/default-avatar.png') }}"
                                    alt="{{ $requisicao->user->name }}"
                                    style="width:70px;height:70px;object-fit:cover;border-radius:50%;border:2px solid #ccc;"
                                >

                                <div>
                                    <div class="fw-bold">{{ $requisicao->user->name }}</div>
                                    <div class="text-muted">{{ $requisicao->user->email }}</div>
                                </div>
                            </div>

                            <a href="{{ route('admin.users.requisicoes', $requisicao->user) }}" class="btn btn-outline-primary w-100">
                                Ver Histórico do Cidadão
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-layouts.layout>
