<x-layouts.layout title="Reviews">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Moderação de Reviews</h1>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>Livro</th>
                    <th>Cidadão</th>
                    <th>Rating</th>
                    <th>Estado</th>
                    <th>Data</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->livro->nome }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td>{{ ucfirst($review->estado) }}</td>
                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-primary">
                                Moderar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Sem reviews.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>

</x-layouts.layout>
