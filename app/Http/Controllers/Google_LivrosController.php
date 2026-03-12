<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;

class Google_LivrosController extends Controller
{
    /**
     * Mostrar o formulário de pesquisa
     */
    public function index()
    {
        return view('google-books.search');
    }

    /**
     * Pesquisar livros na Google Books API
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');
        $apiKey = env('GOOGLE_BOOKS_API_KEY');

        $page = max((int) $request->input('page', 1), 1);
        $perPage = 20;
        $startIndex = ($page - 1) * $perPage;

        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $query,
            'key' => $apiKey,
            'maxResults' => $perPage,
            'startIndex' => $startIndex,
            'langRestrict' => 'pt',
        ]);

        if ($response->failed()) {
            return back()->with('erro', 'Erro ao contactar a Google Books API.')
                ->withInput();
        }

        $data = $response->json();
        $booksData = $data['items'] ?? [];
        $totalItems = $data['totalItems'] ?? 0;

        $books = [];

        foreach ($booksData as $item) {
            $volumeInfo = $item['volumeInfo'] ?? [];

            $books[] = [
                'google_books_id' => $item['id'] ?? null,
                'titulo' => $volumeInfo['title'] ?? 'Título desconhecido',
                'autores' => $volumeInfo['authors'] ?? ['Autor desconhecido'],
                'editora' => $volumeInfo['publisher'] ?? 'Editora desconhecida',
                'descricao' => $volumeInfo['description'] ?? null,
                'isbn' => $this->extractIsbn($volumeInfo['industryIdentifiers'] ?? []),
                'capa_thumbnail' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                'capa_pequena' => $volumeInfo['imageLinks']['smallThumbnail'] ?? null,
                'capa_grande' => isset($volumeInfo['imageLinks']['thumbnail'])
                    ? str_replace('zoom=1', 'zoom=2', $volumeInfo['imageLinks']['thumbnail'])
                    : null,
                'paginas' => $volumeInfo['pageCount'] ?? null,
                'data_publicacao' => $volumeInfo['publishedDate'] ?? null,
            ];
        }

        $hasNextPage = $startIndex + $perPage < $totalItems;
        $hasPreviousPage = $page > 1;

        return view('google-books.import', compact(
            'books',
            'query',
            'page',
            'hasNextPage',
            'hasPreviousPage',
            'totalItems'
        ));
    }
        public function import(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autores' => 'nullable|string',
            'editora' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'isbn' => 'nullable|string|max:255',
            'imagem_capa' => 'nullable|string',
        ]);

        $editora = \App\Models\Editora::firstOrCreate([
            'nome' => $request->editora,
        ]);

        $livro = \App\Models\Livro::where('isbn', $request->isbn)->first();

        if (!$livro) {
            $livro = new \App\Models\Livro();
        }

        $livro->isbn = $request->isbn;
        $livro->nome = $request->titulo;
        $livro->editoras_id = $editora->id;
        $livro->bibliografia = $request->descricao;
        $livro->imagem_capa = $request->imagem_capa;
        $livro->preco = 0;
        $livro->save();

        if ($request->filled('autores')) {
            $nomesAutores = array_map('trim', explode(',', $request->autores));

            foreach ($nomesAutores as $nomeAutor) {
                if ($nomeAutor === '') {
                    continue;
                }

                $autor = \App\Models\Autor::firstOrCreate([
                    'nome' => $nomeAutor
                ]);

                $livro->autores()->syncWithoutDetaching([$autor->id]);
            }
        }

        return redirect()->route('livros.show', $livro->id);
    }


    private function extractIsbn($identifiers)
    {
        if (empty($identifiers)) {
            return null;
        }

        foreach ($identifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_13') {
                return $identifier['identifier'];
            }
        }

        foreach ($identifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_10') {
                return $identifier['identifier'];
            }
        }

        return null;
    }


    public function apiSearch(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('GOOGLE_BOOKS_API_KEY');

        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $query,
            'key' => $apiKey,
            'maxResults' => 20,
        ]);

        return response()->json($response->json());
    }
}
